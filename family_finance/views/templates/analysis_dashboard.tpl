{include file="header.tpl"}

<h2 class="mb-4 text-primary fw-bold"><i class="bi bi-bar-chart"></i> Analiza Finansowa</h2>

<!-- Formularz filtrowania z wyborem waluty -->
<form method="get" action="index.php" class="mb-5 p-3 border rounded-3 bg-dark shadow-sm row g-3 align-items-end">
    <input type="hidden" name="action" value="analysisDashboard">

    <div class="col-md-3 col-lg-2">
        <label for="date_from" class="form-label fw-semibold text-muted">Data początkowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
            <input type="date" id="date_from" name="date_from" class="form-control" value="{$date_from}">
        </div>
    </div>

    <div class="col-md-3 col-lg-2">
        <label for="date_to" class="form-label fw-semibold text-muted">Data końcowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
            <input type="date" id="date_to" name="date_to" class="form-control" value="{$date_to}">
        </div>
    </div>

    <div class="col-md-3 col-lg-2">
        <label for="currency" class="form-label fw-semibold text-muted">Waluta:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
            <select id="currency" name="currency" class="form-select">
                {foreach $currencies as $curr}
                    <option value="{$curr.currency}" {if $currency == $curr.currency}selected{/if}>
                        {$curr.currency}
                    </option>
                {/foreach}
            </select>
        </div>
    </div>

    <div class="col-md-3 col-lg-6 d-flex justify-content-start align-items-end">
        <button type="submit" class="btn btn-primary me-2"><i class="bi bi-funnel-fill me-1"></i> Filtruj</button>
        <a href="index.php?action=analysisDashboard" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-clockwise me-1"></i>Resetuj
        </a>
    </div>
</form>

<ul class="nav nav-tabs nav-tabs-modern mb-4 shadow-sm" id="analysisTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button"
            role="tab"><i class="bi bi-speedometer2 me-2"></i>Podsumowanie</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="trend-tab" data-bs-toggle="tab" data-bs-target="#trend" type="button" role="tab"><i
                class="bi bi-graph-up me-2"></i>Trendy</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button"
            role="tab"><i class="bi bi-tags-fill me-2"></i>Kategorie</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="subcategories-tab" data-bs-toggle="tab" data-bs-target="#subcategories"
            type="button" role="tab"><i class="bi bi-tag me-2"></i>Podkategorie wydatki</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="subcategories-income-tab" data-bs-toggle="tab"
            data-bs-target="#subcategories-income" type="button" role="tab"><i
                class="bi bi-tag-fill me-2"></i>Podkategorie przychody</button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button"
            role="tab"><i class="bi bi-credit-card-2-front-fill me-2"></i>Płatności</button>
    </li>
    {if isset($session.family_id)}
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button"
                role="tab"><i class="bi bi-people-fill me-2"></i>Członkowie Rodziny</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="regional-tab" data-bs-toggle="tab" data-bs-target="#regional" type="button"
                role="tab"><i class="bi bi-geo-alt-fill me-2"></i>Regiony</button>
        </li>
    {/if}
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="econometrics-tab" data-bs-toggle="tab" data-bs-target="#econometrics" type="button"
            role="tab"><i class="bi bi-calculator me-2"></i>Analiza Ekonometryczna</button>
    </li>
</ul>

