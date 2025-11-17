<?php
/* Smarty version 5.6.0, created on 2025-11-17 16:46:41
  from 'file:analysis_dashboard.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_691b43612da898_78052525',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff3fc31a2834008499907241f37b80e084f0c120' => 
    array (
      0 => 'analysis_dashboard.tpl',
      1 => 1763394396,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_691b43612da898_78052525 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Analiza finansowa (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
)</h2>

<a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-danger mb-3">
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
                    <p><strong>Przychody:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('summary')['income'],2)), ENT_QUOTES, 'UTF-8');?>
 zł</p>
                    <p><strong>Wydatki:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('summary')['expense'],2)), ENT_QUOTES, 'UTF-8');?>
 zł</p>
                    <p><strong>Bilans:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')(($_smarty_tpl->getValue('summary')['income']-$_smarty_tpl->getValue('summary')['expense']),2)), ENT_QUOTES, 'UTF-8');?>
 zł</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark text-light p-3 shadow">
                    <h5>Największe wydatki</h5>
                    <ul class="list-group">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('topExpenses'), 'e');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('e')->value) {
$foreach0DoElse = false;
?>
                            <li class="list-group-item bg-dark text-light">
                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['description']), ENT_QUOTES, 'UTF-8');?>
 — <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['amount']), ENT_QUOTES, 'UTF-8');?>
 zł
                                <small class="text-secondary">(<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['transaction_date']), ENT_QUOTES, 'UTF-8');?>
)</small>
                            </li>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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

<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/chart.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    // Trend wydatków
    new Chart(document.getElementById('trendExpensesChart'), {
        type: 'line',
        data: {
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach1DoElse = false;
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['date']), ENT_QUOTES, 'UTF-8');?>
',<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                label: 'Wydatki',
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach2DoElse = false;
echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['total']), ENT_QUOTES, 'UTF-8');?>
,<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trendIncome'), 't');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach3DoElse = false;
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['date']), ENT_QUOTES, 'UTF-8');?>
',<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                label: 'Przychody',
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trendIncome'), 't');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach4DoElse = false;
echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['total']), ENT_QUOTES, 'UTF-8');?>
,<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach5DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach5Backup = clone $_smarty_tpl->getVariable('c');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['name']), ENT_QUOTES, 'UTF-8');?>
',<?php
$_smarty_tpl->setVariable('c', $foreach5Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach6DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach6Backup = clone $_smarty_tpl->getVariable('c');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['total']), ENT_QUOTES, 'UTF-8');?>
,<?php
$_smarty_tpl->setVariable('c', $foreach6Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('incomeCategories'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach7DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach7Backup = clone $_smarty_tpl->getVariable('c');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['name']), ENT_QUOTES, 'UTF-8');?>
',<?php
$_smarty_tpl->setVariable('c', $foreach7Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('incomeCategories'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach8DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach8DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach8Backup = clone $_smarty_tpl->getVariable('c');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['total']), ENT_QUOTES, 'UTF-8');?>
,<?php
$_smarty_tpl->setVariable('c', $foreach8Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categoryPercentages'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach9DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach9DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach9Backup = clone $_smarty_tpl->getVariable('c');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['name']), ENT_QUOTES, 'UTF-8');?>
'
                    <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('c', $foreach9Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            ],
            datasets: [{
                data: [
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categoryPercentages'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach10DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach10DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach10Backup = clone $_smarty_tpl->getVariable('c');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['percent']), ENT_QUOTES, 'UTF-8');?>

                        <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                        <?php }?>
                    <?php
$_smarty_tpl->setVariable('c', $foreach10Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('paymentMethodBreakdown'), 'p');
$foreach11DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('p')->value) {
$foreach11DoElse = false;
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('p')['payment_method']), ENT_QUOTES, 'UTF-8');?>
',<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('paymentMethodBreakdown'), 'p');
$foreach12DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('p')->value) {
$foreach12DoElse = false;
echo htmlspecialchars((string) ($_smarty_tpl->getValue('p')['total_spent']), ENT_QUOTES, 'UTF-8');?>
,<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('regionalComparison'), 'r');
$foreach13DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('r')->value) {
$foreach13DoElse = false;
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('r')['region']), ENT_QUOTES, 'UTF-8');?>
',<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                label: 'Wydatki',
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('regionalComparison'), 'r');
$foreach14DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('r')->value) {
$foreach14DoElse = false;
echo htmlspecialchars((string) ($_smarty_tpl->getValue('r')['total_spent']), ENT_QUOTES, 'UTF-8');?>
,<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                backgroundColor: 'rgba(54,162,235,0.5)'
            }]
        }
    });
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
