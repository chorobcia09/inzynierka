<?php

use Phpml\Regression\LeastSquares;
use Phpml\Math\Statistic\Mean;
use Phpml\Math\Statistic\StandardDeviation;

class Analysis
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Generuje warunek SQL dla różnych przedziałów czasowych
     */
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

    /**
     * Pobiera listę aktywnych walut używanych w transakcjach
     */
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

        if (empty($result)) {
            return [['currency' => 'PLN']];
        }

        return $result;
    }

    /**
     * Zwraca podsumowanie przychodów i wydatków dla określonej waluty
     */
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

    /**
     * Pobiera szczegółowy podział wydatków/wydatków według kategorii z uwzględnieniem pozycji transakcji
     */
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

    /**
     * Pobiera uproszczony podział kategorii na podstawie transakcji
     */
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

    /**
     * Oblicza procentowy udział każdej kategorii w całkowitych wydatkach
     */
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

    /**
     * Pobiera dane trendu wydatków/przychodów w czasie
     */
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

        $raw_data = $this->db->select($sql, $params);

        $totals = array_column($raw_data, 'total');
        $scaled_data = $this->scaleValuesForChart($totals, $currency);

        $result = [];
        foreach ($raw_data as $index => $row) {
            $result[] = [
                'date' => $row['date'],
                'total' => $row['total'],
                'scaled_total' => $scaled_data['values'][$index] ?? $row['total'],
                'scale_factor' => $scaled_data['scale_factor'] ?? 1,
                'scale_unit' => $scaled_data['unit'] ?? ''
            ];
        }

        return $result;
    }

    /**
     * Pobiera różnicę między przychodami a wydatkami w czasie
     */
    public function getProfitLossTrend($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            DATE(transaction_date) AS date,
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS expense,
            SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) AS profit_loss
        FROM transactions
        WHERE ($cond) 
        AND (family_id = :family_id OR user_id = :user_id)
        AND currency = :currency
        GROUP BY DATE(transaction_date)
        ORDER BY date ASC
        ";
        // dump($sql);
        $params = [
            ':family_id' => $family_id,
            ':user_id' => $user_id,
            ':currency' => $currency
        ];

        if ($period === 'custom') {
            $params[':date_from'] = $date_from;
            $params[':date_to'] = $date_to;
        }

        $raw_data = $this->db->select($sql, $params);

        // Skalowanie dla kryptowalut
        $profit_loss_values = array_column($raw_data, 'profit_loss');
        $scaled_data = $this->scaleValuesForChart($profit_loss_values, $currency);

        $result = [];
        foreach ($raw_data as $index => $row) {
            $result[] = [
                'date' => $row['date'],
                'income' => $row['income'],
                'expense' => $row['expense'],
                'profit_loss' => $row['profit_loss'],
                'scaled_profit_loss' => $scaled_data['values'][$index] ?? $row['profit_loss'],
                'scale_factor' => $scaled_data['scale_factor'] ?? 1,
                'scale_unit' => $scaled_data['unit'] ?? ''
            ];
        }

        return $result;
    }

    /**
     * Pobiera trendy na poziomie pojedynczych pozycji transakcji
     */
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

    /**
     * Zwraca 10 największych wydatków
     */
    public function getTopExpenses($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            t.description, 
            t.amount, 
            t.transaction_date,
            c.name as category_name,
            u.username,
            t.payment_method
        FROM transactions t
        LEFT JOIN categories c ON c.id = t.category_id
        LEFT JOIN users u ON u.id = t.user_id
        WHERE ($cond)
        AND t.type='expense'
        AND (t.family_id = :family_id OR t.user_id = :user_id)
        AND t.currency = :currency
        ORDER BY t.amount DESC
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

    /**
     * Zwraca 10 największych pozycji wydatków
     */
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

    /**
     * Analizuje wydatki poszczególnych członków rodziny
     */
    public function getFamilySpending($family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            u.id as user_id,
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
        GROUP BY u.id, u.username
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

    /**
     * Pokazuje wydatki kategorii według członków rodziny
     */
    public function getFamilyCategorySpending($family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            u.username,
            c.name as category_name,
            SUM(t.amount) AS total_spent
        FROM transactions t
        JOIN users u ON u.id = t.user_id
        JOIN categories c ON c.id = t.category_id
        WHERE t.family_id = :family_id 
        AND t.type='expense'
        AND t.currency = :currency
        AND ($cond)
        GROUP BY u.id, u.username, c.id, c.name
        ORDER BY u.username, total_spent DESC
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

    /**
     * Zwraca top kategorie dla każdego członka rodziny z procentowym udziałem
     */
    public function getTopCategoriesByMember($family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT 
            u.username,
            c.name as category_name,
            SUM(t.amount) as total_spent,
            ROUND(SUM(t.amount) / (SELECT SUM(amount) FROM transactions WHERE family_id = :family_id AND type='expense' AND currency = :currency AND ($cond)) * 100, 1) as percentage
        FROM transactions t
        JOIN users u ON u.id = t.user_id
        JOIN categories c ON c.id = t.category_id
        WHERE t.family_id = :family_id 
        AND t.type='expense'
        AND t.currency = :currency
        AND ($cond)
        GROUP BY u.id, u.username, c.id, c.name
        ORDER BY u.username, total_spent DESC
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

    /**
     * Porównuje wydatki między różnymi regionami
     */
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

    /**
     * Analizuje wydatki według metod płatności
     */
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

    /**
     * Pobiera wydatki według podkategorii
     */
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

    /**
     * Pobiera przychody według podkategorii
     */
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

    /**
     * Analizuje wykonanie budżetów
     */
    public function getBudgetAnalysis($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
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

    /**
     * Oblicza średnie miesięczne wydatki
     */
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

    /**
     * Oblicza przedział ufności dla średniej
     */
    private function calculateConfidenceInterval($mean, $std_dev, $n, $confidence_level = 0.95)
    {
        if ($n < 2 || $std_dev <= 0) {
            return [
                'lower' => $mean,
                'upper' => $mean,
                'margin_of_error' => 0
            ];
        }

        $sample_std_dev = $std_dev;
        if ($n > 1) {
            $sample_std_dev = $std_dev * sqrt($n / ($n - 1));
        }

        $min_value = 0.00000001;
        if ($mean < $min_value && $mean > 0) {
            $mean = max($mean, $min_value);
        }

        if ($sample_std_dev < $min_value && $sample_std_dev > 0) {
            $sample_std_dev = max($sample_std_dev, $min_value);
        }

        $t_values = [
            0.90 => 1.645,
            0.95 => 1.96,
            0.99 => 2.576
        ];

        if ($n < 30) {
            $t_values = [
                0.90 => $this->getTValue(0.90, $n - 1),
                0.95 => $this->getTValue(0.95, $n - 1),
                0.99 => $this->getTValue(0.99, $n - 1)
            ];
        }

        $t_value = $t_values[$confidence_level] ?? $t_values[0.95];

        $standard_error = $sample_std_dev / sqrt($n);

        if ($standard_error < $min_value && $standard_error > 0) {
            $standard_error = max($standard_error, $min_value);
        }

        $margin_of_error = $t_value * $standard_error;

        $lower_bound = $mean - $margin_of_error;
        $upper_bound = $mean + $margin_of_error;

        $lower_bound = max($min_value, $lower_bound);

        $interval_width = $upper_bound - $lower_bound;
        $min_relative_width = 0.001;

        if ($mean > 0 && $interval_width < ($mean * $min_relative_width)) {
            $extension = ($mean * $min_relative_width - $interval_width) / 2;
            $lower_bound = max($min_value, $lower_bound - $extension);
            $upper_bound = $upper_bound + $extension;
            $margin_of_error = ($upper_bound - $lower_bound) / 2;
        }

        return [
            'lower' => $lower_bound,
            'upper' => $upper_bound,
            'margin_of_error' => $margin_of_error,
            'sample_std_dev' => $sample_std_dev,
            'standard_error' => $standard_error
        ];
    }


    /**
     * Pobiera wartość t-Studenta dla danego poziomu ufności i stopni swobody
     * z interpolacją dla brakujących wartości
     */
    private function getTValue($confidence_level, $degrees_of_freedom)
    {
        $t_table = [
            0.90 => [
                1 => 6.314,
                2 => 2.920,
                3 => 2.353,
                4 => 2.132,
                5 => 2.015,
                6 => 1.943,
                7 => 1.895,
                8 => 1.860,
                9 => 1.833,
                10 => 1.812,
                11 => 1.796,
                12 => 1.782,
                13 => 1.771,
                14 => 1.761,
                15 => 1.753,
                16 => 1.746,
                17 => 1.740,
                18 => 1.734,
                19 => 1.729,
                20 => 1.725,
                21 => 1.721,
                22 => 1.717,
                23 => 1.714,
                24 => 1.711,
                25 => 1.708,
                26 => 1.706,
                27 => 1.703,
                28 => 1.701,
                29 => 1.699,
                30 => 1.697,
                40 => 1.684,
                60 => 1.671,
                120 => 1.658,
                1000 => 1.646
            ],
            0.95 => [
                1 => 12.706,
                2 => 4.303,
                3 => 3.182,
                4 => 2.776,
                5 => 2.571,
                6 => 2.447,
                7 => 2.365,
                8 => 2.306,
                9 => 2.262,
                10 => 2.228,
                11 => 2.201,
                12 => 2.179,
                13 => 2.160,
                14 => 2.145,
                15 => 2.131,
                16 => 2.120,
                17 => 2.110,
                18 => 2.101,
                19 => 2.093,
                20 => 2.086,
                21 => 2.080,
                22 => 2.074,
                23 => 2.069,
                24 => 2.064,
                25 => 2.060,
                26 => 2.056,
                27 => 2.052,
                28 => 2.048,
                29 => 2.045,
                30 => 2.042,
                40 => 2.021,
                60 => 2.000,
                120 => 1.980,
                1000 => 1.962
            ],
            0.99 => [
                1 => 63.657,
                2 => 9.925,
                3 => 5.841,
                4 => 4.604,
                5 => 4.032,
                6 => 3.707,
                7 => 3.499,
                8 => 3.355,
                9 => 3.250,
                10 => 3.169,
                11 => 3.106,
                12 => 3.055,
                13 => 3.012,
                14 => 2.977,
                15 => 2.947,
                16 => 2.921,
                17 => 2.898,
                18 => 2.878,
                19 => 2.861,
                20 => 2.845,
                21 => 2.831,
                22 => 2.819,
                23 => 2.807,
                24 => 2.797,
                25 => 2.787,
                26 => 2.779,
                27 => 2.771,
                28 => 2.763,
                29 => 2.756,
                30 => 2.750,
                40 => 2.704,
                60 => 2.660,
                120 => 2.617,
                1000 => 2.576
            ]
        ];

        $level_table = $t_table[$confidence_level] ?? $t_table[0.95];

        if (isset($level_table[$degrees_of_freedom])) {
            return $level_table[$degrees_of_freedom];
        }

        $keys = array_keys($level_table);
        sort($keys);

        $lower = null;
        $upper = null;

        foreach ($keys as $key) {
            if ($key <= $degrees_of_freedom) {
                $lower = $key;
            }
            if ($key >= $degrees_of_freedom && $upper === null) {
                $upper = $key;
            }
        }

        if ($lower !== null && $upper !== null && $lower != $upper) {
            $t_lower = $level_table[$lower];
            $t_upper = $level_table[$upper];

            $weight = ($degrees_of_freedom - $lower) / ($upper - $lower);
            return $t_lower + ($t_upper - $t_lower) * $weight;
        }

        if ($degrees_of_freedom > 1000) {
            $z_values = [0.90 => 1.645, 0.95 => 1.96, 0.99 => 2.576];
            return $z_values[$confidence_level] ?? 1.96;
        }

        return end($level_table);
    }

    /**
     * Rozszerzona wersja getDescriptiveStats z przedziałami ufności
     */
    public function getDescriptiveStats($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        $sql = "
        SELECT amount 
        FROM transactions 
        WHERE ($cond)
        AND type = 'expense'
        AND currency = :currency
        AND (family_id = :family_id OR user_id = :user_id)
        ORDER BY amount
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

        $results = $this->db->select($sql, $params);

        if (empty($results)) {
            return [
                'mean' => 0,
                'median' => 0,
                'std_dev' => 0,
                'variance' => 0,
                'kurtosis' => 0,
                'skewness' => 0,
                'coefficient_of_variation' => 0,
                'range' => 0,
                'iqr' => 0,
                'min' => 0,
                'max' => 0,
                'count' => 0,
                'confidence_interval_95' => [
                    'lower' => 0,
                    'upper' => 0,
                    'margin_of_error' => 0
                ],
                'confidence_interval_99' => [
                    'lower' => 0,
                    'upper' => 0,
                    'margin_of_error' => 0
                ]
            ];
        }

        $amounts = array_column($results, 'amount');
        $n = count($amounts);

        $precision = $this->getCurrencyPrecision($currency);

        $mean = Mean::arithmetic($amounts);
        $median = Mean::median($amounts);
        $min = min($amounts);
        $max = max($amounts);

        if ($n >= 2) {
            $std_dev = $this->sampleStdDev($amounts);
            if ($std_dev < 1e-10 && $mean > 0) {
                $std_dev = $mean * 0.01;
            }
            $variance = pow($std_dev, 2);
        } else {
            $std_dev = 0;
            $variance = 0;
        }

        if ($n >= 3 && $std_dev > 0) {
            $skewness = $this->calculateSkewness($amounts, $mean, $std_dev);
            $kurtosis = $this->calculateKurtosis($amounts, $mean, $std_dev);
        } else {
            $skewness = 0;
            $kurtosis = 0;
        }

        $coefficient_of_variation = ($mean > 0) ? ($std_dev / $mean) * 100 : 0;

        $range = $max - $min;
        $iqr = ($n >= 4) ? $this->calculateIQR($amounts) : 0;

        $confidence_95 = $this->calculateConfidenceInterval($mean, $std_dev, $n, 0.95);
        $confidence_99 = $this->calculateConfidenceInterval($mean, $std_dev, $n, 0.99);

        return [
            'mean' => round($mean, $precision),
            'median' => round($median, $precision),
            'std_dev' => round($std_dev, $precision),
            'variance' => round($variance, $precision),
            'kurtosis' => round($kurtosis, 3),
            'skewness' => round($skewness, 3),
            'coefficient_of_variation' => round($coefficient_of_variation, 1),
            'range' => round($range, $precision),
            'iqr' => round($iqr, $precision),
            'min' => round($min, $precision),
            'max' => round($max, $precision),
            'count' => $n,
            'confidence_interval_95' => [
                'lower' => round($confidence_95['lower'], $precision),
                'upper' => round($confidence_95['upper'], $precision),
                'margin_of_error' => round($confidence_95['margin_of_error'], $precision)
            ],
            'confidence_interval_99' => [
                'lower' => round($confidence_99['lower'], $precision),
                'upper' => round($confidence_99['upper'], $precision),
                'margin_of_error' => round($confidence_99['margin_of_error'], $precision)
            ]
        ];
    }

    /**
     * Oblicza odchylenie standardowe 
     */
    private function sampleStdDev(array $values)
    {
        $n = count($values);
        if ($n < 2) return 0;

        $mean = array_sum($values) / $n;

        $sumSq = 0;
        foreach ($values as $v) {
            $sumSq += pow($v - $mean, 2);
        }

        return sqrt($sumSq / ($n - 1));
    }


    /**
     * Zwraca precyzję dla danej waluty
     */
    private function getCurrencyPrecision($currency)
    {
        $crypto_currencies = ['BTC', 'ETH', 'BNB', 'XRP', 'DOGE', 'USDT', 'SOL', 'ADA', 'TRX'];
        return in_array($currency, $crypto_currencies) ? 8 : 2;
    }

    /**
     * Dodatkowa metoda do uzyskania szczegółowych informacji o przedziałach ufności
     */
    public function getConfidenceIntervalInfo($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $stats = $this->getDescriptiveStats($user_id, $family_id, $currency, $period, $date_from, $date_to);

        return [
            'mean' => $stats['mean'],
            'sample_size' => $stats['count'],
            'standard_error' => $stats['std_dev'] / sqrt($stats['count']),
            'confidence_intervals' => [
                '90%' => $this->calculateConfidenceInterval($stats['mean'], $stats['std_dev'], $stats['count'], 0.90),
                '95%' => $stats['confidence_interval_95'],
                '99%' => $stats['confidence_interval_99']
            ],
            'interpretation' => $this->getConfidenceInterpretation($stats)
        ];
    }

    /**
     * Generuje interpretację przedziałów ufności
     */
    private function getConfidenceInterpretation($stats)
    {
        $n = $stats['count'];
        $ci95 = $stats['confidence_interval_95'];

        if ($n < 2) {
            return "Za mało danych do obliczenia przedziału ufności";
        }

        $precision = 2;
        $mean_formatted = number_format($stats['mean'], $precision);
        $lower_formatted = number_format($ci95['lower'], $precision);
        $upper_formatted = number_format($ci95['upper'], $precision);
        $margin_formatted = number_format($ci95['margin_of_error'], $precision);

        $interpretations = [
            "Z 95% pewnością średni wydatek mieści się w przedziale {$lower_formatted} - {$upper_formatted} {$GLOBALS['currency']}",
            "Średni wydatek wynosi {$mean_formatted} {$GLOBALS['currency']} z marginesem błędu ±{$margin_formatted} {$GLOBALS['currency']}",
            "Próbka zawiera {$n} transakcji, co zapewnia wiarygodność estymacji"
        ];

        $width = $ci95['upper'] - $ci95['lower'];
        $relative_width = ($width / $stats['mean']) * 100;

        if ($relative_width < 10) {
            $interpretations[] = "Wąski przedział ufności wskazuje na wysoką precyzję estymacji";
        } elseif ($relative_width > 50) {
            $interpretations[] = "Szeroki przedział ufności sugeruje potrzebę większej próbki dla lepszej precyzji";
        }

        return $interpretations;
    }



    /**
     * Oblicza miary koncentracji (Gini, HHI, CR, entropia)
     */
    public function getConcentrationStats($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $categories = $this->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);
        if (empty($categories) || count($categories) < 2) {
            return [
                'gini' => 0,
                'hhi' => 0,
                'cr3' => 0,
                'cr5' => 0,
                'entropy' => 0,
                'categories_count' => count($categories),
                'note' => 'Wymagane przynajmniej 2 kategorie do obliczenia koncentracji'
            ];
        }

        $totals = array_column($categories, 'total');
        $total_sum = array_sum($totals);

        if ($total_sum < 0.00000001) {
            return [
                'gini' => 0,
                'hhi' => 0,
                'cr3' => 0,
                'cr5' => 0,
                'entropy' => 0,
                'categories_count' => 0,
                'note' => 'Suma zbyt mała do obliczenia koncentracji'
            ];
        }

        $gini = $this->calculateGini($totals);
        $hhi = $this->calculateHHI($totals, $total_sum);
        $cr3 = $this->calculateCR($totals, $total_sum, 3);
        $cr5 = $this->calculateCR($totals, $total_sum, 5);
        $entropy = $this->calculateEntropy($totals, $total_sum);

        return [
            'gini' => round($gini, 3),
            'hhi' => round($hhi, 0),
            'cr3' => round($cr3, 1),
            'cr5' => round($cr5, 1),
            'entropy' => round($entropy, 3),
            'categories_count' => count($categories)
        ];
    }

    /**
     * Przeprowadza zaawansowaną analizę trendu z regresją liniową z PHP-ML
     */
    /**
     * Przeprowadza analizę trendu i zwraca gotową linię trendu
     */
    public function getTrendAnalysis($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $trend_data = $this->getTrend($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);

        if (count($trend_data) < 3) {
            return [
                'r_squared' => 0,
                'growth_rate' => 0,
                't_statistic' => 0,
                'slope' => 0,
                'intercept' => 0,
                'trend_line' => [],
                'actual_values' => [],
                'dates' => [],
                'note' => 'Wymagane przynajmniej 3 punkty danych'
            ];
        }

        try {
            $y = array_column($trend_data, 'total');
            $dates = array_column($trend_data, 'date');
            $n = count($y);

            $scale_factor = $this->getScaleFactor($currency, $y);
            $y_scaled = array_map(function ($value) use ($scale_factor) {
                return $value * $scale_factor;
            }, $y);

            $x = range(1, $n);
            $samples = array_map(function ($val) {
                return [$val];
            }, $x);

            $regression = new LeastSquares();
            $regression->train($samples, $y_scaled);

            $predictions_scaled = [];
            foreach ($samples as $sample) {
                $predictions_scaled[] = $regression->predict($sample);
            }

            // Deskaluj wartości
            $slope = $regression->getCoefficients()[0] / $scale_factor;
            $intercept = $regression->getIntercept() / $scale_factor;

            // Oblicz linię trendu
            $trend_line = [];
            for ($i = 1; $i <= $n; $i++) {
                $trend_line[] = $intercept + $slope * $i;
            }

            $predictions = array_map(function ($value) use ($scale_factor) {
                return $value / $scale_factor;
            }, $predictions_scaled);

            $r_squared = $this->calculateRSquared($y, $predictions);
            $growth_rate = $this->calculateGrowthRate($y);
            $t_statistic = $this->calculateTStatistic($y, $predictions, $slope);

            return [
                'r_squared' => round($r_squared, 4),
                'growth_rate' => round($growth_rate, 2),
                't_statistic' => round($t_statistic, 4),
                'slope' => $this->roundForCurrency($slope, $currency),
                'intercept' => $this->roundForCurrency($intercept, $currency),
                'trend_line' => $trend_line, // Gotowa linia trendu
                'actual_values' => $y,      // Rzeczywiste wartości
                'dates' => $dates,          // Daty
                'data_points' => $n
            ];
        } catch (Exception $e) {
            error_log("Błąd analizy trendu: " . $e->getMessage());
            return [
                'r_squared' => 0,
                'growth_rate' => 0,
                't_statistic' => 0,
                'slope' => 0,
                'intercept' => 0,
                'trend_line' => [],
                'actual_values' => [],
                'dates' => [],
                'error' => 'Błąd obliczeń'
            ];
        }
    }

    /**
     * Określa współczynnik skalowania dla uniknięcia problemów numerycznych
     */
    private function getScaleFactor($currency, $values)
    {
        $max_value = max($values);
        $min_value = min($values);

        if (in_array($currency, ['BTC', 'ETH', 'BNB', 'XRP', 'DOGE', 'USDT', 'SOL', 'ADA', 'TRX'])) {
            if ($max_value < 0.01) {
                return 1000000;
            }
        }

        if ($max_value < 1.0) {
            return 1000;
        }

        return 1;
    }

    /**
     * Zaokrągla wartości odpowiednio dla waluty
     */
    private function roundForCurrency($value, $currency)
    {
        $precision = $this->getCurrencyPrecision($currency);
        return round($value, $precision);
    }

    /**
     * Oblicza skośność rozkładu (pomocnicza)
     */
    private function calculateSkewness(array $values, $mean, $std_dev)
    {
        $n = count($values);
        if ($std_dev == 0 || $n < 3) return 0;

        $sum = 0;
        foreach ($values as $value) {
            $sum += pow(($value - $mean) / $std_dev, 3);
        }

        return $sum / $n;
    }

    /**
     * Oblicza kurtozę rozkładu (pomocnicza)
     */
    private function calculateKurtosis(array $values, $mean, $std_dev)
    {
        $n = count($values);
        if ($std_dev == 0 || $n < 4) return 0;

        $sum = 0;
        foreach ($values as $value) {
            $sum += pow(($value - $mean) / $std_dev, 4);
        }

        return ($sum / $n) - 3;
    }

    /**
     * Oblicza zakres wartości (pomocnicza)
     */
    private function calculateRange(array $values)
    {
        return max($values) - min($values);
    }

    /**
     * Oblicza rozstęp międzykwartylowy (pomocnicza)
     */
    private function calculateIQR(array $values)
    {
        $n = count($values);
        if ($n < 4) return 0;

        sort($values);
        $mid = floor($n / 2);

        $lower_half = array_slice($values, 0, $mid);
        $q1 = Mean::median($lower_half);

        $upper_half = array_slice($values, $n % 2 ? $mid + 1 : $mid);
        $q3 = Mean::median($upper_half);

        return $q3 - $q1;
    }

    /**
     * Oblicza współczynnik Giniego (pomocnicza)
     */
    private function calculateGini(array $values)
    {
        sort($values);
        $n = count($values);
        $total_sum = array_sum($values);

        if ($total_sum <= 0) return 0;

        $gini_numerator = 0;
        for ($i = 0; $i < $n; $i++) {
            $gini_numerator += ($i + 1) * $values[$i];
        }

        return (2 * $gini_numerator) / ($n * $total_sum) - ($n + 1) / $n;
    }

    /**
     * Oblicza wskaźnik Herfindahla-Hirschmana (pomocnicza)
     */
    private function calculateHHI(array $values, $total_sum)
    {
        $hhi = 0;
        foreach ($values as $value) {
            $share = $value / $total_sum;
            $hhi += pow($share * 100, 2);
        }
        return $hhi;
    }

    /**
     * Oblicza wskaźnik koncentracji CR (pomocnicza)
     */
    private function calculateCR(array $values, $total_sum, $top_n)
    {
        rsort($values);
        $top_sum = array_sum(array_slice($values, 0, $top_n));
        return ($top_sum / $total_sum) * 100;
    }

    /**
     * Oblicza entropię rozkładu (pomocnicza)
     */
    private function calculateEntropy(array $values, $total_sum)
    {
        $entropy = 0;
        foreach ($values as $value) {
            $p = $value / $total_sum;
            if ($p > 0) {
                $entropy -= $p * log($p);
            }
        }
        return $entropy;
    }

    /**
     * Oblicza współczynnik determinacji R^2 (pomocnicza)
     */
    private function calculateRSquared(array $actual, array $predicted)
    {
        $ss_res = 0;
        $ss_tot = 0;
        $mean_actual = Mean::arithmetic($actual);

        for ($i = 0; $i < count($actual); $i++) {
            $ss_res += pow($actual[$i] - $predicted[$i], 2);
            $ss_tot += pow($actual[$i] - $mean_actual, 2);
        }

        return ($ss_tot > 0) ? 1 - ($ss_res / $ss_tot) : 0;
    }

    /**
     * Oblicza tempo wzrostu (pomocnicza)
     */
    private function calculateGrowthRate(array $values)
    {
        $n = count($values);
        if ($n < 2) return 0;

        $first = $values[0];
        $last = $values[$n - 1];

        return ($first > 0) ? (($last - $first) / $first) * 100 : 0;
    }

    /**
     * Oblicza statystykę t (pomocnicza)
     */
    private function calculateTStatistic(array $actual, array $predicted, $slope)
    {
        $n = count($actual);
        if ($n < 3) return 0;

        $residuals = array_map(function ($a, $p) {
            return $a - $p;
        }, $actual, $predicted);

        $residuals_sum_sq = 0;
        foreach ($residuals as $residual) {
            $residuals_sum_sq += $residual * $residual;
        }

        $degrees_of_freedom = $n - 2;

        if ($degrees_of_freedom <= 0 || $residuals_sum_sq < 1e-16) {
            return 0;
        }

        $mse = $residuals_sum_sq / $degrees_of_freedom;
        $se_slope = sqrt($mse / $this->calculateVarianceX($actual));

        return ($se_slope > 1e-10) ? abs($slope) / $se_slope : 0;
    }

    /**
     * Oblicza wariancję dla zmiennej X (czas/indeks)
     */
    private function calculateVarianceX(array $y_values)
    {
        $n = count($y_values);
        $x_values = range(1, $n);
        $mean_x = array_sum($x_values) / $n;

        $variance = 0;
        foreach ($x_values as $x) {
            $variance += pow($x - $mean_x, 2);
        }

        return $variance > 0 ? $variance : 1;
    }

    /**
     * Skaluje wartości dla lepszej czytelności na wykresach
     */
    private function scaleValuesForChart($values, $currency)
    {
        $crypto_currencies = ['BTC', 'ETH', 'BNB', 'XRP', 'DOGE', 'USDT', 'SOL', 'ADA', 'TRX'];

        if (!in_array($currency, $crypto_currencies)) {
            return [
                'values' => $values,
                'scale_factor' => 1,
                'unit' => ''
            ];
        }

        if (empty($values)) {
            return [
                'values' => [],
                'scale_factor' => 1,
                'unit' => ''
            ];
        }

        $numeric_values = array_filter($values, function ($value) {
            return is_numeric($value) && $value !== null;
        });

        if (empty($numeric_values)) {
            return [
                'values' => $values,
                'scale_factor' => 1,
                'unit' => ''
            ];
        }

        $max_value = max($numeric_values);

        if ($max_value == 0) {
            return [
                'values' => $values,
                'scale_factor' => 1,
                'unit' => ''
            ];
        }

        if ($max_value < 0.001) {
            $scale_factor = 1000000;
        } elseif ($max_value < 0.01) {
            $scale_factor = 100000;
        } elseif ($max_value < 0.1) {
            $scale_factor = 10000;
        } elseif ($max_value < 1) {
            $scale_factor = 1000;
        } else {
            $scale_factor = 1;
        }

        $scaled_values = [];
        foreach ($values as $value) {
            $scaled_values[] = $value * $scale_factor;
        }

        return [
            'values' => $scaled_values,
            'scale_factor' => $scale_factor,
            'unit' => $this->getScaleUnit($scale_factor)
        ];
    }

    /**
     * Zwraca jednostkę dla skalowania
     */
    private function getScaleUnit($scale_factor)
    {
        switch ($scale_factor) {
            case 1000000:
                return 'milionów';
            case 100000:
                return 'setek tysięcy';
            case 10000:
                return 'dziesiątek tysięcy';
            case 1000:
                return 'tysięcy';
            default:
                return '';
        }
    }
}
