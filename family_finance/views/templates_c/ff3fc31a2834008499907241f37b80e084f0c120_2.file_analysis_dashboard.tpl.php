<?php
/* Smarty version 5.6.0, created on 2025-11-18 20:15:41
  from 'file:analysis_dashboard.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_691cc5ddd2c097_47674152',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff3fc31a2834008499907241f37b80e084f0c120' => 
    array (
      0 => 'analysis_dashboard.tpl',
      1 => 1763493314,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_691cc5ddd2c097_47674152 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-primary fw-bold"><i class="bi bi-bar-chart"></i> Analiza Finansowa</h2>

<form method="get" action="index.php" class="mb-5 p-3 border rounded-3 bg-dark shadow-sm row g-3 align-items-end">
    <input type="hidden" name="action" value="analysisDashboard">

    <div class="col-md-4 col-lg-3">
        <label for="date_from" class="form-label fw-semibold text-muted">Data początkowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
            <input type="date" id="date_from" name="date_from" class="form-control" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('date_from')), ENT_QUOTES, 'UTF-8');?>
">
        </div>
    </div>

    <div class="col-md-4 col-lg-3">
        <label for="date_to" class="form-label fw-semibold text-muted">Data końcowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
            <input type="date" id="date_to" name="date_to" class="form-control" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('date_to')), ENT_QUOTES, 'UTF-8');?>
">
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
    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null)))) {?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="regional-tab" data-bs-toggle="tab" data-bs-target="#regional" type="button"
                role="tab"><i class="bi bi-geo-alt-fill me-2"></i>Regiony</button>
        </li>
    <?php }?>
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
                            <span class="float-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('summary')['income'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 zł</span>
                        </p>
                        <p class="fs-5 mb-2">
                            <span class="fw-bold text-danger"><i
                                    class="bi bi-arrow-down-left-circle-fill me-2"></i>Wydatki:</span>
                            <span class="float-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('summary')['expense'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 zł</span>
                        </p>
                        <p class="fs-4 fw-bold mt-4 pt-2 border-top 
                           <?php if (($_smarty_tpl->getValue('summary')['income']-$_smarty_tpl->getValue('summary')['expense']) >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>">
                            <i class="bi bi-balance-fill me-2"></i>Bilans:
                            <span class="float-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')(($_smarty_tpl->getValue('summary')['income']-$_smarty_tpl->getValue('summary')['expense']),2,","," ")), ENT_QUOTES, 'UTF-8');?>

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
                            <?php if ($_smarty_tpl->getValue('topExpenses')) {?>
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('topExpenses'), 'e');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('e')->value) {
$foreach0DoElse = false;
?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="text-truncate me-3">
                                            <span class="fw-semibold"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['description']), ENT_QUOTES, 'UTF-8');?>
</span>
                                            <small class="text-muted d-block"><i
                                                    class="bi bi-calendar me-1"></i><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['transaction_date']), ENT_QUOTES, 'UTF-8');?>
</small>
                                        </div>
                                        <span class="badge bg-danger rounded-pill fs-6"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('e')['amount'],2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                            zł</span>
                                    </div>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                                <p class="text-muted fst-italic">Brak danych o wydatkach w wybranym okresie.</p>
                            <?php }?>
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

<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/chart.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach1DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach1Backup = clone $_smarty_tpl->getVariable('t');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['date']), ENT_QUOTES, 'UTF-8');?>
'
                <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                <?php }?>
            <?php
$_smarty_tpl->setVariable('t', $foreach1Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                label: 'Wydatki (zł)',
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach2DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach2Backup = clone $_smarty_tpl->getVariable('t');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['total']), ENT_QUOTES, 'UTF-8');?>

                    <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('t', $foreach2Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trendIncome'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach3DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach3Backup = clone $_smarty_tpl->getVariable('t');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['date']), ENT_QUOTES, 'UTF-8');?>
'
                <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                <?php }?>
            <?php
$_smarty_tpl->setVariable('t', $foreach3Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                label: 'Przychody (zł)',
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trendIncome'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach4DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach4Backup = clone $_smarty_tpl->getVariable('t');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['total']), ENT_QUOTES, 'UTF-8');?>

                    <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('t', $foreach4Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
'
                <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                <?php }?>
            <?php
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

                    <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('c', $foreach6Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                backgroundColor: chartColors.slice(0, <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categories'))), ENT_QUOTES, 'UTF-8');?>
)
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
'
                <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                <?php }?>
            <?php
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

                    <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('c', $foreach8Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                backgroundColor: chartColors.slice(0, <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('incomeCategories'))), ENT_QUOTES, 'UTF-8');?>
)
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
            labels: [<?php
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
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                data: [<?php
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
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                backgroundColor: chartColors.slice(0, <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categoryPercentages'))), ENT_QUOTES, 'UTF-8');?>
)
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('paymentMethodBreakdown'), 'p', true);
$_smarty_tpl->getVariable('p')->iteration = 0;
$foreach11DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('p')->value) {
$foreach11DoElse = false;
$_smarty_tpl->getVariable('p')->iteration++;
$_smarty_tpl->getVariable('p')->last = $_smarty_tpl->getVariable('p')->iteration === $_smarty_tpl->getVariable('p')->total;
$foreach11Backup = clone $_smarty_tpl->getVariable('p');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('p')['payment_method']), ENT_QUOTES, 'UTF-8');?>
'
                <?php if (!$_smarty_tpl->getVariable('p')->last) {?>,
                <?php }?>
            <?php
$_smarty_tpl->setVariable('p', $foreach11Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('paymentMethodBreakdown'), 'p', true);
$_smarty_tpl->getVariable('p')->iteration = 0;
$foreach12DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('p')->value) {
$foreach12DoElse = false;
$_smarty_tpl->getVariable('p')->iteration++;
$_smarty_tpl->getVariable('p')->last = $_smarty_tpl->getVariable('p')->iteration === $_smarty_tpl->getVariable('p')->total;
$foreach12Backup = clone $_smarty_tpl->getVariable('p');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('p')['total_spent']), ENT_QUOTES, 'UTF-8');?>

                    <?php if (!$_smarty_tpl->getVariable('p')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('p', $foreach12Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                backgroundColor: chartColors.slice(0, <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('paymentMethodBreakdown'))), ENT_QUOTES, 'UTF-8');?>
)
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
            labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('regionalComparison'), 'r', true);
$_smarty_tpl->getVariable('r')->iteration = 0;
$foreach13DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('r')->value) {
$foreach13DoElse = false;
$_smarty_tpl->getVariable('r')->iteration++;
$_smarty_tpl->getVariable('r')->last = $_smarty_tpl->getVariable('r')->iteration === $_smarty_tpl->getVariable('r')->total;
$foreach13Backup = clone $_smarty_tpl->getVariable('r');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('r')['region']), ENT_QUOTES, 'UTF-8');?>
'
                <?php if (!$_smarty_tpl->getVariable('r')->last) {?>,
                <?php }?>
            <?php
$_smarty_tpl->setVariable('r', $foreach13Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
            datasets: [{
                label: 'Wydatki (zł)',
                data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('regionalComparison'), 'r', true);
$_smarty_tpl->getVariable('r')->iteration = 0;
$foreach14DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('r')->value) {
$foreach14DoElse = false;
$_smarty_tpl->getVariable('r')->iteration++;
$_smarty_tpl->getVariable('r')->last = $_smarty_tpl->getVariable('r')->iteration === $_smarty_tpl->getVariable('r')->total;
$foreach14Backup = clone $_smarty_tpl->getVariable('r');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('r')['total_spent']), ENT_QUOTES, 'UTF-8');?>

                    <?php if (!$_smarty_tpl->getVariable('r')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('r', $foreach14Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategoryExpenses'), 'sc', true);
$_smarty_tpl->getVariable('sc')->iteration = 0;
$foreach15DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sc')->value) {
$foreach15DoElse = false;
$_smarty_tpl->getVariable('sc')->iteration++;
$_smarty_tpl->getVariable('sc')->last = $_smarty_tpl->getVariable('sc')->iteration === $_smarty_tpl->getVariable('sc')->total;
$foreach15Backup = clone $_smarty_tpl->getVariable('sc');
?>'<?php echo strtr((string)$_smarty_tpl->getValue('sc')['sub_category'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
						"\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
						"`" => "\\`", "\${" => "\\\$\{"));?>
'
                            <?php if (!$_smarty_tpl->getVariable('sc')->last) {?>,
                            <?php }?>
                        <?php
$_smarty_tpl->setVariable('sc', $foreach15Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    ],
                    datasets: [{
                        label: 'Wydatki (zł)',
                        data: [
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategoryExpenses'), 'sc', true);
$_smarty_tpl->getVariable('sc')->iteration = 0;
$foreach16DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sc')->value) {
$foreach16DoElse = false;
$_smarty_tpl->getVariable('sc')->iteration++;
$_smarty_tpl->getVariable('sc')->last = $_smarty_tpl->getVariable('sc')->iteration === $_smarty_tpl->getVariable('sc')->total;
$foreach16Backup = clone $_smarty_tpl->getVariable('sc');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('sc')['total']), ENT_QUOTES, 'UTF-8');?>

                                <?php if (!$_smarty_tpl->getVariable('sc')->last) {?>,
                                <?php }?>
                            <?php
$_smarty_tpl->setVariable('sc', $foreach16Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
