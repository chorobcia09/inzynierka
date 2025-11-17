<?php

class Analysis
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    private function getPeriodCondition($period)
    {
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

    public function getSummary($user_id, $family_id, $period)
    {
        $cond = $this->getPeriodCondition($period);

        $sql = "
        SELECT
            SUM(CASE WHEN type='income' THEN amount ELSE 0 END) AS income,
            SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) AS expense
        FROM transactions
        WHERE ($cond) AND (family_id = :family_id OR user_id = :user_id)
        ";

        return $this->db->select($sql, [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ])[0];
    }

    public function getCategoryBreakdown($user_id, $family_id, $period, $type = 'expense')
    {
        $cond = $this->getPeriodCondition($period);

        $sql = "
        SELECT c.name, SUM(ti.amount * ti.quantity) as total
        FROM transaction_items ti
        JOIN transactions t ON t.id = ti.transaction_id
        JOIN categories c ON c.id = ti.category_id
        WHERE ($cond) AND t.type = :type AND (t.family_id = :family_id OR t.user_id = :user_id)
        GROUP BY c.id
        ORDER BY total DESC
    ";

        return $this->db->select($sql, [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type
        ]);
    }

    public function getCategoryPercentages($user_id, $family_id, $period)
    {
        // Pobierz wydatki wg kategorii
        $categories = $this->getCategoryBreakdown($user_id, $family_id, $period);

        // Oblicz sumę wszystkich wydatków
        $total = 0;
        foreach ($categories as $c) {
            $total += $c['total'];
        }

        // Dodaj procent do każdej kategorii
        foreach ($categories as &$c) {
            $c['percent'] = $total > 0 ? round(($c['total'] / $total) * 100, 2) : 0;
        }

        return $categories;
    }


    public function getTrend($user_id, $family_id, $period, $type = 'expense')
    {
        $cond = $this->getPeriodCondition($period);

        $sql = "
        SELECT DATE(transaction_date) AS date, SUM(amount) AS total
        FROM transactions
        WHERE ($cond) AND type = :type AND (family_id = :family_id OR user_id = :user_id)
        GROUP BY DATE(transaction_date)
        ORDER BY date ASC
    ";

        return $this->db->select($sql, [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type
        ]);
    }


    public function getTopExpenses($user_id, $family_id, $period)
    {
        $cond = $this->getPeriodCondition($period);

        $sql = "
        SELECT t.description, t.amount, t.transaction_date
        FROM transactions t
        WHERE ($cond)
          AND t.type='expense'
          AND (t.family_id = :family_id OR t.user_id = :user_id)
        ORDER BY t.amount DESC
        LIMIT 5
        ";

        return $this->db->select($sql, [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ]);
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

    public function getRegionalComparison($period)
    {
        $cond = $this->getPeriodCondition($period);

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

        return $this->db->select($sql);
    }

    public function getPaymentMethodBreakdown($user_id, $family_id, $period)
    {
        $cond = $this->getPeriodCondition($period);

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

        return $this->db->select($sql, [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ]);
    }

    public function getSubCategoryBreakdown($user_id, $family_id, $category_id, $period)
    {
        $cond = $this->getPeriodCondition($period);

        $sql = "
        SELECT 
            sc.name AS sub_category,
            SUM(ti.amount * ti.quantity) AS total
        FROM transaction_items ti
        JOIN transactions t ON t.id = ti.transaction_id
        JOIN sub_categories sc ON sc.id = ti.sub_category_id
        WHERE ($cond)
          AND (t.family_id = :family_id OR t.user_id = :user_id)
          AND ti.category_id = :category_id
          AND t.type = 'expense'
        GROUP BY sc.id
        ORDER BY total DESC
    ";

        return $this->db->select($sql, [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':category_id' => $category_id
        ]);
    }
}
