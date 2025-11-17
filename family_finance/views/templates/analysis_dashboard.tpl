{include file="header.tpl"}

<h2 class="mb-4 text-primary fw-bold"><i class="bi bi-bar-chart"></i> Analiza Finansowa</h2>

<form method="get" action="index.php" class="mb-5 p-3 border rounded-3 bg-dark shadow-sm row g-3 align-items-end">
    <input type="hidden" name="action" value="analysisDashboard">

    <div class="col-md-4 col-lg-3">
        <label for="date_from" class="form-label fw-semibold text-muted">Data początkowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
            <input type="date" id="date_from" name="date_from" class="form-control" value="{$date_from}">
        </div>
    </div>

    <div class="col-md-4 col-lg-3">
        <label for="date_to" class="form-label fw-semibold text-muted">Data końcowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
            <input type="date" id="date_to" name="date_to" class="form-control" value="{$date_to}">
        </div>
    </div>

    <div class="col-md-4 col-lg-6 d-flex justify-content-start">
        <button type="submit" class="btn btn-primary me-2"><i class="bi bi-funnel-fill me-1"></i> Filtruj</button>
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
            type="button" role="tab"><i class="bi bi-tag me-2"></i>Podkategorie</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button"
            role="tab"><i class="bi bi-credit-card-2-front-fill me-2"></i>Płatności</button>
    </li>
    {if isset($session.family_id)}
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="regional-tab" data-bs-toggle="tab" data-bs-target="#regional" type="button"
                role="tab"><i class="bi bi-geo-alt-fill me-2"></i>Regiony</button>
        </li>
    {/if}
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
                        <p class="fs-5 mb-2">
                            <span class="fw-bold text-success"><i
                                    class="bi bi-arrow-up-right-circle-fill me-2"></i>Przychody:</span>
                            <span class="float-end">{$summary.income|number_format:2:",":" "} zł</span>
                        </p>
                        <p class="fs-5 mb-2">
                            <span class="fw-bold text-danger"><i
                                    class="bi bi-arrow-down-left-circle-fill me-2"></i>Wydatki:</span>
                            <span class="float-end">{$summary.expense|number_format:2:",":" "} zł</span>
                        </p>
                        <p class="fs-4 fw-bold mt-4 pt-2 border-top 
                           {if ($summary.income - $summary.expense) >= 0}text-success{else}text-danger{/if}">
                            <i class="bi bi-balance-fill me-2"></i>Bilans:
                            <span class="float-end">{($summary.income - $summary.expense)|number_format:2:",":" "}
                                zł</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-8">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h4 class="card-title text-danger"><i class="bi bi-bag-x-fill me-2"></i>Największe Wydatki</h4>
                        <hr>
                        <div class="list-group list-group-flush">
                            {if $topExpenses}
                                {foreach $topExpenses as $e}
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="text-truncate me-3">
                                            <span class="fw-semibold">{$e.description}</span>
                                            <small class="text-muted d-block"><i
                                                    class="bi bi-calendar me-1"></i>{$e.transaction_date}</small>
                                        </div>
                                        <span class="badge bg-danger rounded-pill fs-6">{$e.amount|number_format:2:",":" "}
                                            zł</span>
                                    </div>
                                {/foreach}
                            {else}
                                <p class="text-muted fst-italic">Brak danych o wydatkach w wybranym okresie.</p>
                            {/if}
                        </div>
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
                        <h5 class="card-title text-danger"><i class="bi bi-graph-down me-2"></i>Trend wydatków</h5>
                        <canvas id="trendExpensesChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-graph-up me-2"></i>Trend przychodów</h5>
                        <canvas id="trendIncomeChart" height="150"></canvas>
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
                            (Kwoty)</h5>
                        <canvas id="categoryExpensesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-pie-chart-fill me-2"></i>Struktura
                            przychodów (Kwoty)</h5>
                        <canvas id="categoryIncomeChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-info"><i class="bi bi-percent me-2"></i>Procentowy udział wydatków
                        </h5>
                        <canvas id="categoryPercentChart"></canvas>
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
                            podkategorii</h5>
                        <canvas id="subCategoryChart"></canvas>
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
                            płatności</h5>
                        <canvas id="paymentChart"></canvas>
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
                            wydatków</h5>
                        <canvas id="regionalChart" height="100"></canvas>
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
        /* Ddla efektu uniesienia */
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

    /* Dopasowanie tła kart do jasnego motywu, użycie 'shadow-lg' dla głębi */
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ustalenie stałej, nowoczesnej palety kolorów
    const colors = {
        primary: 'rgba(13, 110, 253, 0.8)', // Niebieski
        success: 'rgba(25, 135, 84, 0.8)', // Zielony
        danger: 'rgba(220, 53, 69, 0.8)', // Czerwony
        warning: 'rgba(255, 193, 7, 0.8)', // Żółty
        info: 'rgba(13, 202, 240, 0.8)', // Turkus
        secondary: 'rgba(108, 117, 125, 0.8)', // Szary
        custom1: 'rgba(153, 102, 255, 0.8)', // Fiolet
        custom2: 'rgba(255, 159, 64, 0.8)' // Pomarańcz
    };

    const chartColors = [
        colors.danger, colors.primary, colors.success, colors.warning, colors.custom1, colors.info, colors.custom2,
        colors.secondary
    ];

    // Funkcja do generowania tła z przeźroczystością
    function getBackgroundColors(baseColor) {
        return baseColor.replace(/, 0\.8\)/, ', 0.2)');
    }

    // Trend wydatków
    new Chart(document.getElementById('trendExpensesChart'), {
        type: 'line',
        data: {
            labels: [{foreach $trend as $t}'{$t.date}'
                {if !$t@last},
                {/if}
            {/foreach}],
            datasets: [{
                label: 'Wydatki (zł)',
                data: [{foreach $trend as $t}{$t.total}
                    {if !$t@last},
                    {/if}
                {/foreach}],
                borderColor: colors.danger.replace(/, 0\.8\)/, ', 1)'),
                backgroundColor: getBackgroundColors(colors.danger),
                fill: true,
                tension: 0.3 // Nowoczesny, łagodny trend
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Trend przychodów
    new Chart(document.getElementById('trendIncomeChart'), {
        type: 'line',
        data: {
            labels: [{foreach $trendIncome as $t}'{$t.date}'
                {if !$t@last},
                {/if}
            {/foreach}],
            datasets: [{
                label: 'Przychody (zł)',
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
                y: { beginAtZero: true }
            }
        }
    });

    // Kategorie wydatków (Kwoty)
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
                legend: { position: 'right' }
            }
        }
    });

    // Kategorie przychodów (Kwoty)
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
                legend: { position: 'right' }
            }
        }
    });

    // Procentowy udział wydatków
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
                            // Dodanie procentu do etykiety
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

    // Wydatki wg płatności
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
                legend: { position: 'right' }
            }
        }
    });

    // Porównanie regionalne
    new Chart(document.getElementById('regionalChart'), {
        type: 'bar',
        data: {
            labels: [{foreach $regionalComparison as $r}'{$r.region}'
                {if !$r@last},
                {/if}
            {/foreach}],
            datasets: [{
                label: 'Wydatki (zł)',
                data: [{foreach $regionalComparison as $r}{$r.total_spent}
                    {if !$r@last},
                    {/if}
                {/foreach}],
                backgroundColor: getBackgroundColors(colors
                    .primary), // Użycie koloru primary z przeźroczystością
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
                y: { beginAtZero: true }
            }
        }
    });


    // Inicjalizacja wykresu Podkategorii tylko po przejściu na zakładkę (optymalizacja)
    let subCategoryChart;
    document.getElementById('subcategories-tab').addEventListener('shown.bs.tab', function() {
        if (!subCategoryChart) {
            const ctx = document.getElementById('subCategoryChart').getContext('2d');
            subCategoryChart = new Chart(ctx, {
                type: 'bar', // Zmienione na 'bar' dla lepszej czytelności przy dużej liczbie podkategorii
                data: {
                    labels: [
                        {foreach $subCategoryExpenses as $sc}'{$sc.sub_category|escape:'javascript'}'
                            {if !$sc@last},
                            {/if}
                        {/foreach}
                    ],
                    datasets: [{
                        label: 'Wydatki (zł)',
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
                        y: { beginAtZero: true },
                        x: { beginAtZero: true }
                    }
                }
            });
        }
    });
</script>

{include file="footer.tpl"}