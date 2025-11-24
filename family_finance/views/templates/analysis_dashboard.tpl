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

{* Ustal precyzję globalnie *}
{assign var=precision value=2}
{if in_array($currency, ['BTC','ETH','BNB','XRP','DOGE','USDT','SOL','ADA','TRX'])}
    {assign var=precision value=8}
{/if}

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
        <button class="nav-link" id="profit-loss-tab" data-bs-toggle="tab" data-bs-target="#profit-loss" type="button"
            role="tab"><i class="bi bi-arrow-left-right me-2"></i>Bilans</button>
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
                                <span class="float-end">{$summary.income|number_format:$precision:",":" "}
                                    {$currency}</span>
                            </p>
                            <p class="fs-5 mb-2">
                                <span class="fw-bold text-danger"><i
                                        class="bi bi-arrow-down-left-circle-fill me-2"></i>Wydatki:</span>
                                <span class="float-end">{$summary.expense|number_format:$precision:",":" "}
                                    {$currency}</span>
                            </p>
                            <p class="fs-4 fw-bold mt-4 pt-2 border-top 
       {if ($summary.income - $summary.expense) >= 0}text-success{else}text-danger{/if}">
                                <i class="bi bi-balance-fill me-2"></i>Bilans:
                                <span
                                    class="float-end">{($summary.income - $summary.expense)|number_format:$precision:",":" "}
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
                                            <div class="fw-bold text-danger fs-5">
                                                {$e.amount|number_format:$precision:",":" "} {$currency}
                                            </div>
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
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark border-bottom-0 pb-2">
                        <h5 class="card-title text-primary mb-0">
                            <i class="bi bi-bar-chart-steps me-2"></i>Trend przychodów i wydatków
                            {if $trend.0.scale_unit}(w {$trend.0.scale_unit} {$currency}){else}({$currency}){/if}
                        </h5>
                    </div>
                    <div class="card-body pt-0 mt-5">
                        {if ($trend && count($trend) > 0) || ($trendIncome && count($trendIncome) > 0)}
                            <div class="chart-container" style="position: relative; height: 400px; width: 100%">
                                <canvas id="combinedTrendChart"></canvas>
                            </div>
                            {if $trend.0.scale_unit}
                                <div class="alert alert-info mt-3 mb-0 py-2">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Wartości zostały przeskalowane dla lepszej czytelności.
                                    </small>
                                </div>
                            {/if}
                        {else}
                            <div class="text-center py-4">
                                <i class="bi bi-graph-up display-4 text-muted opacity-50"></i>
                                <p class="text-muted mt-2">Brak danych o trendach finansowych</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="profit-loss" role="tabpanel">
        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark border-bottom-0 pb-2">
                        <h5 class="card-title text-primary mb-0">
                            <i class="bi bi-arrow-left-right me-2"></i>Bilans finansowy - Różnica między przychodami a
                            wydatkami
                            {if $profitLossTrend.0.scale_unit}(w {$profitLossTrend.0.scale_unit}
                            {$currency}){else}({$currency})
                            {/if}
                        </h5>
                    </div>
                    <div class="card-body pt-0 mt-5">
                        {if $profitLossTrend && count($profitLossTrend) > 0}
                            <div class="chart-container" style="position: relative; height: 400px; width: 100%">
                                <canvas id="profitLossChart"></canvas>
                            </div>

                            <!-- Statystyki bilansu -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card bg-dark">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-success">
                                                <i class="bi bi-arrow-up-circle me-1"></i>Dni z zyskiem
                                            </h6>
                                            <h4 class="text-success" id="profitDays">0</h4>
                                            <small class="text-muted">Dni z dodatnim bilansem</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-danger">
                                                <i class="bi bi-arrow-down-circle me-1"></i>Dni ze stratą
                                            </h6>
                                            <h4 class="text-danger" id="lossDays">0</h4>
                                            <small class="text-muted">Dni z ujemnym bilansem</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-dark">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-info">
                                                <i class="bi bi-graph-up me-1"></i>Średni bilans
                                            </h6>
                                            <h4 class="text-info" id="averageBalance">0</h4>
                                            <small class="text-muted">Średnia dzienna różnica</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {if $profitLossTrend.0.scale_unit}
                                <div class="alert alert-info mt-3 mb-0 py-2">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Wartości zostały przeskalowane dla lepszej czytelności.
                                    </small>
                                </div>
                            {/if}
                        {else}
                            <div class="text-center py-4">
                                <i class="bi bi-calculator display-4 text-muted opacity-50"></i>
                                <p class="text-muted mt-2">Brak danych do analizy bilansu</p>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ukryty div z danymi w formacie JSON -->
    <div id="profitLossData" data-profitloss='{$profitLossDataJson|escape:'html'}' style="display: none;"></div>

    <div class="tab-pane fade" id="categories" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-danger text-center"><i
                                class="bi bi-pie-chart-fill me-2"></i>Struktura wydatków
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
                        <h5 class="card-title text-success text-center "><i
                                class="bi bi-pie-chart-fill me-2"></i>Struktura
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
                        <h5 class="card-title text-info text-center"><i class="bi bi-percent me-2"></i>Procentowy udział
                            wydatków
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
                        <h5 class="card-title text-primary text-center"><i class="bi bi-wallet-fill me-2"></i>Wydatki wg
                            rodzaju
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
                                                <td class="text-end fw-bold">
                                                    {$member.total_spent|number_format:$precision:",":" "}
                                                    {$currency}</td>
                                                <td class="text-end">{$member.transactions}</td>
                                                <td class="text-end">{$member.avg_spent|number_format:$precision:",":" "}
                                                    {$currency}
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
                                            <td class="text-end">
                                                <strong>{$familyTotalSpending|number_format:$precision:",":" "}
                                                    {$currency}</strong>
                                            </td>
                                            <td class="text-end"><strong>{$familyTotalTransactions}</strong></td>
                                            <td class="text-end">
                                                <strong>{$familyAverageSpending|number_format:$precision:",":" "}
                                                    {$currency}</strong>
                                            </td>
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

    {if $isPremium}
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
    {else}
        <div class="tab-pane fade" id="regional" role="tabpanel">
            <div class="text-center py-5">
                <i class="bi bi-lock-fill display-1 text-muted"></i>
                <p class="fs-5 text-muted mt-3">Sekcja dostępna tylko dla kont premium</p>
            </div>
        </div>
    {/if}


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
                                            <td class="text-end">{$descriptiveStats.mean|number_format:$precision:",":" "}
                                                {$currency}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mediana</strong></td>
                                            <td class="text-end">{$descriptiveStats.median|number_format:$precision:",":" "}
                                                {$currency}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Odchylenie standardowe</strong></td>
                                            <td class="text-end">
                                                {$descriptiveStats.std_dev|number_format:$precision:",":" "}
                                                {$currency}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Wariancja</strong></td>
                                            <td class="text-end">
                                                {$descriptiveStats.variance|number_format:$precision:",":" "}</td>
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

                                        <!-- Przedziały ufności -->
                                        <tr class="table-primary">
                                            <td colspan="2" class="fw-bold text-center">PRZEDZIAŁY UFNOŚCI DLA ŚREDNIEJ</td>
                                        </tr>
                                        <tr>
                                            <td><strong>95% przedział ufności</strong></td>
                                            <td class="text-end">
                                                <small>
                                                    {$descriptiveStats.confidence_interval_95.lower|number_format:$precision:",":" "}
                                                    -
                                                    {$descriptiveStats.confidence_interval_95.upper|number_format:$precision:",":" "}
                                                    {$currency}
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Margines błędu (95%)</strong></td>
                                            <td class="text-end">
                                                <small>±{$descriptiveStats.confidence_interval_95.margin_of_error|number_format:$precision:",":" "}
                                                    {$currency}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>99% przedział ufności</strong></td>
                                            <td class="text-end">
                                                <small>
                                                    {$descriptiveStats.confidence_interval_99.lower|number_format:$precision:",":" "}
                                                    -
                                                    {$descriptiveStats.confidence_interval_99.upper|number_format:$precision:",":" "}
                                                    {$currency}
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Liczba obserwacji</strong></td>
                                            <td class="text-end">{$descriptiveStats.count}</td>
                                        </tr>

                                        <!-- Interpretacja -->
                                        <tr class="table-info">
                                            <td colspan="2" class="small">
                                                <i class="bi bi-info-circle me-1"></i>
                                                <strong>Interpretacja:</strong> Z 95% pewnością średni wydatek mieści się
                                                między
                                                <strong>{$descriptiveStats.confidence_interval_95.lower|number_format:$precision:",":" "}</strong>
                                                a
                                                <strong>{$descriptiveStats.confidence_interval_95.upper|number_format:$precision:",":" "}
                                                    {$currency}</strong>
                                            </td>
                                        </tr>
                                    {else}
                                        <tr>
                                            <td colspan="2">
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle"></i>
                                                    Zbyt mało danych w wybranej walucie do obliczenia statystyk
                                                </div>
                                            </td>
                                        </tr>
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

                                    {* --- Za mało kategorii --- *}
                                    {if ($concentrationStats.categories_count|default:0) < 2}
                                        <tr>
                                            <td colspan="2">
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle"></i>
                                                    Wymagane przynajmniej 2 kategorie do obliczenia miar koncentracji
                                                </div>
                                            </td>
                                        </tr>

                                        {* --- Wystarczająco kategorii — pokazujemy statystyki --- *}
                                    {else}

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

                                    {/if}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analiza trendu -->
            {if $isPremium}
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title text-warning">
                                <i class="bi bi-trending-up me-2"></i>Analiza trendu czasowego
                            </h5>
                            <div class="chart-container w-100" style="position: relative; height: 250px;">
                                <canvas id="trendAnalysisChart"></canvas>
                            </div>
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
            {else}
                <div class="col-12">
                    <div class="card shadow-lg text-center py-5">
                        <i class="bi bi-lock-fill display-1 text-muted"></i>
                        <p class="fs-5 text-muted mt-3">Analiza trendu dostępna tylko dla kont premium</p>
                    </div>
                </div>
            {/if}

        </div>

        <!-- Proste objaśnienie dla laika -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0" style="color: #0d6efd;">
                            <i class="bi bi-question-circle me-2"></i>Co oznaczają te liczby? - Proste wyjaśnienie
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
    function getProfitLossData() {
        const profitLossDataElement = document.getElementById('profitLossData');
        if (profitLossDataElement) {
            const profitLossDataJson = profitLossDataElement.getAttribute('data-profitloss');
            try {
                const data = JSON.parse(profitLossDataJson);
                return data.map(item => ({
                    date: item.date,
                    income: parseFloat(item.income) || 0,
                    expense: parseFloat(item.expense) || 0,
                    profit_loss: parseFloat(item.profit_loss) || 0,
                    scaled_profit_loss: parseFloat(item.scaled_profit_loss) || 0,
                    scale_factor: item.scale_factor || 1,
                    scale_unit: item.scale_unit || ''
                }));

            } catch (e) {
                console.error('Błąd parsowania danych profit/loss:', e);
                return [];
            }
        }
        return [];
    }

    function formatCurrencyForChart(value, scaleFactor = 1) {
        if (scaleFactor > 1) {
            const precision = scaleFactor >= 1000 ? 2 : 4;
            return value.toFixed(precision) + ' ' + currentCurrency;
        } else {
            return formatCurrency(value);
        }
    }

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

    // Przekazanie precyzji z PHP do JavaScript
    const currencyPrecision = {$precision};
    const currentCurrency = '{$currency}';

    // Funkcja do formatowania kwot z odpowiednią precyzją
    function formatCurrency(value) {
        return value.toFixed(currencyPrecision) + ' ' + currentCurrency;
    }

    // Połączony trend przychodów i wydatków - tylko jeśli są dane
    {if ($trend && count($trend) > 0) || ($trendIncome && count($trendIncome) > 0)}
        // Funkcja do formatowania z uwzględnieniem skalowania
        function formatCurrencyForChart(value, scaleFactor = 1) {
            if (scaleFactor > 1) {
                // Dla przeskalowanych wartości pokazujemy mniej miejsc po przecinku
                const precision = scaleFactor >= 1000 ? 2 : 4;
                return value.toFixed(precision) + ' ' + currentCurrency;
            } else {
                return formatCurrency(value);
            }
        }

        // Przygotuj dane z uwzględnieniem skalowania
        const trendScaleFactor = {$trend.0.scale_factor|default:1};
        const incomeScaleFactor = {$trendIncome.0.scale_factor|default:1};

        new Chart(document.getElementById('combinedTrendChart'), {
            type: 'line',
            data: {
                labels: [
                    {foreach $trend as $t}'{$t.date}'
                        {if !$t@last},
                        {/if}
                    {/foreach}
                ],
                datasets: [
                    {if $trendIncome && count($trendIncome) > 0}
                        {
                            label: 'Przychody' + (incomeScaleFactor > 1 ? ' (przeskalowane)' : ''),
                            data: [
                                {foreach $trendIncome as $t}
                                    {if $t.scaled_total}{$t.scaled_total}{else}{$t.total}{/if}
                                    {if !$t@last},
                                    {/if}
                                {/foreach}
                            ],
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#28a745',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 1,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        },
                    {/if}
                    {if $trend && count($trend) > 0}
                        {
                            label: 'Wydatki' + (trendScaleFactor > 1 ? ' (przeskalowane)' : ''),
                            data: [
                                {foreach $trend as $t}
                                    {if $t.scaled_total}{$t.scaled_total}{else}{$t.total}{/if}
                                    {if !$t@last},
                                    {/if}
                                {/foreach}
                            ],
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#dc3545',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 1,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }
                    {/if}
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 10,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 8,
                        cornerRadius: 6,
                        titleFont: {
                            size: 11
                        },
                        bodyFont: {
                            size: 11
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }

                                // Określ współczynnik skalowania dla danego datasetu
                                const scaleFactor = context.datasetIndex === 0 ? incomeScaleFactor :
                                    trendScaleFactor;

                                // Jeśli wartości są przeskalowane, pokazujemy oryginalną wartość w tooltipie
                                if (scaleFactor > 1) {
                                    const originalValue = context.parsed.y / scaleFactor;
                                    label += formatCurrency(originalValue) + ' (przeskalowane: ' +
                                        formatCurrencyForChart(context.parsed.y, scaleFactor) + ')';
                                } else {
                                    label += formatCurrency(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.03)'
                        },
                        title: {
                            display: true,
                            text: {if $trend.0.scale_unit}'Kwota (w {$trend.0.scale_unit} {$currency})'{else}'Kwota ({$currency})'{/if},
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            font: {
                                size: 13
                            },
                            callback: function(value) {
                                const scaleFactor = Math.max(trendScaleFactor, incomeScaleFactor);
                                return formatCurrencyForChart(value, scaleFactor);
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.03)'
                        },
                        title: {
                            display: true,
                            text: 'Data',
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            font: {
                                size: 13
                            },
                            maxTicksLimit: 8
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                },
                elements: {
                    line: {
                        tension: 0.4
                    }
                }
            }
        });
    {/if}

    // Wykres bilansu (różnica przychody-wydatki)
    // Wykres bilansu (różnica przychody-wydatki)
    {if $profitLossTrend && count($profitLossTrend) > 0}
        let profitLossChartInstance = null;

        // Inicjalizacja wykresu po załadowaniu zakładki
        document.getElementById('profit-loss-tab').addEventListener('shown.bs.tab', function() {
            if (!profitLossChartInstance) {
                createProfitLossChart();
            }
        });

        function createProfitLossChart() {
            const ctx = document.getElementById('profitLossChart').getContext('2d');
            const scaleFactor = {$profitLossTrend.0.scale_factor|default:1};

            // Pobierz dane z ukrytego diva (już przekonwertowane na numbers)
            const profitLossData = getProfitLossData();

            console.log('Dane profit/loss po konwersji:', profitLossData); // DEBUG

            // Zabezpieczenie przed pustymi danymi
            if (!profitLossData || profitLossData.length === 0) {
                console.error('Brak danych do utworzenia wykresu bilansu');
                const canvas = document.getElementById('profitLossChart');
                if (canvas) {
                    canvas.innerHTML = '<div class="text-center py-4 text-muted">Brak danych do wyświetlenia</div>';
                }
                return;
            }

            const dates = profitLossData.map(item => item.date);
            const profitLossValues = profitLossData.map(item =>
                scaleFactor > 1 ? item.scaled_profit_loss : item.profit_loss
            );

            // Oblicz statystyki - teraz dane są już liczbami
            let profitDays = 0;
            let lossDays = 0;
            let totalBalance = 0;

            profitLossData.forEach(item => {
                const profitLoss = item.profit_loss;
                if (profitLoss > 0) profitDays++;
                if (profitLoss < 0) lossDays++;
                totalBalance += profitLoss;
            });

            const averageBalance = profitLossData.length > 0 ? totalBalance / profitLossData.length : 0;

            console.log('Statystyki - profitDays:', profitDays, 'lossDays:', lossDays, 'averageBalance:',
            averageBalance); // DEBUG

            // Aktualizuj statystyki w UI
            document.getElementById('profitDays').textContent = profitDays;
            document.getElementById('lossDays').textContent = lossDays;
            document.getElementById('averageBalance').textContent = formatCurrency(averageBalance);

            // Przygotuj kolory dla punktów
            const backgroundColors = profitLossData.map(item =>
                item.profit_loss >= 0 ? 'rgba(40, 167, 69, 0.3)' : 'rgba(220, 53, 69, 0.3)'
            );

            const borderColors = profitLossData.map(item =>
                item.profit_loss >= 0 ? 'rgba(40, 167, 69, 0.8)' : 'rgba(220, 53, 69, 0.8)'
            );

            profitLossChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: scaleFactor > 1 ? 'Bilans (przeskalowany)' : 'Bilans finansowy',
                        data: profitLossValues,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 10,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: true,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 8,
                            cornerRadius: 6,
                            titleFont: {
                                size: 11
                            },
                            bodyFont: {
                                size: 11
                            },
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }

                                    // Pobierz oryginalne dane dla tego punktu
                                    const dataIndex = context.dataIndex;
                                    const originalValue = profitLossData[dataIndex].profit_loss;

                                    if (scaleFactor > 1) {
                                        label += formatCurrency(originalValue) + ' (przeskalowane: ' +
                                            formatCurrencyForChart(context.parsed.y, scaleFactor) + ')';
                                    } else {
                                        label += formatCurrency(originalValue);
                                    }

                                    return label;
                                },
                                afterLabel: function(context) {
                                    const dataIndex = context.dataIndex;
                                    const originalValue = profitLossData[dataIndex].profit_loss;
                                    const income = profitLossData[dataIndex].income;
                                    const expense = profitLossData[dataIndex].expense;

                                    let additionalInfo = [];
                                    additionalInfo.push('Przychody: ' + formatCurrency(income));
                                    additionalInfo.push('Wydatki: ' + formatCurrency(expense));

                                    if (originalValue > 0) {
                                        additionalInfo.push('✅ Dodatni bilans');
                                    } else if (originalValue < 0) {
                                        additionalInfo.push('❌ Ujemny bilans');
                                    } else {
                                        additionalInfo.push('⚖️ Bilans zerowy');
                                    }

                                    return additionalInfo;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.03)'
                            },
                            title: {
                                display: true,
                                text: scaleFactor > 1 ?
                                    'Kwota (w {$profitLossTrend.0.scale_unit} {$currency})' : 
                                    'Kwota ({$currency})',
                                    font : {
                                        size: 14
                                    }
                            },
                            ticks: {
                                font: {
                                    size: 13
                                },
                                callback: function(value) {
                                    return formatCurrencyForChart(value, scaleFactor);
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.03)'
                            },
                            title: {
                                display: true,
                                text: 'Data',
                                font: {
                                    size: 14
                                }
                            },
                            ticks: {
                                font: {
                                    size: 13
                                },
                                maxTicksLimit: 8
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'nearest'
                    },
                    elements: {
                        bar: {
                            borderWidth: 1
                        }
                    }
                }
            });
        }

        // Inicjalizacja wykresu jeśli zakładka jest już aktywna
        if (document.getElementById('profit-loss').classList.contains('active')) {
            createProfitLossChart();
        }
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
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += formatCurrency(context.raw);
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
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += formatCurrency(context.raw);
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
                    legend: { position: 'bottom' },
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
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += formatCurrency(context.raw);
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
                        },
                        ticks: {
                            callback: function(value) {
                                return formatCurrency(value);
                            }
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
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatCurrency(context
                                            .parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Kwota ({$currency})'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatCurrency(value);
                                    }
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
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + formatCurrency(context
                                            .parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Kwota ({$currency})'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatCurrency(value);
                                    }
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
                const slope = (n > 1) ? (lastValue - firstValue) / (n - 1) : 0;
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
                            fill: true,
                            pointBackgroundColor: '#dc3545',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 1,
                            pointRadius: 3,
                            pointHoverRadius: 5
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
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
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
                                    return context.dataset.label + ': ' + formatCurrency(context.parsed
                                        .y);
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
                                },
                                callback: function(value) {
                                    return formatCurrency(value);
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