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

    /** AKTYWNE WALUTY */
    public function getActiveCurrencies($user_id, $family_id, $period, $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT DISTINCT currency 
        FROM transactions 
        WHERE ($cond) AND (family_id = :family_id OR user_id = :user_id)
        AND currency IS NOT NULL AND currency != ''
        ORDER BY currency
        ";

        $params = [':family_id' => $family_id, ':user_id' => $user_id];

        if ($period === 'custom' && $date_from && $date_to) {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        $result = $this->db->select($sql, $params);

        // Jeśli brak walut, zwróć domyślną
        if (empty($result)) {
            return [['currency' => 'PLN']];
        }

        return $result;
    }

    /** PODSUMOWANIE */
    public function getSummary($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT
            SUM(CASE WHEN type='income' THEN amount ELSE 0 END) AS income,
            SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) AS expense
        FROM transactions
        WHERE ($cond) 
          AND (family_id = :family_id OR user_id = :user_id)
          AND currency = :currency
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params)[0];
    }

    /** ROZBICIE NA KATEGORIE - dla transaction_items */
    public function getCategoryBreakdown($user_id, $family_id, $currency, $period = 'monthly', $type = 'expense', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT c.name, SUM(ti.amount * ti.quantity) as total
        FROM transaction_items ti
        JOIN transactions t ON t.id = ti.transaction_id
        JOIN categories c ON c.id = ti.category_id
        WHERE ($cond) 
          AND t.type = :type 
          AND t.currency = :currency
          AND (t.family_id = :family_id OR t.user_id = :user_id)
        GROUP BY c.id
        ORDER BY total DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** ROZBICIE NA KATEGORIE - dla transactions (bez items) */
    public function getCategoryBreakdownSimple($user_id, $family_id, $currency, $period = 'monthly', $type = 'expense', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT c.name, SUM(t.amount) as total
        FROM transactions t
        JOIN categories c ON c.id = t.category_id
        WHERE ($cond) 
          AND t.type = :type 
          AND t.currency = :currency
          AND (t.family_id = :family_id OR t.user_id = :user_id)
        GROUP BY c.id
        ORDER BY total DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** PROCENTOWY UDZIAŁ KATEGORII */
    public function getCategoryPercentages($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $categories = $this->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);

        $total = 0;
        foreach ($categories as $c) {
            $total += $c['total'];
        }

        foreach ($categories as &$c) {
            $c['percent'] = $total > 0 ? round(($c['total'] / $total) * 100, 2) : 0;
        }

        return $categories;
    }

    /** TREND WYDATKÓW / PRZYCHODÓW */
    public function getTrend($user_id, $family_id, $currency, $period = 'monthly', $type = 'expense', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT DATE(transaction_date) AS date, SUM(amount) AS total
        FROM transactions
        WHERE ($cond) 
          AND type = :type 
          AND (family_id = :family_id OR user_id = :user_id)
          AND currency = :currency
        GROUP BY DATE(transaction_date)
        ORDER BY date ASC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** TREND DLA TRANSACTION_ITEMS */
    public function getItemTrend($user_id, $family_id, $currency, $period = 'monthly', $type = 'expense', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT DATE(t.transaction_date) AS date, SUM(ti.amount * ti.quantity) AS total
        FROM transaction_items ti
        JOIN transactions t ON t.id = ti.transaction_id
        WHERE ($cond) 
          AND t.type = :type 
          AND t.currency = :currency
          AND (t.family_id = :family_id OR t.user_id = :user_id)
        GROUP BY DATE(t.transaction_date)
        ORDER BY date ASC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':type' => $type,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** NAJWYŻSZE WYDATKI */
    public function getTopExpenses($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT t.description, t.amount, t.transaction_date
        FROM transactions t
        WHERE ($cond)
          AND t.type='expense'
          AND (t.family_id = :family_id OR t.user_id = :user_id)
          AND t.currency = :currency
        ORDER BY t.amount DESC
        LIMIT 5
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** NAJWYŻSZE WYDATKI DLA TRANSACTION_ITEMS */
    public function getTopExpenseItems($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            t.description,
            ti.amount * ti.quantity as total_amount,
            t.transaction_date,
            c.name as category_name,
            sc.name as sub_category_name
        FROM transaction_items ti
        JOIN transactions t ON t.id = ti.transaction_id
        LEFT JOIN categories c ON c.id = ti.category_id
        LEFT JOIN sub_categories sc ON sc.id = ti.sub_category_id
        WHERE ($cond)
          AND t.type='expense'
          AND t.currency = :currency
          AND (t.family_id = :family_id OR t.user_id = :user_id)
        ORDER BY total_amount DESC
        LIMIT 10
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** WYDATKI CZŁONKÓW RODZINY */
    public function getFamilySpending($family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            u.username,
            SUM(t.amount) AS total_spent,
            COUNT(t.id) AS transactions,
            AVG(t.amount) AS avg_spent
        FROM transactions t
        JOIN users u ON u.id = t.user_id
        WHERE t.family_id = :family_id 
          AND t.type='expense'
          AND t.currency = :currency
          AND ($cond)
        GROUP BY u.id
        ORDER BY total_spent DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** PORÓWNANIE REGIONALNE */
    public function getRegionalComparison($currency, $period = 'monthly', $date_from = null, $date_to = null)
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
        WHERE ($cond) 
          AND t.type='expense'
          AND t.currency = :currency
        GROUP BY f.region
        ORDER BY total_spent DESC
        ";

        $params = [':currency' => $currency];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** PODZIAŁ WG METOD PŁATNOŚCI */
    public function getPaymentMethodBreakdown($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            payment_method,
            SUM(amount) AS total_spent
        FROM transactions
        WHERE ($cond) 
          AND type='expense'
          AND currency = :currency
          AND (family_id = :family_id OR user_id = :user_id)
        GROUP BY payment_method
        ORDER BY total_spent DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** PODZIAŁ WG PODKATEGORII */
    public function getSubCategoryExpenses($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT sc.name AS sub_category, SUM(ti.amount * ti.quantity) AS total
        FROM transaction_items ti
        JOIN transactions t ON t.id = ti.transaction_id
        JOIN sub_categories sc ON sc.id = ti.sub_category_id
        WHERE ($cond)
          AND t.type = 'expense'
          AND t.currency = :currency
          AND (t.family_id = :family_id OR t.user_id = :user_id)
        GROUP BY sc.id
        ORDER BY total DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }
        return $this->db->select($sql, $params);
    }

    /** PODZIAŁ WG PODKATEGORII DLA PRZYCHODÓW */
    public function getSubCategoryIncome($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
    SELECT sc.name AS sub_category, SUM(ti.amount * ti.quantity) AS total
    FROM transaction_items ti
    JOIN transactions t ON t.id = ti.transaction_id
    JOIN sub_categories sc ON sc.id = ti.sub_category_id
    WHERE ($cond)
      AND t.type = 'income'
      AND t.currency = :currency
      AND (t.family_id = :family_id OR t.user_id = :user_id)
    GROUP BY sc.id
    ORDER BY total DESC
    ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        return $this->db->select($sql, $params);
    }

    /** ANALIZA BUDŻETU vs WYDATKI */
    public function getBudgetAnalysis($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        // Pobierz aktualne budżety dla danej waluty
        $sql = "
        SELECT 
            b.id,
            b.name,
            b.total_limit as budget_limit,
            b.currency,
            COALESCE(SUM(t.amount), 0) as actual_spent
        FROM budgets b
        LEFT JOIN transactions t ON (
            t.transaction_date BETWEEN b.start_date AND b.end_date 
            AND t.type = 'expense' 
            AND t.currency = b.currency
            AND (t.family_id = b.family_id OR t.user_id = b.user_id)
        )
        WHERE b.currency = :currency
          AND (b.family_id = :family_id OR b.user_id = :user_id)
          AND b.end_date >= CURDATE()
        GROUP BY b.id
        ORDER BY b.created_at DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        return $this->db->select($sql, $params);
    }

    /** ŚREDNIE WYDATKI MIESIĘCZNE */
    public function getAverageMonthlySpending($user_id, $family_id, $currency, $months = 12)
    {
        $sql = "
        SELECT 
            YEAR(transaction_date) as year,
            MONTH(transaction_date) as month,
            SUM(amount) as monthly_total
        FROM transactions
        WHERE type = 'expense'
          AND currency = :currency
          AND (family_id = :family_id OR user_id = :user_id)
          AND transaction_date >= DATE_SUB(CURDATE(), INTERVAL :months MONTH)
        GROUP BY YEAR(transaction_date), MONTH(transaction_date)
        ORDER BY year DESC, month DESC
        ";

        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency,
            ':months' => $months
        ];

        $monthlyData = $this->db->select($sql, $params);

        if (empty($monthlyData)) {
            return 0;
        }

        $total = 0;
        foreach ($monthlyData as $data) {
            $total += $data['monthly_total'];
        }

        return round($total / count($monthlyData), 2);
    }
}
