<?php
require_once 'models/Analysis.php';
require_once 'vendor/autoload.php';

class AnalysisController
{
    private $smarty;
    private $analysis;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
        $this->analysis = new Analysis();
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id   = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;

        $period    = $_GET['period']    ?? 'monthly';
        $date_from = $_GET['date_from'] ?? null;
        $date_to   = $_GET['date_to']   ?? null;

        if ($date_from && $date_to) {
            $period = 'custom';
        }

        // ------ WALUTY ------
        $currencies = $this->analysis->getActiveCurrencies($user_id, $family_id, $period, $date_from, $date_to);

        $currency = $_GET['currency'] ?? ($currencies[0]['currency'] ?? 'PLN');

        // ------ WYDATKI ------
        $summary           = $this->analysis->getSummary($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $byCategory        = $this->analysis->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);
        $trend             = $this->analysis->getTrend($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);
        $topExpenses       = $this->analysis->getTopExpenses($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $subCategoryExpenses = $this->analysis->getSubCategoryExpenses($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $subCategoryIncome = $this->analysis->getSubCategoryIncome($user_id, $family_id, $currency, $period, $date_from, $date_to);
        // ------ PRZYCHODY ------
        $incomeCategories  = $this->analysis->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'income', $date_from, $date_to);
        $trendIncome       = $this->analysis->getTrend($user_id, $family_id, $currency, $period, 'income', $date_from, $date_to);
// dump($_SESSION);die;
        // ------ INNE ------
        $regionalComparison   = $this->analysis->getRegionalComparison($currency, $period, $date_from, $date_to);
        $paymentMethodBreakdown = $this->analysis->getPaymentMethodBreakdown($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $categoryPercentages  = $this->analysis->getCategoryPercentages($user_id, $family_id, $currency, $period, $date_from, $date_to);

        $this->smarty->assign([
            'summary' => $summary,
            'categories' => $byCategory,
            'trend' => $trend,
            'topExpenses' => $topExpenses,
            'period' => $period,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'session' => $_SESSION,
            'regionalComparison' => $regionalComparison,
            'paymentMethodBreakdown' => $paymentMethodBreakdown,
            'categoryPercentages' => $categoryPercentages,
            'incomeCategories' => $incomeCategories,
            'trendIncome' => $trendIncome,
            'subCategoryExpenses' => $subCategoryExpenses,
            'subCategoryIncome' => $subCategoryIncome,
            'currencies' => $currencies,
            'currency' => $currency
        ]);

        $this->smarty->display('analysis_dashboard.tpl');
    }

    /* ========================= PDF ========================= */
    public function pdf()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id   = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;

        $period    = $_GET['period'] ?? 'monthly';
        $type      = $_GET['type'] ?? 'summary';
        $date_from = $_GET['date_from'] ?? null;
        $date_to   = $_GET['date_to'] ?? null;

        if ($date_from && $date_to) {
            $period = 'custom';
        }

        // WALUTA
        $currency = $_GET['currency'] ?? 'PLN';

        $summary     = $this->analysis->getSummary($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $categories  = $this->analysis->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);
        $topExpenses = $this->analysis->getTopExpenses($user_id, $family_id, $currency, $period, $date_from, $date_to);

        $pdf = new TCPDF();
        $pdf->SetCreator("Manage Your Finances");
        $pdf->SetAuthor("System");
        $pdf->SetTitle("Raport finansowy $period");
        $pdf->AddPage();

        $html = "<h2 style='text-align:center;'>Raport finansowy ($period)</h2>";

        switch ($type) {
            case 'categories':
                $html .= "<h3>Raport wg kategorii</h3>
                <table border='1' cellpadding='5'>
                    <tr><th>Kategoria</th><th>Suma</th></tr>";

                foreach ($categories as $c) {
                    $html .= "<tr><td>{$c['name']}</td><td>{$c['total']} {$currency}</td></tr>";
                }

                $html .= "</table>";
                break;

            case 'payments':
                $payments = $this->analysis->getPaymentMethodBreakdown($user_id, $family_id, $currency, $period, $date_from, $date_to);

                $html .= "<h3>Raport wg rodzaju płatności</h3>
                <table border='1' cellpadding='5'>
                    <tr><th>Płatność</th><th>Suma</th></tr>";

                foreach ($payments as $p) {
                    $html .= "<tr><td>{$p['payment_method']}</td><td>{$p['total_spent']} {$currency}</td></tr>";
                }

                $html .= "</table>";
                break;

            case 'top':
                $html .= "<h3>Top 5 wydatków</h3>
                <table border='1' cellpadding='5'>
                    <tr><th>Opis</th><th>Kwota</th><th>Data</th></tr>";

                foreach ($topExpenses as $e) {
                    $html .= "<tr><td>{$e['description']}</td><td>{$e['amount']} {$currency}</td><td>{$e['transaction_date']}</td></tr>";
                }

                $html .= "</table>";
                break;

            default: // summary
                $html .= "<h3>Podsumowanie</h3>
                <table border='1' cellpadding='5'>
                    <tr><th>Przychody</th><th>Wydatki</th><th>Bilans</th></tr>
                    <tr>
                        <td>{$summary['income']} {$currency}</td>
                        <td>{$summary['expense']} {$currency}</td>
                        <td>" . ($summary['income'] - $summary['expense']) . " {$currency}</td>
                    </tr>
                </table>";
        }

        $pdf->writeHTML($html);
        $pdf->Output("raport_$period.pdf", "D");
    }

    /* ========================= RAPORTY ========================= */
    public function reports()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id   = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;

        $period  = $_GET['period'] ?? 'monthly';
        $date_from = $_GET['date_from'] ?? null;
        $date_to   = $_GET['date_to'] ?? null;

        if ($date_from && $date_to) {
            $period = 'custom';
        }

        // WALUTA DO FILTRÓW
        $currencies = $this->analysis->getActiveCurrencies($user_id, $family_id, $period, $date_from, $date_to);
        $currency   = $_GET['currency'] ?? ($currencies[0]['currency'] ?? 'PLN');

        $this->smarty->assign([
            'period' => $period,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'session' => $_SESSION,
            'currencies' => $currencies,
            'currency' => $currency
        ]);

        $this->smarty->display('analysis_reports.tpl');
    }
}