<div class="tab-content" id="analysisTabsContent">

    <div class="tab-pane fade show active" id="summary" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-lg border-start border-5 border-primary">
                    <div class="card-body">
                        <h4 class="card-title text-primary"><i class="bi bi-cash-stack me-2"></i>Podsumowanie Finansów
                        </h4>
                        <hr>
                        {if $summary.income > 0 or $summary.expense > 0}
                            <p class="fs-5 mb-2">
                                <span class="fw-bold text-success"><i
                                        class="bi bi-arrow-up-right-circle-fill me-2"></i>Przychody:</span>
                                <span class="float-end">{$summary.income|number_format:2:",":" "} {$currency}</span>
                            </p>
                            <p class="fs-5 mb-2">
                                <span class="fw-bold text-danger"><i
                                        class="bi bi-arrow-down-left-circle-fill me-2"></i>Wydatki:</span>
                                <span class="float-end">{$summary.expense|number_format:2:",":" "} {$currency}</span>
                            </p>
                            <p class="fs-4 fw-bold mt-4 pt-2 border-top 
                               {if ($summary.income - $summary.expense) >= 0}text-success{else}text-danger{/if}">
                                <i class="bi bi-balance-fill me-2"></i>Bilans:
                                <span class="float-end">{($summary.income - $summary.expense)|number_format:2:",":" "}
                                    {$currency}</span>
                            </p>
                        {else}
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych finansowych w wybranym okresie</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-8">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h4 class="card-title text-danger"><i class="bi bi-bag-x-fill me-2"></i>Top 10 Największych
                            Wydatków</h4>
                        <hr>
                        {if $topExpenses}
                            <div class="list-group list-group-flush">
                                {foreach $topExpenses as $index => $e}
                                    <div class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="me-3">
                                            <span class="badge bg-secondary me-2">{$index + 1}</span>
                                        </div>
                                        <div class="flex-grow-1 me-3">
                                            <div class="fw-semibold mb-1">{$e.description}</div>
                                            <div class="small text-muted">
                                                <span class="me-3">
                                                    <i class="bi bi-tag me-1"></i>
                                                    {if $e.category_name}
                                                        {$e.category_name}
                                                    {else}
                                                        <span class="text-warning">Brak kategorii</span>
                                                    {/if}
                                                </span>

                                                <span class="me-3">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    {$e.transaction_date|date_format:"%d.%m.%Y"}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-danger fs-5">{$e.amount|number_format:2:",":" "}
                                                {$currency}</div>
                                            <div class="small text-muted">
                                                {if $e.payment_method == 'cash'}
                                                    <i class="bi bi-cash-coin"></i> Gotówka
                                                {elseif $e.payment_method == 'card'}
                                                    <i class="bi bi-credit-card"></i> Karta
                                                {elseif $e.payment_method == 'crypto'}
                                                    <i class="bi bi-currency-bitcoin"></i> Krypto
                                                {else}
                                                    {$e.payment_method}
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        {else}
                            <div class="text-center py-4">
                                <i class="bi bi-receipt display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak wydatków w wybranym okresie</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="trend" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-12 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-danger"><i class="bi bi-graph-down me-2"></i>Trend wydatków
                            ({$currency})</h5>
                        {if $trend && count($trend) > 0}
                            <canvas id="trendExpensesChart" height="150"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-graph-down display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o trendzie wydatków</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-graph-up me-2"></i>Trend przychodów
                            ({$currency})</h5>
                        {if $trendIncome && count($trendIncome) > 0}
                            <canvas id="trendIncomeChart" height="150"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-graph-up display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o trendzie przychodów</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="categories" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-danger"><i class="bi bi-pie-chart-fill me-2"></i>Struktura wydatków
                            ({$currency})</h5>
                        {if $categories && count($categories) > 0}
                            <canvas id="categoryExpensesChart"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-pie-chart display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o kategoriach wydatków</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-pie-chart-fill me-2"></i>Struktura
                            przychodów ({$currency})</h5>
                        {if $incomeCategories && count($incomeCategories) > 0}
                            <canvas id="categoryIncomeChart"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-pie-chart display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o kategoriach przychodów</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-info"><i class="bi bi-percent me-2"></i>Procentowy udział wydatków
                        </h5>
                        {if $categoryPercentages && count($categoryPercentages) > 0}
                            <canvas id="categoryPercentChart"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-percent display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych do analizy procentowej</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="subcategories" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-danger"><i class="bi bi-journal-text me-2"></i>Wydatki wg
                            podkategorii ({$currency})</h5>
                        {if $subCategoryExpenses && count($subCategoryExpenses) > 0}
                            <canvas id="subCategoryChart"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-tags display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o podkategoriach wydatków</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Podkategorie Przychody -->
    <div class="tab-pane fade" id="subcategories-income" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-journal-text me-2"></i>Przychody wg
                            podkategorii ({$currency})</h5>
                        {if $subCategoryIncome && count($subCategoryIncome) > 0}
                            <canvas id="subCategoryIncomeChart"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-tags display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o podkategoriach przychodów</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="payments" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-12 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-wallet-fill me-2"></i>Wydatki wg rodzaju
                            płatności ({$currency})</h5>
                        {if $paymentMethodBreakdown && count($paymentMethodBreakdown) > 0}
                            <canvas id="paymentChart"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-credit-card display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o metodach płatności</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Członkowie Rodziny -->
    <div class="tab-pane fade" id="members" role="tabpanel">
        <div class="row g-4">

            <!-- Szczegółowa tabela -->
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-info"><i class="bi bi-table me-2"></i>Statystyki członków</h5>
                        {if $familySpending && count($familySpending) > 0}
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Członek</th>
                                            <th class="text-end">Wydatki</th>
                                            <th class="text-end">Transakcje</th>
                                            <th class="text-end">Średnia</th>
                                            <th class="text-end">Udział</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {foreach $familySpending as $member}
                                            <tr>
                                                <td>
                                                    <i class="bi bi-person-circle me-2"></i>
                                                    {$member.username}
                                                    {if $member.user_id == $session.user_id}
                                                        <span class="badge bg-primary ms-1">Ty</span>
                                                    {/if}
                                                </td>
                                                <td class="text-end fw-bold">{$member.total_spent|number_format:2:",":" "}
                                                    {$currency}</td>
                                                <td class="text-end">{$member.transactions}</td>
                                                <td class="text-end">{$member.avg_spent|number_format:2:",":" "} {$currency}
                                                </td>
                                                <td class="text-end">
                                                    {assign var="percentage" value=($member.total_spent / $familyTotalSpending * 100)}
                                                    <span class="badge bg-secondary">{$percentage|number_format:1}%</span>
                                                </td>
                                            </tr>
                                        {/foreach}
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark">
                                            <td><strong>Razem</strong></td>
                                            <td class="text-end"><strong>{$familyTotalSpending|number_format:2:",":" "}
                                                    {$currency}</strong></td>
                                            <td class="text-end"><strong>{$familyTotalTransactions}</strong></td>
                                            <td class="text-end"><strong>{$familyAverageSpending|number_format:2:",":" "}
                                                    {$currency}</strong></td>
                                            <td class="text-end"><strong>100%</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        {else}
                            <div class="text-center py-4">
                                <i class="bi bi-table display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych do wyświetlenia</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="tab-pane fade" id="regional" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-secondary"><i class="bi bi-map-fill me-2"></i>Porównanie regionalne
                            wydatków ({$currency})</h5>
                        {if $regionalComparison && count($regionalComparison) > 0}
                            <canvas id="regionalChart" height="100"></canvas>
                        {else}
                            <div class="text-center py-5">
                                <i class="bi bi-map display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych do porównania regionalnego</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analiza Ekonometryczna -->
    <div class="tab-pane fade" id="econometrics" role="tabpanel">
        <div class="row g-4">
            <!-- Podstawowe statystyki -->
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="bi bi-graph-up me-2"></i>Statystyki opisowe wydatków
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    {if $descriptiveStats.count >= 2}
                                        <tr>
                                            <td><strong>Średnia</strong></td>
                                            <td class="text-end">{$descriptiveStats.mean|number_format:2:",":" "}
                                                {$currency}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mediana</strong></td>
                                            <td class="text-end">{$descriptiveStats.median|number_format:2:",":" "}
                                                {$currency}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Odchylenie standardowe</strong></td>
                                            <td class="text-end">{$descriptiveStats.std_dev|number_format:2:",":" "}
                                                {$currency}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Wariancja</strong></td>
                                            <td class="text-end">{$descriptiveStats.variance|number_format:2:",":" "}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kurtoza</strong></td>
                                            <td class="text-end">{$descriptiveStats.kurtosis|number_format:3}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Skosność</strong></td>
                                            <td class="text-end">{$descriptiveStats.skewness|number_format:3}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Współczynnik zmienności</strong></td>
                                            <td class="text-end">
                                                {$descriptiveStats.coefficient_of_variation|number_format:1}%</td>
                                        </tr>
                                    {else}
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle"></i>
                                            Zbyt mało danych w wybranej walucie do obliczenia statystyk
                                        </div>
                                    {/if}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Miary koncentracji -->
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="bi bi-pie-chart me-2"></i>Miary koncentracji
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td><strong>Wskaźnik Giniego</strong></td>
                                        <td class="text-end">{$concentrationStats.gini|number_format:3}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Wskaźnik Herfindahla-Hirschmana</strong></td>
                                        <td class="text-end">{$concentrationStats.hhi|number_format:0}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Wskaźnik koncentracji CR(3)</strong></td>
                                        <td class="text-end">{$concentrationStats.cr3|number_format:1}%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Wskaźnik koncentracji CR(5)</strong></td>
                                        <td class="text-end">{$concentrationStats.cr5|number_format:1}%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Entropia Shannona</strong></td>
                                        <td class="text-end">{$concentrationStats.entropy|number_format:3}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analiza trendu -->
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-warning">
                            <i class="bi bi-trending-up me-2"></i>Analiza trendu czasowego
                        </h5>
                        <canvas id="trendAnalysisChart" height="200"></canvas>
                        <div class="mt-3">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Współczynnik determinacji R²</strong></td>
                                    <td class="text-end">{$trendAnalysis.r_squared|number_format:3}</td>
                                </tr>
                                <tr>
                                    <td><strong>Przeciętne tempo zmian</strong></td>
                                    <td
                                        class="text-end {if $trendAnalysis.growth_rate > 0}text-danger{else}text-success{/if}">
                                        {$trendAnalysis.growth_rate|number_format:2}%
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Statystyka t</strong></td>
                                    <td class="text-end">{$trendAnalysis.t_statistic|number_format:3}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <!-- Sekcja z opisami wskaźników -->
        {* <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle me-2"></i>Objaśnienie wskaźników statystycznych
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Statystyki opisowe -->
                            <div class="col-md-4 mb-3">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="bi bi-graph-up me-2"></i>Statystyki Opisowe
                                </h6>
                                <div class="small">
                                    <p><strong>Średnia</strong> - przeciętna wartość pojedynczego wydatku</p>
                                    <p><strong>Mediana</strong> - wartość środkowa, 50% wydatków jest poniżej tej kwoty
                                    </p>
                                    <p><strong>Odchylenie standardowe</strong> - średnie odchylenie wydatków od średniej
                                    </p>
                                    <p><strong>Wariancja</strong> - średnia kwadratów odchyleń od średniej</p>
                                    <p><strong>Skosność</strong> - asymetria rozkładu:<br>
                                        <span class="text-success">> 0 = prawostronna</span><br>
                                        <span class="text-danger">
                                            < 0=lewostronna</span>
                                    </p>
                                    <p><strong>Kurtoza</strong> - "spiczastość" rozkładu:<br>
                                        <span class="text-success">> 0 = ostry</span><br>
                                        <span class="text-danger">
                                            < 0=płaski</span>
                                    </p>
                                    <p><strong>Wsp. zmienności</strong> - względna zmienność wydatków (%)</p>
                                </div>
                            </div>

                            <!-- Miary koncentracji -->
                            <div class="col-md-4 mb-3">
                                <h6 class="text-success border-bottom pb-2">
                                    <i class="bi bi-pie-chart me-2"></i>Miary Koncentracji
                                </h6>
                                <div class="small">
                                    <p><strong>Wskaźnik Giniego</strong> - nierówność rozkładu:<br>
                                        <span class="text-success">0.0 = równomierny</span><br>
                                        <span class="text-warning">0.3-0.4 = umiarkowany</span><br>
                                        <span class="text-danger">> 0.5 = wysoki</span>
                                    </p>
                                    <p><strong>Wskaźnik HHI</strong> - koncentracja Herfindahla:<br>
                                        <span class="text-success">
                                            < 1500=niska</span><br>
                                                <span class="text-warning">1500-2500 = średnia</span><br>
                                                <span class="text-danger">> 2500 = wysoka</span>
                                    </p>
                                    <p><strong>CR3</strong> - udział 3 największych kategorii</p>
                                    <p><strong>CR5</strong> - udział 5 największych kategorii</p>
                                    <p><strong>Entropia</strong> - różnorodność wydatków:<br>
                                        <span class="text-danger">0 = mała</span><br>
                                        <span class="text-success">> 1 = duża</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Analiza trendu -->
                            <div class="col-md-4 mb-3">
                                <h6 class="text-warning border-bottom pb-2">
                                    <i class="bi bi-trending-up me-2"></i>Analiza Trendu
                                </h6>
                                <div class="small">
                                    <p><strong>Współczynnik R²</strong> - dopasowanie trendu:<br>
                                        <span class="text-danger">0.0-0.3 = słabe</span><br>
                                        <span class="text-warning">0.3-0.7 dobre</span><br>
                                        <span class="text-success">> 0.7 = doskonałe</span>
                                    </p>
                                    <p><strong>Tempo zmian</strong> - dynamika wydatków:<br>
                                        <span class="text-success">
                                            < 0%=spadek</span><br>
                                                <span class="text-danger">> 0% = wzrost</span>
                                    </p>
                                    <p><strong>Statystyka t</strong> - istotność trendu:<br>
                                        <span class="text-danger">
                                            < 2=nieistotny</span><br>
                                                <span class="text-success">> 2 = istotny</span>
                                    </p>
                                    <p><strong>Wykres</strong> - pokazuje rzeczywiste wydatki oraz linię trendu</p>
                                </div>
                            </div>
                        </div>

                        <!-- Praktyczne wskazówki -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-lightbulb me-2"></i>Jak interpretować wyniki?
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li><strong>Wysokie odchylenie</strong> = wydatki bardzo zróżnicowane</li>
                                        <li><strong>Wysoki wskaźnik Giniego</strong> = kilka kategorii dominuje w
                                            budżecie</li>
                                        <li><strong>Wysoki R²</strong> = trend dobrze opisuje Twoje wydatki</li>
                                        <li><strong>Dodatnie tempo zmian</strong> = wydatki rosną w czasie</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> *}
        {* LUB *}
        <!-- Proste objaśnienie dla laika -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0" style="color: #0d6efd;">
                            <i class="bi bi-question-circle me-2" ></i>Co oznaczają te liczby? - Proste wyjaśnienie
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Statystyki opisowe - prosty opis -->
                            <div class="col-md-4 mb-3">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="bi bi-cash-coin me-2"></i>Podstawowe informacje o wydatkach
                                </h6>
                                <div class="small">
                                    <p><strong>Średnia</strong> - Tyle średnio wydajesz na jedną transakcję</p>
                                    <p><strong>Mediana</strong> - Połowa Twoich wydatków jest poniżej tej kwoty</p>
                                    <p><strong>Odchylenie</strong> - Jak bardzo różnią się Twoje wydatki od średniej</p>
                                    <p><strong>Skosność</strong> - Czy masz więcej małych czy dużych wydatków</p>
                                    <p><strong>Zmienność</strong> - Jaki % Twoich wydatków to "niestandardowe" kwoty</p>
                                </div>
                            </div>

                            <!-- Miary koncentracji - prosty opis -->
                            <div class="col-md-4 mb-3">
                                <h6 class="text-success border-bottom pb-2">
                                    <i class="bi bi-pie-chart me-2"></i>Gdzie idą Twoje pieniądze?
                                </h6>
                                <div class="small">
                                    <p><strong>Wskaźnik Giniego</strong> - Czy wydatki są równomierne między kategoriami
                                    </p>
                                    <p><strong>Wskaźnik HHI (Herfindahla-Hirschmana)</strong> - Czy kilka kategorii
                                        "zjada" większość budżetu</p>
                                    <p><strong>CR3</strong> - Ile % wydajesz na 3 główne kategorie</p>
                                    <p><strong>CR5</strong> - Ile % wydajesz na 5 głównych kategorii</p>
                                    <p><strong>Entropia</strong> - Czy wydatki są różnorodne czy skupione</p>
                                </div>
                            </div>

                            <!-- Analiza trendu - prosty opis -->
                            <div class="col-md-4 mb-3">
                                <h6 class="text-warning border-bottom pb-2">
                                    <i class="bi bi-graph-up-arrow me-2"></i>Jak zmieniają się wydatki?
                                </h6>
                                <div class="small">
                                    <p><strong>Współczynnik R²</strong> - Czy da się przewidzieć Twoje wydatki</p>
                                    <p><strong>Tempo zmian</strong> - Czy wydajesz więcej czy mniej niż wcześniej</p>
                                    <p><strong>Statystyka t</strong> - Czy ta zmiana jest "prawdziwa" czy przypadkowa
                                    </p>
                                    <p><strong>Wykres</strong> - Pokazuje rzeczywiste wydatki i ogólny trend</p>
                                </div>
                            </div>
                        </div>

                        <!-- Praktyczne wskazówki dla laika -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-success">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-lightbulb me-2"></i>Co to oznacza dla Ciebie?
                                    </h6>
                                    <ul class="mb-0">
                                        <li><strong>Wysoka średnia</strong> = Duże pojedyncze wydatki</li>
                                        <li><strong>Wysoki wskaźnik Giniego</strong> = Koncentracja na kilku kategoriach
                                        </li>
                                        <li><strong>Dodatnie tempo zmian</strong> = Wydatki rosną - uwaga na budżet!
                                        </li>
                                        <li><strong>Wysoki R²</strong> = Twoje wydatki są przewidywalne</li>
                                        <li><strong>Duże odchylenie</strong> = Wydatki bardzo różne - trudno planować
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Najważniejsze wnioski -->
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Na co zwrócić uwagę?
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Sygnaty ostrzegawcze:</strong>
                                            <ul class="mb-0 small">
                                                <li><i class="bi bi-bar-chart-line-fill"></i> Tempo zmian > 10% (szybki
                                                    wzrost)</li>
                                                <li><i class="bi bi-clipboard"></i> CR3 > 70% (za mało różnorodności)
                                                </li>
                                                <li><i class="bi bi-bar-chart-line-fill"></i> Wskaźnik Giniego > 0.5
                                                    (nierównomierność)</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Dobre sygnały:</strong>
                                            <ul class="mb-0 small">
                                                <li><i class="bi bi-check-square-fill"></i> R² > 0.7 (przewidywalne
                                                    wydatki)</li>
                                                <li><i class="bi bi-arrow-clockwise"></i> Entropia > 1.5 (różnorodne
                                                    wydatki)</li>
                                                <li><i class="bi bi-graph-down"></i> Tempo zmian < 0 (oszczędzanie)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .nav-tabs-modern {
        border-bottom: 2px solid #0d6efd;
    }

    .nav-tabs-modern .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        color: #6c757d;
        transition: all 0.3s ease;
        padding: 0.75rem 1.25rem;
        margin-bottom: -2px;
        font-weight: 500;
    }

    .nav-tabs-modern .nav-link:hover:not(.active) {
        border-color: #e9ecef #e9ecef #dee2e6;
        background-color: #f8f9fa;
        color: #495057;
    }

    .nav-tabs-modern .nav-link.active {
        color: #0d6efd;
        background-color: #fff;
        border-color: #0d6efd #0d6efd #fff;
        border-bottom: 2px solid #fff;
        font-weight: 700;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
    }

    #trendAnalysisChart {
        max-height: 250px !important;
        height: 250px !important;
    }

    /* Responsywność dla mniejszych ekranów */
    @media (max-width: 768px) {
        #trendAnalysisChart {
            max-height: 200px !important;
            height: 200px !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ustalenie stałej, nowoczesnej palety kolorów
    const colors = {
        primary: 'rgba(13, 110, 253, 0.8)',
        success: 'rgba(25, 135, 84, 0.8)',
        danger: 'rgba(220, 53, 69, 0.8)',
        warning: 'rgba(255, 193, 7, 0.8)',
        info: 'rgba(13, 202, 240, 0.8)',
        secondary: 'rgba(108, 117, 125, 0.8)',
        custom1: 'rgba(153, 102, 255, 0.8)',
        custom2: 'rgba(255, 159, 64, 0.8)'
    };

    const chartColors = [
        colors.danger, colors.primary, colors.success, colors.warning, colors.custom1, colors.info, colors.custom2,
        colors.secondary
    ];

    // Funkcja do generowania tła z przeźroczystością
    function getBackgroundColors(baseColor) {
        return baseColor.replace(/, 0\.8\)/, ', 0.2)');
    }

    // Trend wydatków - tylko jeśli są dane
    {if $trend && count($trend) > 0}
        new Chart(document.getElementById('trendExpensesChart'), {
            type: 'line',
            data: {
                labels: [{foreach $trend as $t}'{$t.date}'
                    {if !$t@last},
                    {/if}
                {/foreach}],
                datasets: [{
                    label: 'Wydatki ({$currency})',
                    data: [{foreach $trend as $t}{$t.total}
                        {if !$t@last},
                        {/if}
                    {/foreach}],
                    borderColor: colors.danger.replace(/, 0\.8\)/, ', 1)'),
                    backgroundColor: getBackgroundColors(colors.danger),
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kwota ({$currency})'
                        }
                    }
                }
            }
        });
    {/if}

    // Trend przychodów - tylko jeśli są dane
    {if $trendIncome && count($trendIncome) > 0}
        new Chart(document.getElementById('trendIncomeChart'), {
            type: 'line',
            data: {
                labels: [{foreach $trendIncome as $t}'{$t.date}'
                    {if !$t@last},
                    {/if}
                {/foreach}],
                datasets: [{
                    label: 'Przychody ({$currency})',
                    data: [{foreach $trendIncome as $t}{$t.total}
                        {if !$t@last},
                        {/if}
                    {/foreach}],
                    borderColor: colors.success.replace(/, 0\.8\)/, ', 1)'),
                    backgroundColor: getBackgroundColors(colors.success),
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kwota ({$currency})'
                        }
                    }
                }
            }
        });
    {/if}

    // Kategorie wydatków - tylko jeśli są dane
    {if $categories && count($categories) > 0}
        new Chart(document.getElementById('categoryExpensesChart'), {
            type: 'pie',
            data: {
                labels: [{foreach $categories as $c}'{$c.name}'
                    {if !$c@last},
                    {/if}
                {/foreach}],
                datasets: [{
                    data: [{foreach $categories as $c}{$c.total}
                        {if !$c@last},
                        {/if}
                    {/foreach}],
                    backgroundColor: chartColors.slice(0, {$categories|count})
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + ' {$currency}';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    {/if}

    // Kategorie przychodów - tylko jeśli są dane
    {if $incomeCategories && count($incomeCategories) > 0}
        new Chart(document.getElementById('categoryIncomeChart'), {
            type: 'pie',
            data: {
                labels: [{foreach $incomeCategories as $c}'{$c.name}'
                    {if !$c@last},
                    {/if}
                {/foreach}],
                datasets: [{
                    data: [{foreach $incomeCategories as $c}{$c.total}
                        {if !$c@last},
                        {/if}
                    {/foreach}],
                    backgroundColor: chartColors.slice(0, {$incomeCategories|count})
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + ' {$currency}';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    {/if}

    // Procentowy udział wydatków - tylko jeśli są dane
    {if $categoryPercentages && count($categoryPercentages) > 0}
        new Chart(document.getElementById('categoryPercentChart'), {
            type: 'doughnut',
            data: {
                labels: [{foreach $categoryPercentages as $c}'{$c.name}'
                    {if !$c@last},
                    {/if}
                {/foreach}],
                datasets: [{
                    data: [{foreach $categoryPercentages as $c}{$c.percent}
                        {if !$c@last},
                        {/if}
                    {/foreach}],
                    backgroundColor: chartColors.slice(0, {$categoryPercentages|count})
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + '%';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    {/if}

    // Wydatki wg płatności - tylko jeśli są dane
    {if $paymentMethodBreakdown && count($paymentMethodBreakdown) > 0}
        new Chart(document.getElementById('paymentChart'), {
            type: 'pie',
            data: {
                labels: [{foreach $paymentMethodBreakdown as $p}'{$p.payment_method}'
                    {if !$p@last},
                    {/if}
                {/foreach}],
                datasets: [{
                    data: [{foreach $paymentMethodBreakdown as $p}{$p.total_spent}
                        {if !$p@last},
                        {/if}
                    {/foreach}],
                    backgroundColor: chartColors.slice(0, {$paymentMethodBreakdown|count})
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + ' {$currency}';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    {/if}

    // Porównanie regionalne - tylko jeśli są dane
    {if $regionalComparison && count($regionalComparison) > 0}
        new Chart(document.getElementById('regionalChart'), {
            type: 'bar',
            data: {
                labels: [{foreach $regionalComparison as $r}'{$r.region}'
                    {if !$r@last},
                    {/if}
                {/foreach}],
                datasets: [{
                    label: 'Wydatki ({$currency})',
                    data: [{foreach $regionalComparison as $r}{$r.total_spent}
                        {if !$r@last},
                        {/if}
                    {/foreach}],
                    backgroundColor: getBackgroundColors(colors.primary),
                    borderColor: colors.primary.replace(/, 0\.8\)/, ', 1)'),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kwota ({$currency})'
                        }
                    }
                }
            }
        });
    {/if}

    // Inicjalizacja wykresu Podkategorii - tylko jeśli są dane
    {if $subCategoryExpenses && count($subCategoryExpenses) > 0}
        let subCategoryChart;
        document.getElementById('subcategories-tab').addEventListener('shown.bs.tab', function() {
            if (!subCategoryChart) {
                const ctx = document.getElementById('subCategoryChart').getContext('2d');
                subCategoryChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            {foreach $subCategoryExpenses as $sc}'{$sc.sub_category|escape:'javascript'}'
                                {if !$sc@last},
                                {/if}
                            {/foreach}
                        ],
                        datasets: [{
                            label: 'Wydatki ({$currency})',
                            data: [
                                {foreach $subCategoryExpenses as $sc}{$sc.total}
                                    {if !$sc@last},
                                    {/if}
                                {/foreach}
                            ],
                            backgroundColor: getBackgroundColors(colors.danger),
                            borderColor: colors.danger.replace(/, 0\.8\)/, ', 1)'),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Kwota ({$currency})'
                                }
                            }
                        }
                    }
                });
            }
        });
    {/if}

    {if $subCategoryIncome && count($subCategoryIncome) > 0}
        // Wykres podkategorii przychodów
        let subCategoryIncomeChart;
        document.getElementById('subcategories-income-tab').addEventListener('shown.bs.tab', function() {
            if (!subCategoryIncomeChart) {
                const ctx = document.getElementById('subCategoryIncomeChart').getContext('2d');
                subCategoryIncomeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            {foreach $subCategoryIncome as $sc}'{$sc.sub_category|escape:'javascript'}'
                                {if !$sc@last},
                                {/if}
                            {/foreach}
                        ],
                        datasets: [{
                            label: 'Przychody ({$currency})',
                            data: [
                                {foreach $subCategoryIncome as $sc}{$sc.total}
                                    {if !$sc@last},
                                    {/if}
                                {/foreach}
                            ],
                            backgroundColor: getBackgroundColors(colors.success),
                            borderColor: colors.success.replace(/, 0\.8\)/, ', 1)'),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Kwota ({$currency})'
                                }
                            }
                        }
                    }
                });
            }
        });
    {/if}
    // Analiza trendu czasowego Z LINIĄ TRENDU
    {if $trend && count($trend) > 0 && $trendAnalysis}
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('trendAnalysisChart');
            if (!ctx) return;

            ctx.style.height = '200px';

            const dates = [{foreach $trend as $t}'{$t.date}'
                {if !$t@last},
                {/if}
            {/foreach}];
            const actualValues = [{foreach $trend as $t}{$t.total}
                {if !$t@last},
                {/if}
            {/foreach}];

            // Oblicz linię trendu
            const trendLine = [];
            const n = actualValues.length;
            {if $trendAnalysis.slope && $trendAnalysis.intercept}
                for (let i = 0; i < n; i++) {
                    trendLine.push({$trendAnalysis.intercept} + {$trendAnalysis.slope} * (i + 1));
                }
            {else}
                // Fallback - prosta linia trendu
                const firstValue = actualValues[0];
                const lastValue = actualValues[n - 1];
                const slope = (lastValue - firstValue) / (n - 1);
                for (let i = 0; i < n; i++) {
                    trendLine.push(firstValue + slope * i);
                }
            {/if}

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                            label: 'Rzeczywiste wydatki',
                            data: actualValues,
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Linia trendu',
                            data: trendLine,
                            borderColor: '#ffc107',
                            backgroundColor: 'transparent',
                            borderWidth: 3,
                            borderDash: [5, 5],
                            pointRadius: 0,
                            tension: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' {$currency}';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        });
    {else}
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('trendAnalysisChart');
            if (container) {
                container.innerHTML =
                    '<div class="text-center py-3 text-muted"><small>Brak danych do analizy trendu</small></div>';
            }
        });
    {/if}
</script>

{include file="footer.tpl"}