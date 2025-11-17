<?php

class Analysis
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    private function getPeriodCondition($period, $date_from = null, $date_to = null)
    {
        if ($period === 'custom' && $date_from && $date_to) {
            return "transaction_date BETWEEN :date_from AND :date_to";
        }

        switch ($period) {
            case "monthly":
                return "transaction_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
            case "quarterly":
                return "transaction_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
            case "semiannual":
                return "transaction_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";
            case "yearly":
                return "transaction_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
            default:
                return "1=1";
        }
    }

    public function getSummary($user_id, $family_id, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT
            SUM(CASE WHEN type='income' THEN amount ELSE 0 END) AS income,
            SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) AS expense
        FROM transactions
        WHERE ($cond) AND (family_id = :family_id OR user_id = :user_id)
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ];

        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params)[0];
    }

    public function getCategoryBreakdown($user_id, $family_id, $period = 'monthly', $type = 'expense', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT c.name, SUM(ti.amount * ti.quantity) as total
        FROM transaction_items ti
        JOIN transactions t ON t.id = ti.transaction_id
        JOIN categories c ON c.id = ti.category_id
        WHERE ($cond) AND t.type = :type AND (t.family_id = :family_id OR t.user_id = :user_id)
        GROUP BY c.id
        ORDER BY total DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type
        ];

        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    public function getCategoryPercentages($user_id, $family_id, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $categories = $this->getCategoryBreakdown($user_id, $family_id, $period, 'expense', $date_from, $date_to);

        $total = 0;
        foreach ($categories as $c) {
            $total += $c['total'];
        }

        foreach ($categories as &$c) {
            $c['percent'] = $total > 0 ? round(($c['total'] / $total) * 100, 2) : 0;
        }

        return $categories;
    }

    public function getTrend($user_id, $family_id, $period = 'monthly', $type = 'expense', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT DATE(transaction_date) AS date, SUM(amount) AS total
        FROM transactions
        WHERE ($cond) AND type = :type AND (family_id = :family_id OR user_id = :user_id)
        GROUP BY DATE(transaction_date)
        ORDER BY date ASC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type
        ];

        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    public function getTopExpenses($user_id, $family_id, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT t.description, t.amount, t.transaction_date
        FROM transactions t
        WHERE ($cond)
          AND t.type='expense'
          AND (t.family_id = :family_id OR t.user_id = :user_id)
        ORDER BY t.amount DESC
        LIMIT 5
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ];

        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    public function getFamilySpending($family_id)
    {
        $sql = "
        SELECT 
            u.username,
            SUM(t.amount) AS total_spent,
            COUNT(t.id) AS transactions,
            AVG(t.amount) AS avg_spent
        FROM transactions t
        JOIN users u ON u.id = t.user_id
        WHERE t.family_id = :family_id AND t.type='expense'
        GROUP BY u.id
        ORDER BY total_spent DESC
        ";

        return $this->db->select($sql, [':family_id' => $family_id]);
    }

    public function getRegionalComparison($period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            f.region,
            SUM(t.amount) AS total_spent,
            COUNT(t.id) AS transactions,
            AVG(t.amount) AS avg_spent
        FROM transactions t
        JOIN families f ON f.id = t.family_id
        WHERE ($cond) AND t.type='expense'
        GROUP BY f.region
        ORDER BY total_spent DESC
        ";

        $params = [];
        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    public function getPaymentMethodBreakdown($user_id, $family_id, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            payment_method,
            SUM(amount) AS total_spent
        FROM transactions
        WHERE ($cond) AND type='expense'
          AND (family_id = :family_id OR user_id = :user_id)
        GROUP BY payment_method
        ORDER BY total_spent DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ];

        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    public function getSubCategoryExpenses($user_id, $family_id, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
    SELECT sc.name AS sub_category, SUM(ti.amount * ti.quantity) AS total
    FROM transaction_items ti
    JOIN transactions t ON t.id = ti.transaction_id
    JOIN sub_categories sc ON sc.id = ti.sub_category_id
    WHERE ($cond)
      AND t.type = 'expense'
      AND (t.family_id = :family_id OR t.user_id = :user_id)
    GROUP BY sc.id
    ORDER BY total DESC
    ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ];

        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }
}
