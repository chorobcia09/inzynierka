{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Analiza finansowa ({$period})</h2>

<a href="index.php?action=analysisPdf&period={$period}" class="btn btn-danger mb-3">
    <i class="bi bi-filetype-pdf"></i> Pobierz raport PDF
</a>

<!-- Zakładki -->
<ul class="nav nav-tabs mb-4" id="analysisTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button"
            role="tab">Podsumowanie</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="trend-tab" data-bs-toggle="tab" data-bs-target="#trend" type="button"
            role="tab">Trendy</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button"
            role="tab">Kategorie</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button"
            role="tab">Płatności</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="regional-tab" data-bs-toggle="tab" data-bs-target="#regional" type="button"
            role="tab">Regiony</button>
    </li>
</ul>

<div class="tab-content" id="analysisTabsContent">

    <!-- Podsumowanie -->
    <div class="tab-pane fade show active" id="summary" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Podsumowanie</h5>
                    <p><strong>Przychody:</strong> {$summary.income|number_format:2} zł</p>
                    <p><strong>Wydatki:</strong> {$summary.expense|number_format:2} zł</p>
                    <p><strong>Bilans:</strong> {($summary.income - $summary.expense)|number_format:2} zł</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Największe wydatki</h5>
                    <ul class="list-group">
                        {foreach $topExpenses as $e}
                            <li class="list-group-item bg-dark text-light">
                                {$e.description} — {$e.amount} zł
                                <small class="text-secondary">({$e.transaction_date})</small>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend -->
    <div class="tab-pane fade" id="trend" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Trend wydatków</h5>
                    <canvas id="trendExpensesChart" height="120"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Trend przychodów</h5>
                    <canvas id="trendIncomeChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategorie -->
    <div class="tab-pane fade" id="categories" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Struktura wydatków</h5>
                    <canvas id="categoryExpensesChart"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Struktura przychodów</h5>
                    <canvas id="categoryIncomeChart"></canvas>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Procentowy udział wydatków wg kategorii</h5>
                    <canvas id="categoryPercentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Płatności -->
    <div class="tab-pane fade" id="payments" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Wydatki wg rodzaju płatności</h5>
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Regiony -->
    <div class="tab-pane fade" id="regional" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Porównanie regionalne</h5>
                    <canvas id="regionalChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Trend wydatków
    new Chart(document.getElementById('trendExpensesChart'), {
        type: 'line',
        data: {
            labels: [{foreach $trend as $t}'{$t.date}',{/foreach}],
            datasets: [{
                label: 'Wydatki',
                data: [{foreach $trend as $t}{$t.total},{/foreach}],
                borderColor: 'rgba(255,99,132,0.8)',
                backgroundColor: 'rgba(255,99,132,0.2)',
                fill: true
            }]
        }
    });

    // Trend przychodów
    new Chart(document.getElementById('trendIncomeChart'), {
        type: 'line',
        data: {
            labels: [{foreach $trendIncome as $t}'{$t.date}',{/foreach}],
            datasets: [{
                label: 'Przychody',
                data: [{foreach $trendIncome as $t}{$t.total},{/foreach}],
                borderColor: 'rgba(75,192,192,0.8)',
                backgroundColor: 'rgba(75,192,192,0.2)',
                fill: true
            }]
        }
    });

    // Kategorie wydatków
    new Chart(document.getElementById('categoryExpensesChart'), {
        type: 'pie',
        data: {
            labels: [{foreach $categories as $c}'{$c.name}',{/foreach}],
            datasets: [{
                data: [{foreach $categories as $c}{$c.total},{/foreach}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ]
            }]
        }
    });

    // Kategorie przychodów
    new Chart(document.getElementById('categoryIncomeChart'), {
        type: 'pie',
        data: {
            labels: [{foreach $incomeCategories as $c}'{$c.name}',{/foreach}],
            datasets: [{
                data: [{foreach $incomeCategories as $c}{$c.total},{/foreach}],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(54, 162, 235, 0.6)'
                ]
            }]
        }
    });

    // Procentowy udział wydatków
    new Chart(document.getElementById('categoryPercentChart'), {
        type: 'doughnut',
        data: {
            labels: [
                {foreach $categoryPercentages as $c}'{$c.name}'
                    {if !$c@last},
                    {/if}
                {/foreach}
            ],
            datasets: [{
                data: [
                    {foreach $categoryPercentages as $c}{$c.percent}
                        {if !$c@last},
                        {/if}
                    {/foreach}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ]
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
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
            labels: [{foreach $paymentMethodBreakdown as $p}'{$p.payment_method}',{/foreach}],
            datasets: [{
                data: [{foreach $paymentMethodBreakdown as $p}{$p.total_spent},{/foreach}],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ]
            }]
        }
    });

    // Porównanie regionalne
    new Chart(document.getElementById('regionalChart'), {
        type: 'bar',
        data: {
            labels: [{foreach $regionalComparison as $r}'{$r.region}',{/foreach}],
            datasets: [{
                label: 'Wydatki',
                data: [{foreach $regionalComparison as $r}{$r.total_spent},{/foreach}],
                backgroundColor: 'rgba(54,162,235,0.5)'
            }]
        }
    });
</script>

{include file="footer.tpl"}