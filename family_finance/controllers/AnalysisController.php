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

        $user_id = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;
        $period = $_GET['period'] ?? "monthly";

        // Wydatki
        $summary = $this->analysis->getSummary($user_id, $family_id, $period);
        $byCategory = $this->analysis->getCategoryBreakdown($user_id, $family_id, $period);
        $trend = $this->analysis->getTrend($user_id, $family_id, $period);
        $topExpenses = $this->analysis->getTopExpenses($user_id, $family_id, $period);

        // Przychody
        $incomeCategories = $this->analysis->getCategoryBreakdown($user_id, $family_id, $period, 'income');
        $trendIncome = $this->analysis->getTrend($user_id, $family_id, $period, 'income');

        // Inne
        $regionalComparison = $this->analysis->getRegionalComparison($period);
        $paymentMethodBreakdown = $this->analysis->getPaymentMethodBreakdown($user_id, $family_id, $period);
        $categoryPercentages = $this->analysis->getCategoryPercentages($user_id, $family_id, $period);

        $this->smarty->assign([
            'summary' => $summary,
            'categories' => $byCategory,
            'trend' => $trend,
            'topExpenses' => $topExpenses,
            'period' => $period,
            'session' => $_SESSION,
            'regionalComparison' => $regionalComparison,
            'paymentMethodBreakdown' => $paymentMethodBreakdown,
            'categoryPercentages' => $categoryPercentages,
            'incomeCategories' => $incomeCategories,
            'trendIncome' => $trendIncome
        ]);

        $this->smarty->display('analysis_dashboard.tpl');
    }


    public function pdf()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;
        $period = $_GET['period'] ?? 'monthly';
        $type = $_GET['type'] ?? 'summary';

        $summary = $this->analysis->getSummary($user_id, $family_id, $period);
        $categories = $this->analysis->getCategoryBreakdown($user_id, $family_id, $period);
        $topExpenses = $this->analysis->getTopExpenses($user_id, $family_id, $period);

        // require_once 'libs/tcpdf/tcpdf.php';

        $pdf = new TCPDF();
        $pdf->SetCreator("Manage Your Finances");
        $pdf->SetAuthor("System");
        $pdf->SetTitle("Raport finansowy – $period");
        $pdf->AddPage();

        $html = "<h2 style='text-align:center;'>Raport finansowy ($period)</h2>";

        switch ($type) {
            case 'categories':
                $categories = $this->analysis->getCategoryBreakdown($user_id, $family_id, $period);
                $html .= "<h3>Raport wg kategorii</h3>
        <table border='1' cellpadding='5'>
            <tr><th>Kategoria</th><th>Suma</th></tr>";
                foreach ($categories as $c) {
                    $html .= "<tr><td>{$c['name']}</td><td>{$c['total']} zł</td></tr>";
                }
                $html .= "</table>";
                break;

            case 'payments':
                $payments = $this->analysis->getPaymentMethodBreakdown($user_id, $family_id, $period);
                $html .= "<h3>Raport wg rodzaju płatności</h3>
        <table border='1' cellpadding='5'>
            <tr><th>Płatność</th><th>Suma</th></tr>";
                foreach ($payments as $p) {
                    $html .= "<tr><td>{$p['payment_method']}</td><td>{$p['total_spent']} zł</td></tr>";
                }
                $html .= "</table>";
                break;

            case 'top':
                $topExpenses = $this->analysis->getTopExpenses($user_id, $family_id, $period);
                $html .= "<h3>Top 5 wydatków</h3>
        <table border='1' cellpadding='5'>
            <tr><th>Opis</th><th>Kwota</th><th>Data</th></tr>";
                foreach ($topExpenses as $e) {
                    $html .= "<tr><td>{$e['description']}</td><td>{$e['amount']} zł</td><td>{$e['transaction_date']}</td></tr>";
                }
                $html .= "</table>";
                break;

            default: // summary
                $summary = $this->analysis->getSummary($user_id, $family_id, $period);
                $html .= "<h3>Podsumowanie</h3>
        <table border='1' cellpadding='5'>
            <tr><th>Przychody</th><th>Wydatki</th><th>Bilans</th></tr>
            <tr>
                <td>{$summary['income']} zł</td>
                <td>{$summary['expense']} zł</td>
                <td>" . ($summary['income'] - $summary['expense']) . " zł</td>
            </tr>
        </table>";
        }


        $pdf->writeHTML($html);
        $pdf->Output("raport_$period.pdf", "D");
    }

    public function reports()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;
        $period = $_GET['period'] ?? 'monthly';

        $this->smarty->assign([
            'period' => $period,
            'session' => $_SESSION
        ]);

        $this->smarty->display('analysis_reports.tpl');
    }
}
