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
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;

        $period = $_GET['period']    ?? 'monthly';
        $date_from = $_GET['date_from'] ?? null;
        $date_to = $_GET['date_to']   ?? null;

        if ($date_from && $date_to) {
            $period = 'custom';
        }
        $currencies = $this->analysis->getActiveCurrencies($user_id, $family_id, $period, $date_from, $date_to);
        $currency = $_GET['currency'] ?? ($currencies[0]['currency'] ?? 'PLN');

        $summary = $this->analysis->getSummary($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $byCategory = $this->analysis->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);
        $trend = $this->analysis->getTrend($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);
        $topExpenses = $this->analysis->getTopExpenses($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $subCategoryExpenses = $this->analysis->getSubCategoryExpenses($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $incomeCategories = $this->analysis->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'income', $date_from, $date_to);
        $trendIncome = $this->analysis->getTrend($user_id, $family_id, $currency, $period, 'income', $date_from, $date_to);
        $subCategoryIncome = $this->analysis->getSubCategoryIncome($user_id, $family_id, $currency, $period, $date_from, $date_to);

        $familySpending = [];
        $familyCategorySpending = [];
        $familyTotalSpending = 0;
        $familyTotalTransactions = 0;
        $familyAverageSpending = 0;

        if ($family_id) {
            $familySpending = $this->analysis->getFamilySpending($family_id, $currency, $period, $date_from, $date_to);
            $familyCategorySpending = $this->analysis->getFamilyCategorySpending($family_id, $currency, $period, $date_from, $date_to);

            foreach ($familySpending as $member) {
                $familyTotalSpending += $member['total_spent'];
                $familyTotalTransactions += $member['transactions'];
            }

            $familyAverageSpending = count($familySpending) > 0 ? $familyTotalSpending / count($familySpending) : 0;
        }

        // $regionalComparison   = $this->analysis->getRegionalComparison($currency, $period, $date_from, $date_to);
        $paymentMethodBreakdown = $this->analysis->getPaymentMethodBreakdown($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $categoryPercentages  = $this->analysis->getCategoryPercentages($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $descriptiveStats = $this->analysis->getDescriptiveStats($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $concentrationStats = $this->analysis->getConcentrationStats($user_id, $family_id, $currency, $period, $date_from, $date_to);
        // $trendAnalysis = $this->analysis->getTrendAnalysis($user_id, $family_id, $currency, $period, $date_from, $date_to);

        $profitLossTrend = $this->analysis->getProfitLossTrend($user_id, $family_id, $currency, $period, $date_from, $date_to);
        // dump($profitLossTrend);
        $isPremium = ($_SESSION['account_type'] ?? 'standard') === 'premium';
        // dump($isPremium);
        $regionalComparison = [];
        $trendAnalysis = [];

        // if ($isPremium) {
        $regionalComparison = $this->analysis->getRegionalComparison($currency, $period, $date_from, $date_to);
        $trendAnalysis = $this->analysis->getTrendAnalysis($user_id, $family_id, $currency, $period, $date_from, $date_to);
        // dump($trendAnalysis);
        // }

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
            'familySpending' => $familySpending,
            'familyCategorySpending' => $familyCategorySpending,
            'familyTotalSpending' => $familyTotalSpending,
            'familyTotalTransactions' => $familyTotalTransactions,
            'familyAverageSpending' => $familyAverageSpending,
            'currencies' => $currencies,
            'currency' => $currency,
            'descriptiveStats' => $descriptiveStats,
            'concentrationStats' => $concentrationStats,
            'trendAnalysis' => $trendAnalysis,
            'isPremium' => $isPremium,
            'regionalComparison' => $regionalComparison,
            'trendAnalysis' => $trendAnalysis,
            'profitLossTrend' => $profitLossTrend,
            'profitLossDataJson' => json_encode($profitLossTrend)

        ]);
        // dump($_SESSION);
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
        $user_name = $_SESSION['user_name'] ?? 'Użytkownik';
        $family_name = $_SESSION['family_name'] ?? 'Brak';

        $period = $_GET['period'] ?? 'monthly';
        $type = $_GET['type'] ?? 'summary';
        $date_from = $_GET['date_from'] ?? null;
        $date_to = $_GET['date_to'] ?? null;
        $currency = $_GET['currency'] ?? 'PLN';

        if ($date_from && $date_to) {
            $period = 'custom';
        }

        $summary = $this->analysis->getSummary($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $categories = $this->analysis->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'expense', $date_from, $date_to);
        $topExpenses = $this->analysis->getTopExpenses($user_id, $family_id, $currency, $period, $date_from, $date_to);
        $incomeCategories = $this->analysis->getCategoryBreakdown($user_id, $family_id, $currency, $period, 'income', $date_from, $date_to);
        $paymentMethodBreakdown = $this->analysis->getPaymentMethodBreakdown($user_id, $family_id, $currency, $period, $date_from, $date_to);

        $total_income = $summary['income'] ?? 0;
        $total_expense = $summary['expense'] ?? 0;
        $balance = $total_income - $total_expense;
        $savings_rate = ($total_income > 0) ? ($balance / $total_income) * 100 : 0;

        $generation_date = date('Y-m-d H:i:s');
        $period_names = [
            'monthly' => 'Miesięczny',
            'quarterly' => 'Kwartalny',
            'semiannual' => 'Półroczny',
            'yearly' => 'Roczny',
            'custom' => 'Niestandardowy'
        ];
        $period_name = $period_names[$period] ?? 'Niestandardowy';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator("System Zarządzania Finansami");
        $pdf->SetAuthor($user_name);
        $pdf->SetTitle("Raport finansowy - {$period_name}");
        $pdf->SetSubject('Analiza finansowa');
        $pdf->setHeaderFont(array('dejavusans', '', 10));
        $pdf->setFooterFont(array('dejavusans', '', 8));
        $pdf->SetMargins(15, 25, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 10);

        $html = '
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="color: #2c3e50; font-size: 24px; margin-bottom: 5px;">
                <strong>RAPORT FINANSOWY</strong>
            </h1>
        </div>
    
        <table border="0" cellpadding="5" cellspacing="0" width="100%" style="margin-bottom: 20px;">
            <tr>
                <td width="50%" style="border-right: 1px solid #eee; padding-right: 10px;">
                    <strong>Użytkownik:</strong> ' . htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8') . '<br>
                    ' . ($family_name ? '<strong>Rodzina:</strong> ' . htmlspecialchars($family_name, ENT_QUOTES, 'UTF-8') . '<br>' : '') . '
                    <strong>Waluta:</strong> ' . htmlspecialchars($currency, ENT_QUOTES, 'UTF-8') . '
                </td>
                <td width="50%" style="padding-left: 10px;">
                    <strong>Okres:</strong> ' . ($date_from ? htmlspecialchars($date_from, ENT_QUOTES, 'UTF-8') : 'Brak') . ' - ' . ($date_to ? htmlspecialchars($date_to, ENT_QUOTES, 'UTF-8') : 'Brak') . '<br>
                    <strong>Wygenerowano:</strong> ' . $generation_date . '<br>
                    <strong>Typ raportu:</strong> ' . $this->getReportTypeName($type) . '
                </td>
            </tr>
        </table>';

        switch ($type) {
            case 'categories':
                $html .= $this->generateCategoriesReport($categories, $incomeCategories, $currency);
                break;

            case 'payments':
                $html .= $this->generatePaymentsReport($paymentMethodBreakdown, $currency);
                break;
            case 'detailed':
                $html .= $this->generateDetailedReport($summary, $categories, $incomeCategories, $paymentMethodBreakdown, $topExpenses, $currency);
                break;

            default:
                $html .= $this->generateSummaryReport($summary, $total_income, $total_expense, $balance, $savings_rate, $currency);
                break;
        }

        $pdf->writeHTML($html, true, false, true, false, '');

        $filename = 'raport_finansowy_' . $this->getReportTypeName($type) . '_' . date('Y-m-d') . '.pdf';

        $pdf->Output($filename, 'D');
    }

    /**
     * Pomocnicza metoda do generowania nazw typów raportów
     */
    private function getReportTypeName($type)
    {
        $names = [
            'summary' => 'Podsumowanie',
            'categories' => 'Kategorie',
            'payments' => 'Płatności',
            'top' => 'Top wydatki',
            'trends' => 'Trendy',
            'detailed' => 'Szczegółowy'
        ];

        return $names[$type] ?? 'Nieznany';
    }

    /**
     * Generuje raport podsumowania
     */
    private function generateSummaryReport($summary, $total_income, $total_expense, $balance, $savings_rate, $currency)
    {
        $balance_color = ($balance >= 0) ? '#27ae60' : '#e74c3c';
        $savings_color = ($savings_rate >= 20) ? '#27ae60' : (($savings_rate >= 10) ? '#f39c12' : '#e74c3c');
        $precision = $this->getCurrencyPrecision($currency);
        $html = '
        <h3 style="padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <i class="bi bi-speedometer2"></i> Podsumowanie finansowe
        </h3>
    
        <table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
            <tr style="background-color: #f8f9fa;">
                <th width="25%" style="text-align: left; padding: 10px; border: 1px solid #dee2e6;">Wskaźnik</th>
                <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">Kwota</th>
                <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">% całkowitych</th>
                <th width="25%" style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">Analiza</th>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><strong>Przychody całkowite</strong></td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6; color: #27ae60;">
                    <strong>' . number_format($total_income, $precision, ',', ' ') . ' ' . $currency . '</strong>
                </td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">100%</td>
                <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                    <span style="color: #27ae60;">✓ Dodatnie</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><strong>Wydatki całkowite</strong></td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6; color: #e74c3c;">
                    <strong>' . number_format($total_expense, $precision, ',', ' ') . ' ' . $currency . '</strong>
                </td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">
                    ' . ($total_income > 0 ? number_format(($total_expense / $total_income) * 100, 1, ',', ' ') : '0') . '%
                </td>
                <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                    ' . ($total_expense <= $total_income ? '<span style="color: #27ae60;">✓ W normie</span>' : '<span style="color: #e74c3c;">✗ Przekroczone</span>') . '
                </td>
            </tr>
            <tr style="background-color: ' . ($balance >= 0 ? '#d5f4e6' : '#fadbd8') . ';">
                <td style="padding: 10px; border: 1px solid #dee2e6;"><strong>BILANS (zysk/strata)</strong></td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6; color: ' . $balance_color . ';">
                    <strong>' . number_format($balance, $precision, ',', ' ') . ' ' . $currency . '</strong>
                </td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">
                    ' . ($total_income > 0 ? number_format(($balance / $total_income) * 100, 1, ',', ' ') : '0') . '%
                </td>
                <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                    ' . ($balance >= 0 ? '<span style="color: #27ae60;">✓ Dodatni</span>' : '<span style="color: #e74c3c;">✗ Ujemny</span>') . '
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #dee2e6;"><strong>Wskaźnik oszczędności</strong></td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6; color: ' . $savings_color . ';">
                    <strong>' . number_format($savings_rate, 1, ',', ' ') . '%</strong>
                </td>
                <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">-</td>
                <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                    ' . ($savings_rate >= 20 ? '<span style="color: #27ae60;">✓ Bardzo dobry</span>' : ($savings_rate >= 10 ? '<span style="color: #f39c12;">● Dobry</span>' :
            '<span style="color: #e74c3c;">✗ Do poprawy</span>')) . '
                </td>
            </tr>
        </table>';

        return $html;
    }

    /**
     * Generuje raport kategorii
     */
    private function generateCategoriesReport($expenseCategories, $incomeCategories, $currency)
    {
        $html = '
        <h3 style="padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <i class="bi bi-tags-fill"></i> Analiza kategorii
        </h3>';

        if (!empty($expenseCategories)) {
            $total_expenses = array_sum(array_column($expenseCategories, 'total'));

            $html .= '
            <h4 style="color: #e74c3c; margin-top: 20px; padding-bottom: 5px; border-bottom: 2px solid #e74c3c;">
                Wydatki według kategorii
            </h4>
        
            <table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
                <tr style="background-color: #f8f9fa;">
                    <th width="5%" style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">#</th>
                    <th width="45%" style="text-align: left; padding: 10px; border: 1px solid #dee2e6;">Kategoria</th>
                    <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">Kwota</th>
                    <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">Udział %</th>
                </tr>';

            $counter = 1;
            foreach ($expenseCategories as $category) {
                $percentage = ($total_expenses > 0) ? ($category['total'] / $total_expenses) * 100 : 0;
                $bar_width = min($percentage * 2, 100);
                $precision = $this->getCurrencyPrecision($currency);

                $html .= '
                    <tr>
                        <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">' . $counter . '</td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">
                            ' . htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') . '
                        </td>
                        <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">
                            ' . number_format($category['total'], $precision, ',', ' ') . ' ' . $currency . '
                        </td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">
                            <div style="overflow: hidden;">
                                <div style="background-color: ' . ($counter <= 3 ? '#e74c3c' : '#f39c12') . '; 
                                            height: 100%; 
                                            width: ' . $bar_width . '%; 
                                            text-align: right; 
                                            padding-right: 5px; 
                                            line-height: 20px; 
                                            color: white; 
                                            font-size: 11px;">
                                    ' . number_format($percentage, 1, ',', ' ') . '%
                                </div>
                            </div>
                        </td>
                    </tr>';
                $counter++;
            }

            $html .= '
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td colspan="2" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">RAZEM:</td>
                        <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6; color: #e74c3c;">
                            ' . number_format($total_expenses, $precision, ',', ' ') . ' ' . $currency . '
                        </td>
                        <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">100%</td>
                    </tr>
            </table>';
        }

        if (!empty($incomeCategories)) {
            $total_income = array_sum(array_column($incomeCategories, 'total'));

            $html .= '
            <h4 style="color: #27ae60; margin-top: 20px; padding-bottom: 5px; border-bottom: 2px solid #27ae60;">
                Przychody według kategorii
            </h4>
        
            <table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
                <tr style="background-color: #f8f9fa;">
                    <th width="5%" style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">#</th>
                    <th width="45%" style="text-align: left; padding: 10px; border: 1px solid #dee2e6;">Kategoria</th>
                    <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">Kwota</th>
                    <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">Udział %</th>
                </tr>';

            $counter = 1;
            foreach ($incomeCategories as $category) {
                $percentage = ($total_income > 0) ? ($category['total'] / $total_income) * 100 : 0;
                $bar_width = min($percentage * 2, 100);

                $html .= '
                    <tr>
                        <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">' . $counter . '</td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">
                            ' . htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') . '
                        </td>
                        <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">
                            ' . number_format($category['total'], $precision, ',', ' ') . ' ' . $currency . '
                        </td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">
                            <div style="overflow: hidden;">
                                <div style="background-color: ' . ($counter <= 3 ? '#27ae60' : '#2ecc71') . '; 
                                            height: 100%; 
                                            width: ' . $bar_width . '%; 
                                            text-align: right; 
                                            padding-right: 5px; 
                                            line-height: 20px; 
                                            color: white; 
                                            font-size: 11px;">
                                    ' . number_format($percentage, 1, ',', ' ') . '%
                                </div>
                            </div>
                        </td>
                    </tr>';
                $counter++;
            }

            $html .= '
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td colspan="2" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">RAZEM:</td>
                        <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6; color: #27ae60;">
                            ' . number_format($total_income, $precision, ',', ' ') . ' ' . $currency . '
                        </td>
                        <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">100%</td>
                    </tr>
            </table>';
        }

        if (!empty($expenseCategories) && !empty($incomeCategories)) {
            $top_expense_category = $expenseCategories[0] ?? null;
            $top_income_category = $incomeCategories[0] ?? null;

            $html .= '
            <div style="padding: 15px; border-radius: 5px; margin-top: 20px;">
                <h4 style="margin-top: 0; color: #2c3e50;">Kluczowe informacje:</h4>
                <table width="100%" cellpadding="5">
                    <tr>
                        <td width="50%" valign="top">
                            <strong>Główne źródło wydatków:</strong><br>
                            ' . ($top_expense_category ? htmlspecialchars($top_expense_category['name'], ENT_QUOTES, 'UTF-8') . ' (' . number_format(($top_expense_category['total'] / $total_expenses) * 100, 1, ',', ' ') . '%)' : 'Brak danych') . '
                        </td>
                        <td width="50%" valign="top">
                            <strong>Główne źródło przychodów:</strong><br>
                            ' . ($top_income_category ?
                htmlspecialchars($top_income_category['name'], ENT_QUOTES, 'UTF-8') . ' (' .
                number_format(($top_income_category['total'] / $total_income) * 100, 1, ',', ' ') . '%)' :
                'Brak danych') . '
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 10px;">
                            <strong>Liczba kategorii wydatków:</strong> ' . count($expenseCategories) . '<br>
                            <strong>Liczba kategorii przychodów:</strong> ' . count($incomeCategories) . '
                        </td>
                    </tr>
                </table>
            </div>';
        }

        return $html;
    }

    /**
     * Generuje raport płatności
     */
    private function generatePaymentsReport($paymentMethods, $currency)
    {
        if (empty($paymentMethods)) {
            return '
            <div style="text-align: center; padding: 40px; color: #7f8c8d;">
                <h4>Brak danych o metodach płatności</h4>
                <p>Nie znaleziono transakcji z metodami płatności w wybranym okresie.</p>
            </div>';
        }

        $total = array_sum(array_column($paymentMethods, 'total_spent'));

        $html = '
        <h3 style="padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            Analiza metod płatności
        </h3>
        
        <table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
            <tr style="background-color: #f8f9fa;">
                <th width="5%" style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">#</th>
                <th width="45%" style="text-align: left; padding: 10px; border: 1px solid #dee2e6;">Metoda płatności</th>
                <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">Kwota</th>
                <th width="25%" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">Udział %</th>
            </tr>';

        $counter = 1;
        foreach ($paymentMethods as $payment) {
            $percentage = ($total > 0) ? ($payment['total_spent'] / $total) * 100 : 0;
            $payment_name = $this->getPaymentMethodName($payment['payment_method']);
            $precision = $this->getCurrencyPrecision($currency);

            $html .= '
                <tr>
                    <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">' . $counter . '</td>
                    <td style="padding: 10px; border: 1px solid #dee2e6;">
                        ' . $payment_name . '
                    </td>
                    <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">
                        ' . number_format($payment['total_spent'], $precision, ',', ' ') . ' ' . $currency . '
                    </td>
                    <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">
                        ' . number_format($percentage, 1, ',', ' ') . '%
                    </td>
                </tr>';
            $counter++;
        }

        $html .= '
                <tr style="background-color: #f8f9fa; font-weight: bold;">
                    <td colspan="2" style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">RAZEM:</td>
                    <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6; color: #3498db;">
                        ' . number_format($total, $precision, ',', ' ') . ' ' . $currency . '
                    </td>
                    <td style="text-align: right; padding: 10px; border: 1px solid #dee2e6;">100%</td>
                </tr>
            </table>
            
            <div style="padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <h4 style="margin-top: 0; color: #2c3e50;">Analiza zachowań płatniczych:</h4>
                <ul style="margin-bottom: 0;">
                    <li><strong>Dominująca metoda płatności:</strong> ' . $this->getPaymentMethodName($paymentMethods[0]['payment_method']) . ' (' .
            number_format(($paymentMethods[0]['total_spent'] / $total) * 100, 1, ',', ' ') . '%)</li>
                    <li><strong>Liczba różnych metod płatności:</strong> ' . count($paymentMethods) . '</li>
                </ul>
            </div>';

        return $html;
    }

    /**
     * Pomocnicza metoda do tłumaczenia nazw metod płatności
     */
    private function getPaymentMethodName($method)
    {
        $names = [
            'cash' => 'Gotówka',
            'card' => 'Karta płatnicza',
            'crypto' => 'Kryptowaluta',
        ];

        return $names[$method] ?? ucfirst(str_replace('_', ' ', $method));
    }



    /**
     * Generuje szczegółowy raport (wszystkie dane)
     */
    private function generateDetailedReport($summary, $categories, $incomeCategories, $paymentMethods, $topExpenses, $currency)
    {
        $html = '
        <h3 style="margin-bottom: 15px;">
            <i class="bi bi-file-earmark-text-fill"></i> Szczegółowy raport finansowy
        </h3>
    
        <p style="color: #7f8c8d;">
            Ten raport zawiera kompleksową analizę wszystkich aspektów finansowych w wybranym okresie.
        </p>';

        // Sekcja 1: Podsumowanie
        $total_income = $summary['income'] ?? 0;
        $total_expense = $summary['expense'] ?? 0;
        $balance = $total_income - $total_expense;
        $precision = $this->getCurrencyPrecision($currency);


        $html .= '
        <div style="page-break-inside: avoid; margin-bottom: 30px;">
            <h4 style="color: #2c3e50; padding-bottom: 5px; margin-bottom: 15px;">
                1. Podsumowanie finansowe
            </h4>
        
            <table border="0" cellpadding="8" cellspacing="0" width="100%" style="margin-bottom: 15px;">
                <tr>
                    <td width="33%" style="text-align: center; padding: 15px; background-color: #27ae60; color: white; border-radius: 5px;">
                        <div style="font-size: 20px; font-weight: bold;">Przychody</div>
                        <div style="font-size: 24px; margin-top: 5px;">
                            ' . number_format($total_income, $precision, ',', ' ') . ' ' . $currency . '
                        </div>
                    </td>
                    <td width="34%" style="text-align: center; padding: 15px; background-color: #e74c3c; color: white; border-radius: 5px;">
                        <div style="font-size: 20px; font-weight: bold;">Wydatki</div>
                        <div style="font-size: 24px; margin-top: 5px;">
                            ' . number_format($total_expense, $precision, ',', ' ') . ' ' . $currency . '
                        </div>
                    </td>
                    <td width="33%" style="text-align: center; padding: 15px; background-color: ' . ($balance >= 0 ? '#27ae60' : '#e74c3c') . '; color: white; border-radius: 5px;">
                        <div style="font-size: 20px; font-weight: bold;">Bilans</div>
                        <div style="font-size: 24px; margin-top: 5px;">
                            ' . number_format($balance, $precision, ',', ' ') . ' ' . $currency . '
                        </div>
                    </td>
                </tr>
            </table>
        </div>';

        // Sekcja 2: Kategorie
        if (!empty($categories) || !empty($incomeCategories)) {
            $html .= '
            <div style="page-break-inside: avoid; margin-bottom: 30px;">
                <h4 style="color: #2c3e50; padding-bottom: 5px; margin-bottom: 15px;">
                    2. Analiza kategorii
                </h4>';

            if (!empty($categories)) {
                $html .= '
                <h5 style="color: #e74c3c; margin-top: 15px;">Wydatki według kategorii</h5>
                <table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
                    <tr style="background-color: #f8f9fa;">
                        <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">Kategoria</th>
                        <th style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">Kwota</th>
                        <th style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">%</th>
                    </tr>';

                foreach ($categories as $category) {
                    $html .= '
                    <tr>
                        <td style="padding: 8px; border: 1px solid #dee2e6;">' . htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') . '</td>
                        <td style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">' .
                        number_format($category['total'], $precision, ',', ' ') . ' ' . $currency . '</td>
                        <td style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">' .
                        ($total_expense > 0 ? number_format(($category['total'] / $total_expense) * 100, 1, ',', ' ') : '0') . '%</td>
                    </tr>';
                }
                $html .= '</table>';
            }

            if (!empty($incomeCategories)) {
                $html .= '
                <h5 style="color: #27ae60; margin-top: 15px;">Przychody według kategorii</h5>
                <table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 15px; font-size: 11px;">
                    <tr style="background-color: #f8f9fa;">
                        <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">Kategoria</th>
                        <th style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">Kwota</th>
                        <th style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">%</th>
                    </tr>';

                foreach ($incomeCategories as $category) {
                    $html .= '
                    <tr>
                        <td style="padding: 8px; border: 1px solid #dee2e6;">' . htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') . '</td>
                        <td style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">' .
                        number_format($category['total'], $precision, ',', ' ') . ' ' . $currency . '</td>
                        <td style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">' .
                        ($total_income > 0 ? number_format(($category['total'] / $total_income) * 100, 1, ',', ' ') : '0') . '%</td>
                    </tr>';
                }
                $html .= '</table>';
            }

            $html .= '</div>';
        }

        // Sekcja 3: Metody płatności
        if (!empty($paymentMethods)) {
            $html .= '
            <div style="page-break-inside: avoid; margin-bottom: 30px;">
                <h4 style="color: #2c3e50; padding-bottom: 5px; margin-bottom: 15px;">
                    3. Metody płatności
                </h4>
            
            <table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; font-size: 11px;">
                <tr style="background-color: #f8f9fa;">
                    <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">Metoda</th>
                    <th style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">Kwota</th>
                    <th style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">%</th>
                </tr>';

            foreach ($paymentMethods as $payment) {
                $html .= '
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">' . $this->getPaymentMethodName($payment['payment_method']) . '</td>
                    <td style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">' .
                    number_format($payment['total_spent'], $precision, ',', ' ') . ' ' . $currency . '</td>
                    <td style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">' .
                    ($total_expense > 0 ? number_format(($payment['total_spent'] / $total_expense) * 100, 1, ',', ' ') : '0') . '%</td>
                </tr>';
            }
            $html .= '</table>
        </div>';
        }

        // Sekcja 4: Największe wydatki
        if (!empty($topExpenses)) {
            $html .= '
            <div style="page-break-inside: avoid; margin-bottom: 30px;">
                <h4 style="color: #2c3e50; padding-bottom: 5px; margin-bottom: 15px;">
                    4. Największe wydatki
                </h4>
            
<table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse; font-size: 11px; width: 100% !important;">
                    <tr style="background-color: #f8f9fa;">
                        <th width="5%" style="text-align: center; padding: 8px; border: 1px solid #dee2e6;">#</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">Opis</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #dee2e6;">Kategoria</th>
                        <th style="text-align: center; padding: 8px; border: 1px solid #dee2e6;">Data</th>
                        <th style="text-align: right; padding: 8px; border: 1px solid #dee2e6;">Kwota</th>
                    </tr>';

            $counter = 1;
            foreach ($topExpenses as $expense) {
                $date = date('d.m.Y', strtotime($expense['transaction_date']));

                $html .= '
                <tr>
                    <td style="text-align: center; padding: 8px; border: 1px solid #dee2e6;">' . $counter . '</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">' .
                    htmlspecialchars($expense['description'], ENT_QUOTES, 'UTF-8') . '</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">' .
                    ($expense['category_name'] ? htmlspecialchars($expense['category_name'], ENT_QUOTES, 'UTF-8') : 'Brak') . '</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #dee2e6;">' . $date . '</td>
                    <td style="text-align: right; padding: 8px; border: 1px solid #dee2e6; color: #e74c3c;">' .
                    number_format($expense['amount'], $precision, ',', ' ') . ' ' . $currency . '</td>
                </tr>';
                $counter++;
            }
            $html .= '</table>
        </div>';
        }

        // Sekcja 5: Podsumowanie i rekomendacje
        $html .= '
        <div style="page-break-inside: avoid; margin-bottom: 30px;">
            <h4 style="color: #2c3e50; padding-bottom: 5px; margin-bottom: 15px;">
                5. Podsumowanie i rekomendacje
            </h4>
        
            <div style="padding: 15px; border-radius: 5px;">
                <h5 style="margin-top: 0; color: #2c3e50;">Kluczowe wnioski:</h5>
                <ul>';

        if ($balance >= 0) {
            $html .= '<li><strong style="color: #27ae60;">Pozytywny bilans finansowy</strong> - Twoje przychody przewyższają wydatki</li>';
        } else {
            $html .= '<li><strong style="color: #e74c3c;">Ujemny bilans finansowy</strong> - Wydatki przekraczają przychody o ' .
                number_format(abs($balance), $precision, ',', ' ') . ' ' . $currency . '</li>';
        }

        if (!empty($categories)) {
            $top_category = $categories[0];
            $html .= '<li><strong>Główna kategoria wydatków:</strong> ' .
                htmlspecialchars($top_category['name'], ENT_QUOTES, 'UTF-8') . ' (' .
                number_format(($top_category['total'] / $total_expense) * 100, 1, ',', ' ') . '% całkowitych wydatków)</li>';
        }

        if (!empty($paymentMethods)) {
            $top_payment = $paymentMethods[0];
            $html .= '<li><strong>Dominująca metoda płatności:</strong> ' .
                $this->getPaymentMethodName($top_payment['payment_method']) . ' (' .
                number_format(($top_payment['total_spent'] / $total_expense) * 100, 1, ',', ' ') . '%)</li>';
        }

        $html .= '
            </ul>
            
            <h5 style="color: #2c3e50; margin-top: 15px;">Sugestie optymalizacji:</h5>
            <ol>
                <li><strong>Monitoruj główne kategorie wydatków</strong> - Rozważ redukcję w największych obszarach</li>
                <li><strong>Zróżnicuj metody płatności</strong> - Wykorzystuj promocje bankowe</li>
                <li><strong>Analizuj regularnie</strong> - Przeglądaj raporty co miesiąc</li>
                <li><strong>Ustal cele oszczędnościowe</strong> - Dąż do wskaźnika oszczędności 20%</li>
            </ol>
        </div>
    </div>';

        return $html;
    }

    /**
     * Określa precyzję dla danej waluty
     */
    private function getCurrencyPrecision($currency)
    {
        $crypto_currencies = ['BTC', 'ETH', 'BNB', 'XRP', 'DOGE', 'USDT', 'SOL', 'ADA', 'TRX', 'LTC', 'DOT'];

        if (in_array(strtoupper($currency), $crypto_currencies)) {
            return 8; // 8 miejsc dla kryptowalut
        }

        // Specjalne przypadki
        $special_cases = [
            'JPY' => 0,   // Jen japoński - 0 miejsc
            'KRW' => 0,   // Won koreański - 0 miejsc
            'VND' => 0,   // Dong wietnamski - 0 miejsc
            'IDR' => 0,   // Rupia indonezyjska - 0 miejsc
            'CLP' => 0,   // Peso chilijskie - 0 miejsc
        ];

        if (isset($special_cases[strtoupper($currency)])) {
            return $special_cases[strtoupper($currency)];
        }

        return 2; // Domyślnie 2 miejsca dla większości walut fiducjarnych
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
        $date_from = $_GET['date_from'] ?? null;
        $date_to = $_GET['date_to'] ?? null;

        if (!$date_from && !$date_to) {
            $date_from = date('Y-m-01'); // Pierwszy dzień miesiąca
            $date_to = date('Y-m-t');    // Ostatni dzień miesiąca
        }

        if ($date_from && $date_to) {
            $period = 'custom';
        }

        $currencies = $this->analysis->getActiveCurrencies($user_id, $family_id, $period, $date_from, $date_to);
        $currency = $_GET['currency'] ?? ($currencies[0]['currency'] ?? 'PLN');

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
