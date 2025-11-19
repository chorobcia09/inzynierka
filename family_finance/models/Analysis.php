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

        return $this->db->select($sql, $params);
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
     * Oblicza podstawowe statystyki opisowe dla wydatków
     */
    /** STATYSTYKI OPISOWE Z PHP-ML - POPRAWIONA WERSJA */
    public function getDescriptiveStats($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $cond = $this->getPeriodCondition($period, $date_from, $date_to);

        // Pobierz wszystkie wydatki
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
                'count' => 0
            ];
        }

        $amounts = array_column($results, 'amount');
        $n = count($amounts);

        // Podstawowe statystyki
        $mean = Mean::arithmetic($amounts);
        $median = Mean::median($amounts);
        $min = min($amounts);
        $max = max($amounts);

        // Odchylenie standardowe - tylko jeśli są co najmniej 2 elementy
        if ($n >= 2) {
            $std_dev = StandardDeviation::population($amounts);
            $variance = pow($std_dev, 2);
        } else {
            $std_dev = 0;
            $variance = 0;
        }

        // Skosność i kurtoza - tylko jeśli są co najmniej 3 elementy
        if ($n >= 3 && $std_dev > 0) {
            $skewness = $this->calculateSkewness($amounts, $mean, $std_dev);
            $kurtosis = $this->calculateKurtosis($amounts, $mean, $std_dev);
        } else {
            $skewness = 0;
            $kurtosis = 0;
        }

        // Współczynnik zmienności
        $coefficient_of_variation = ($mean > 0) ? ($std_dev / $mean) * 100 : 0;

        // Dodatkowe miary - tylko jeśli są wystarczające dane
        $range = $max - $min;
        $iqr = ($n >= 4) ? $this->calculateIQR($amounts) : 0;

        return [
            'mean' => $mean,
            'median' => $median,
            'std_dev' => $std_dev,
            'variance' => $variance,
            'kurtosis' => $kurtosis,
            'skewness' => $skewness,
            'coefficient_of_variation' => $coefficient_of_variation,
            'range' => $range,
            'iqr' => $iqr,
            'min' => $min,
            'max' => $max,
            'count' => $n
        ];
    }



    /**
     * Oblicza miary koncentracji (Gini, HHI, CR, entropia)
     */
    public function getConcentrationStats($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $categories = $this->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);

        if (empty($categories)) {
            return [
                'gini' => 0,
                'hhi' => 0,
                'cr3' => 0,
                'cr5' => 0,
                'entropy' => 0
            ];
        }

        $totals = array_column($categories, 'total');
        $total_sum = array_sum($totals);

        $gini = $this->calculateGini($totals);
        $hhi = $this->calculateHHI($totals, $total_sum);

        $cr3 = $this->calculateCR($totals, $total_sum, 3);
        $cr5 = $this->calculateCR($totals, $total_sum, 5);

        $entropy = $this->calculateEntropy($totals, $total_sum);

        return [
            'gini' => $gini,
            'hhi' => $hhi,
            'cr3' => $cr3,
            'cr5' => $cr5,
            'entropy' => $entropy
        ];
    }

    /**
     * Przeprowadza zaawansowaną analizę trendu z regresją liniową z PHP-ML
     */
    public function getTrendAnalysis($user_id, $family_id, $currency, $period = 'monthly', $date_from = null, $date_to = null)
    {
        $trend_data = $this->getTrend($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);

        if (count($trend_data) < 2) {
            return [
                'r_squared' => 0,
                'growth_rate' => 0,
                't_statistic' => 0,
                'slope' => 0,
                'intercept' => 0
            ];
        }

        try {
            $y = array_column($trend_data, 'total');
            $n = count($y);
            $x = range(1, $n);

            // Regresja liniowa z PHP-ML
            $samples = array_map(function ($val) {
                return [$val];
            }, $x);
            $regression = new LeastSquares();
            $regression->train($samples, $y);

            // Prognozy i R²
            $predictions = array_map(function ($sample) use ($regression) {
                return $regression->predict($sample);
            }, $samples);

            $r_squared = $this->calculateRSquared($y, $predictions);

            // Parametry modelu
            $slope = $regression->getCoefficients()[0];
            $intercept = $regression->getIntercept();

            // Tempo zmian
            $growth_rate = $this->calculateGrowthRate($y);

            // Statystyka t
            $t_statistic = $this->calculateTStatistic($y, $predictions, $slope);

            return [
                'r_squared' => $r_squared,
                'growth_rate' => $growth_rate,
                't_statistic' => $t_statistic,
                'slope' => $slope,
                'intercept' => $intercept
            ];
        } catch (Exception $e) {
            return [
                'r_squared' => 0,
                'growth_rate' => 0,
                't_statistic' => 0,
                'slope' => 0,
                'intercept' => 0
            ];
        }
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

        // Dolny kwartyl
        $lower_half = array_slice($values, 0, $mid);
        $q1 = Mean::median($lower_half);

        // Górny kwartyl  
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
        $residuals = array_map(function ($a, $p) {
            return $a - $p;
        }, $actual, $predicted);
        $se = StandardDeviation::population($residuals) / sqrt(count($actual));
        return ($se > 0) ? abs($slope) / $se : 0;
    }
}
