<?php
/* Smarty version 5.6.0, created on 2025-11-22 15:21:08
  from 'file:analysis_dashboard.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6921c6d487ec94_86898251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff3fc31a2834008499907241f37b80e084f0c120' => 
    array (
      0 => 'analysis_dashboard.tpl',
      1 => 1763821263,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6921c6d487ec94_86898251 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-primary fw-bold"><i class="bi bi-bar-chart"></i> Analiza Finansowa</h2>

<!-- Formularz filtrowania z wyborem waluty -->
<form method="get" action="index.php" class="mb-5 p-3 border rounded-3 bg-dark shadow-sm row g-3 align-items-end">
    <input type="hidden" name="action" value="analysisDashboard">

    <div class="col-md-3 col-lg-2">
        <label for="date_from" class="form-label fw-semibold text-muted">Data początkowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
            <input type="date" id="date_from" name="date_from" class="form-control" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('date_from')), ENT_QUOTES, 'UTF-8');?>
">
        </div>
    </div>

    <div class="col-md-3 col-lg-2">
        <label for="date_to" class="form-label fw-semibold text-muted">Data końcowa:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
            <input type="date" id="date_to" name="date_to" class="form-control" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('date_to')), ENT_QUOTES, 'UTF-8');?>
">
        </div>
    </div>

    <div class="col-md-3 col-lg-2">
        <label for="currency" class="form-label fw-semibold text-muted">Waluta:</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
            <select id="currency" name="currency" class="form-select">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('currencies'), 'curr');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('curr')->value) {
$foreach0DoElse = false;
?>
                    <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('curr')['currency']), ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->getValue('currency') == $_smarty_tpl->getValue('curr')['currency']) {?>selected<?php }?>>
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('curr')['currency']), ENT_QUOTES, 'UTF-8');?>

                    </option>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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
    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null)))) {?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button"
                role="tab"><i class="bi bi-people-fill me-2"></i>Członkowie Rodziny</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="regional-tab" data-bs-toggle="tab" data-bs-target="#regional" type="button"
                role="tab"><i class="bi bi-geo-alt-fill me-2"></i>Regiony</button>
        </li>
    <?php }?>
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
                        <?php if ($_smarty_tpl->getValue('summary')['income'] > 0 || $_smarty_tpl->getValue('summary')['expense'] > 0) {?>
                            <p class="fs-5 mb-2">
                                <span class="fw-bold text-success"><i
                                        class="bi bi-arrow-up-right-circle-fill me-2"></i>Przychody:</span>
                                <span class="float-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('summary')['income'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</span>
                            </p>
                            <p class="fs-5 mb-2">
                                <span class="fw-bold text-danger"><i
                                        class="bi bi-arrow-down-left-circle-fill me-2"></i>Wydatki:</span>
                                <span class="float-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('summary')['expense'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</span>
                            </p>
                            <p class="fs-4 fw-bold mt-4 pt-2 border-top 
                               <?php if (($_smarty_tpl->getValue('summary')['income']-$_smarty_tpl->getValue('summary')['expense']) >= 0) {?>text-success<?php } else { ?>text-danger<?php }?>">
                                <i class="bi bi-balance-fill me-2"></i>Bilans:
                                <span class="float-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')(($_smarty_tpl->getValue('summary')['income']-$_smarty_tpl->getValue('summary')['expense']),2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</span>
                            </p>
                        <?php } else { ?>
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych finansowych w wybranym okresie</p>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-8">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h4 class="card-title text-danger"><i class="bi bi-bag-x-fill me-2"></i>Top 10 Największych
                            Wydatków</h4>
                        <hr>
                        <?php if ($_smarty_tpl->getValue('topExpenses')) {?>
                            <div class="list-group list-group-flush">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('topExpenses'), 'e', false, 'index');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('index')->value => $_smarty_tpl->getVariable('e')->value) {
$foreach1DoElse = false;
?>
                                    <div class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="me-3">
                                            <span class="badge bg-secondary me-2"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('index')+1), ENT_QUOTES, 'UTF-8');?>
</span>
                                        </div>
                                        <div class="flex-grow-1 me-3">
                                            <div class="fw-semibold mb-1"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['description']), ENT_QUOTES, 'UTF-8');?>
</div>
                                            <div class="small text-muted">
                                                <span class="me-3">
                                                    <i class="bi bi-tag me-1"></i>
                                                    <?php if ($_smarty_tpl->getValue('e')['category_name']) {?>
                                                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['category_name']), ENT_QUOTES, 'UTF-8');?>

                                                    <?php } else { ?>
                                                        <span class="text-warning">Brak kategorii</span>
                                                    <?php }?>
                                                </span>

                                                <span class="me-3">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('e')['transaction_date'],"%d.%m.%Y")), ENT_QUOTES, 'UTF-8');?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-danger fs-5"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('e')['amount'],2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</div>
                                            <div class="small text-muted">
                                                <?php if ($_smarty_tpl->getValue('e')['payment_method'] == 'cash') {?>
                                                    <i class="bi bi-cash-coin"></i> Gotówka
                                                <?php } elseif ($_smarty_tpl->getValue('e')['payment_method'] == 'card') {?>
                                                    <i class="bi bi-credit-card"></i> Karta
                                                <?php } elseif ($_smarty_tpl->getValue('e')['payment_method'] == 'crypto') {?>
                                                    <i class="bi bi-currency-bitcoin"></i> Krypto
                                                <?php } else { ?>
                                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('e')['payment_method']), ENT_QUOTES, 'UTF-8');?>

                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </div>
                        <?php } else { ?>
                            <div class="text-center py-4">
                                <i class="bi bi-receipt display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak wydatków w wybranym okresie</p>
                            </div>
                        <?php }?>
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
                            (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                        <?php if ($_smarty_tpl->getValue('trend') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('trend')) > 0) {?>
                            <canvas id="trendExpensesChart" height="150"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-graph-down display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o trendzie wydatków</p>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-graph-up me-2"></i>Trend przychodów
                            (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                        <?php if ($_smarty_tpl->getValue('trendIncome') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('trendIncome')) > 0) {?>
                            <canvas id="trendIncomeChart" height="150"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-graph-up display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o trendzie przychodów</p>
                            </div>
                        <?php }?>
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
                            (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                        <?php if ($_smarty_tpl->getValue('categories') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categories')) > 0) {?>
                            <canvas id="categoryExpensesChart"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-pie-chart display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o kategoriach wydatków</p>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-pie-chart-fill me-2"></i>Struktura
                            przychodów (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                        <?php if ($_smarty_tpl->getValue('incomeCategories') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('incomeCategories')) > 0) {?>
                            <canvas id="categoryIncomeChart"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-pie-chart display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o kategoriach przychodów</p>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-info"><i class="bi bi-percent me-2"></i>Procentowy udział wydatków
                        </h5>
                        <?php if ($_smarty_tpl->getValue('categoryPercentages') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categoryPercentages')) > 0) {?>
                            <canvas id="categoryPercentChart"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-percent display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych do analizy procentowej</p>
                            </div>
                        <?php }?>
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
                            podkategorii (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                        <?php if ($_smarty_tpl->getValue('subCategoryExpenses') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('subCategoryExpenses')) > 0) {?>
                            <canvas id="subCategoryChart"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-tags display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o podkategoriach wydatków</p>
                            </div>
                        <?php }?>
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
                            podkategorii (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                        <?php if ($_smarty_tpl->getValue('subCategoryIncome') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('subCategoryIncome')) > 0) {?>
                            <canvas id="subCategoryIncomeChart"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-tags display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o podkategoriach przychodów</p>
                            </div>
                        <?php }?>
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
                            płatności (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                        <?php if ($_smarty_tpl->getValue('paymentMethodBreakdown') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('paymentMethodBreakdown')) > 0) {?>
                            <canvas id="paymentChart"></canvas>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="bi bi-credit-card display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych o metodach płatności</p>
                            </div>
                        <?php }?>
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
                        <?php if ($_smarty_tpl->getValue('familySpending') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('familySpending')) > 0) {?>
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
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('familySpending'), 'member');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('member')->value) {
$foreach2DoElse = false;
?>
                                            <tr>
                                                <td>
                                                    <i class="bi bi-person-circle me-2"></i>
                                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('member')['username']), ENT_QUOTES, 'UTF-8');?>

                                                    <?php if ($_smarty_tpl->getValue('member')['user_id'] == $_smarty_tpl->getValue('session')['user_id']) {?>
                                                        <span class="badge bg-primary ms-1">Ty</span>
                                                    <?php }?>
                                                </td>
                                                <td class="text-end fw-bold"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('member')['total_spent'],2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</td>
                                                <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('member')['transactions']), ENT_QUOTES, 'UTF-8');?>
</td>
                                                <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('member')['avg_spent'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>

                                                </td>
                                                <td class="text-end">
                                                    <?php $_smarty_tpl->assign('percentage', ($_smarty_tpl->getValue('member')['total_spent']/$_smarty_tpl->getValue('familyTotalSpending')*100), false, NULL);?>
                                                    <span class="badge bg-secondary"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('percentage'),1)), ENT_QUOTES, 'UTF-8');?>
%</span>
                                                </td>
                                            </tr>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark">
                                            <td><strong>Razem</strong></td>
                                            <td class="text-end"><strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('familyTotalSpending'),2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</strong></td>
                                            <td class="text-end"><strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('familyTotalTransactions')), ENT_QUOTES, 'UTF-8');?>
</strong></td>
                                            <td class="text-end"><strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('familyAverageSpending'),2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</strong></td>
                                            <td class="text-end"><strong>100%</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="text-center py-4">
                                <i class="bi bi-table display-1 text-muted"></i>
                                <p class="fs-5 text-muted mt-3">Brak danych do wyświetlenia</p>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php if ($_smarty_tpl->getValue('isPremium')) {?>
        <div class="tab-pane fade" id="regional" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title text-secondary"><i class="bi bi-map-fill me-2"></i>Porównanie regionalne
                                wydatków (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)</h5>
                            <?php if ($_smarty_tpl->getValue('regionalComparison') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('regionalComparison')) > 0) {?>
                                <canvas id="regionalChart" height="100"></canvas>
                            <?php } else { ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-map display-1 text-muted"></i>
                                    <p class="fs-5 text-muted mt-3">Brak danych do porównania regionalnego</p>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="tab-pane fade" id="regional" role="tabpanel">
            <div class="text-center py-5">
                <i class="bi bi-lock-fill display-1 text-muted"></i>
                <p class="fs-5 text-muted mt-3">Sekcja dostępna tylko dla kont premium</p>
            </div>
        </div>
    <?php }?>


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
                                    <?php if ($_smarty_tpl->getValue('descriptiveStats')['count'] >= 2) {?>
                                        <tr>
                                            <td><strong>Średnia</strong></td>
                                            <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('descriptiveStats')['mean'],2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mediana</strong></td>
                                            <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('descriptiveStats')['median'],2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Odchylenie standardowe</strong></td>
                                            <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('descriptiveStats')['std_dev'],2,","," ")), ENT_QUOTES, 'UTF-8');?>

                                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Wariancja</strong></td>
                                            <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('descriptiveStats')['variance'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kurtoza</strong></td>
                                            <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('descriptiveStats')['kurtosis'],3)), ENT_QUOTES, 'UTF-8');?>
</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Skosność</strong></td>
                                            <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('descriptiveStats')['skewness'],3)), ENT_QUOTES, 'UTF-8');?>
</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Współczynnik zmienności</strong></td>
                                            <td class="text-end">
                                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('descriptiveStats')['coefficient_of_variation'],1)), ENT_QUOTES, 'UTF-8');?>
%</td>
                                        </tr>
                                    <?php } else { ?>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle"></i>
                                            Zbyt mało danych w wybranej walucie do obliczenia statystyk
                                        </div>
                                    <?php }?>
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
                                        <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('concentrationStats')['gini'],3)), ENT_QUOTES, 'UTF-8');?>
</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Wskaźnik Herfindahla-Hirschmana</strong></td>
                                        <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('concentrationStats')['hhi'],0)), ENT_QUOTES, 'UTF-8');?>
</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Wskaźnik koncentracji CR(3)</strong></td>
                                        <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('concentrationStats')['cr3'],1)), ENT_QUOTES, 'UTF-8');?>
%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Wskaźnik koncentracji CR(5)</strong></td>
                                        <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('concentrationStats')['cr5'],1)), ENT_QUOTES, 'UTF-8');?>
%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Entropia Shannona</strong></td>
                                        <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('concentrationStats')['entropy'],3)), ENT_QUOTES, 'UTF-8');?>
</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analiza trendu -->
            <?php if ($_smarty_tpl->getValue('isPremium')) {?>
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
                                        <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('trendAnalysis')['r_squared'],3)), ENT_QUOTES, 'UTF-8');?>
</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Przeciętne tempo zmian</strong></td>
                                        <td
                                            class="text-end <?php if ($_smarty_tpl->getValue('trendAnalysis')['growth_rate'] > 0) {?>text-danger<?php } else { ?>text-success<?php }?>">
                                            <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('trendAnalysis')['growth_rate'],2)), ENT_QUOTES, 'UTF-8');?>
%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Statystyka t</strong></td>
                                        <td class="text-end"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('trendAnalysis')['t_statistic'],3)), ENT_QUOTES, 'UTF-8');?>
</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-md-6">
                    <div class="card shadow-lg text-center py-5">
                        <i class="bi bi-lock-fill display-1 text-muted"></i>
                        <p class="fs-5 text-muted mt-3">Analiza trendu dostępna tylko dla kont premium</p>
                    </div>
                </div>
            <?php }?>




        </div>

        <!-- Sekcja z opisami wskaźników -->
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

<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/chart.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
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
    <?php if ($_smarty_tpl->getValue('trend') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('trend')) > 0) {?>
        new Chart(document.getElementById('trendExpensesChart'), {
            type: 'line',
            data: {
                labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't', true);
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
                    label: 'Wydatki (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)',
                    data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't', true);
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
                            text: 'Kwota (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)'
                        }
                    }
                }
            }
        });
    <?php }?>

    // Trend przychodów - tylko jeśli są dane
    <?php if ($_smarty_tpl->getValue('trendIncome') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('trendIncome')) > 0) {?>
        new Chart(document.getElementById('trendIncomeChart'), {
            type: 'line',
            data: {
                labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trendIncome'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach5DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach5Backup = clone $_smarty_tpl->getVariable('t');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['date']), ENT_QUOTES, 'UTF-8');?>
'
                    <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('t', $foreach5Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                datasets: [{
                    label: 'Przychody (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)',
                    data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trendIncome'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach6DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach6Backup = clone $_smarty_tpl->getVariable('t');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['total']), ENT_QUOTES, 'UTF-8');?>

                        <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                        <?php }?>
                    <?php
$_smarty_tpl->setVariable('t', $foreach6Backup);
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
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kwota (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)'
                        }
                    }
                }
            }
        });
    <?php }?>

    // Kategorie wydatków - tylko jeśli są dane
    <?php if ($_smarty_tpl->getValue('categories') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categories')) > 0) {?>
        new Chart(document.getElementById('categoryExpensesChart'), {
            type: 'pie',
            data: {
                labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'c', true);
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
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'c', true);
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
                    backgroundColor: chartColors.slice(0, <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categories'))), ENT_QUOTES, 'UTF-8');?>
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
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + ' <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    <?php }?>

    // Kategorie przychodów - tylko jeśli są dane
    <?php if ($_smarty_tpl->getValue('incomeCategories') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('incomeCategories')) > 0) {?>
        new Chart(document.getElementById('categoryIncomeChart'), {
            type: 'pie',
            data: {
                labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('incomeCategories'), 'c', true);
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
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('incomeCategories'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach10DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach10DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach10Backup = clone $_smarty_tpl->getVariable('c');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['total']), ENT_QUOTES, 'UTF-8');?>

                        <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                        <?php }?>
                    <?php
$_smarty_tpl->setVariable('c', $foreach10Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                    backgroundColor: chartColors.slice(0, <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('incomeCategories'))), ENT_QUOTES, 'UTF-8');?>
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
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + ' <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    <?php }?>

    // Procentowy udział wydatków - tylko jeśli są dane
    <?php if ($_smarty_tpl->getValue('categoryPercentages') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('categoryPercentages')) > 0) {?>
        new Chart(document.getElementById('categoryPercentChart'), {
            type: 'doughnut',
            data: {
                labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categoryPercentages'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach11DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach11DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach11Backup = clone $_smarty_tpl->getVariable('c');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['name']), ENT_QUOTES, 'UTF-8');?>
'
                    <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('c', $foreach11Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                datasets: [{
                    data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categoryPercentages'), 'c', true);
$_smarty_tpl->getVariable('c')->iteration = 0;
$foreach12DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('c')->value) {
$foreach12DoElse = false;
$_smarty_tpl->getVariable('c')->iteration++;
$_smarty_tpl->getVariable('c')->last = $_smarty_tpl->getVariable('c')->iteration === $_smarty_tpl->getVariable('c')->total;
$foreach12Backup = clone $_smarty_tpl->getVariable('c');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('c')['percent']), ENT_QUOTES, 'UTF-8');?>

                        <?php if (!$_smarty_tpl->getVariable('c')->last) {?>,
                        <?php }?>
                    <?php
$_smarty_tpl->setVariable('c', $foreach12Backup);
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
    <?php }?>

    // Wydatki wg płatności - tylko jeśli są dane
    <?php if ($_smarty_tpl->getValue('paymentMethodBreakdown') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('paymentMethodBreakdown')) > 0) {?>
        new Chart(document.getElementById('paymentChart'), {
            type: 'pie',
            data: {
                labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('paymentMethodBreakdown'), 'p', true);
$_smarty_tpl->getVariable('p')->iteration = 0;
$foreach13DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('p')->value) {
$foreach13DoElse = false;
$_smarty_tpl->getVariable('p')->iteration++;
$_smarty_tpl->getVariable('p')->last = $_smarty_tpl->getVariable('p')->iteration === $_smarty_tpl->getVariable('p')->total;
$foreach13Backup = clone $_smarty_tpl->getVariable('p');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('p')['payment_method']), ENT_QUOTES, 'UTF-8');?>
'
                    <?php if (!$_smarty_tpl->getVariable('p')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('p', $foreach13Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                datasets: [{
                    data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('paymentMethodBreakdown'), 'p', true);
$_smarty_tpl->getVariable('p')->iteration = 0;
$foreach14DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('p')->value) {
$foreach14DoElse = false;
$_smarty_tpl->getVariable('p')->iteration++;
$_smarty_tpl->getVariable('p')->last = $_smarty_tpl->getVariable('p')->iteration === $_smarty_tpl->getVariable('p')->total;
$foreach14Backup = clone $_smarty_tpl->getVariable('p');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('p')['total_spent']), ENT_QUOTES, 'UTF-8');?>

                        <?php if (!$_smarty_tpl->getVariable('p')->last) {?>,
                        <?php }?>
                    <?php
$_smarty_tpl->setVariable('p', $foreach14Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                    backgroundColor: chartColors.slice(0, <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('paymentMethodBreakdown'))), ENT_QUOTES, 'UTF-8');?>
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
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + ' <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    <?php }?>

    // Porównanie regionalne - tylko jeśli są dane
    <?php if ($_smarty_tpl->getValue('regionalComparison') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('regionalComparison')) > 0) {?>
        new Chart(document.getElementById('regionalChart'), {
            type: 'bar',
            data: {
                labels: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('regionalComparison'), 'r', true);
$_smarty_tpl->getVariable('r')->iteration = 0;
$foreach15DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('r')->value) {
$foreach15DoElse = false;
$_smarty_tpl->getVariable('r')->iteration++;
$_smarty_tpl->getVariable('r')->last = $_smarty_tpl->getVariable('r')->iteration === $_smarty_tpl->getVariable('r')->total;
$foreach15Backup = clone $_smarty_tpl->getVariable('r');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('r')['region']), ENT_QUOTES, 'UTF-8');?>
'
                    <?php if (!$_smarty_tpl->getVariable('r')->last) {?>,
                    <?php }?>
                <?php
$_smarty_tpl->setVariable('r', $foreach15Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
                datasets: [{
                    label: 'Wydatki (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)',
                    data: [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('regionalComparison'), 'r', true);
$_smarty_tpl->getVariable('r')->iteration = 0;
$foreach16DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('r')->value) {
$foreach16DoElse = false;
$_smarty_tpl->getVariable('r')->iteration++;
$_smarty_tpl->getVariable('r')->last = $_smarty_tpl->getVariable('r')->iteration === $_smarty_tpl->getVariable('r')->total;
$foreach16Backup = clone $_smarty_tpl->getVariable('r');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('r')['total_spent']), ENT_QUOTES, 'UTF-8');?>

                        <?php if (!$_smarty_tpl->getVariable('r')->last) {?>,
                        <?php }?>
                    <?php
$_smarty_tpl->setVariable('r', $foreach16Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>],
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
                            text: 'Kwota (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)'
                        }
                    }
                }
            }
        });
    <?php }?>

    // Inicjalizacja wykresu Podkategorii - tylko jeśli są dane
    <?php if ($_smarty_tpl->getValue('subCategoryExpenses') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('subCategoryExpenses')) > 0) {?>
        let subCategoryChart;
        document.getElementById('subcategories-tab').addEventListener('shown.bs.tab', function() {
            if (!subCategoryChart) {
                const ctx = document.getElementById('subCategoryChart').getContext('2d');
                subCategoryChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategoryExpenses'), 'sc', true);
$_smarty_tpl->getVariable('sc')->iteration = 0;
$foreach17DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sc')->value) {
$foreach17DoElse = false;
$_smarty_tpl->getVariable('sc')->iteration++;
$_smarty_tpl->getVariable('sc')->last = $_smarty_tpl->getVariable('sc')->iteration === $_smarty_tpl->getVariable('sc')->total;
$foreach17Backup = clone $_smarty_tpl->getVariable('sc');
?>'<?php echo strtr((string)$_smarty_tpl->getValue('sc')['sub_category'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
						"\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
						"`" => "\\`", "\${" => "\\\$\{"));?>
'
                                <?php if (!$_smarty_tpl->getVariable('sc')->last) {?>,
                                <?php }?>
                            <?php
$_smarty_tpl->setVariable('sc', $foreach17Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        ],
                        datasets: [{
                            label: 'Wydatki (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)',
                            data: [
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategoryExpenses'), 'sc', true);
$_smarty_tpl->getVariable('sc')->iteration = 0;
$foreach18DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sc')->value) {
$foreach18DoElse = false;
$_smarty_tpl->getVariable('sc')->iteration++;
$_smarty_tpl->getVariable('sc')->last = $_smarty_tpl->getVariable('sc')->iteration === $_smarty_tpl->getVariable('sc')->total;
$foreach18Backup = clone $_smarty_tpl->getVariable('sc');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('sc')['total']), ENT_QUOTES, 'UTF-8');?>

                                    <?php if (!$_smarty_tpl->getVariable('sc')->last) {?>,
                                    <?php }?>
                                <?php
$_smarty_tpl->setVariable('sc', $foreach18Backup);
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
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Kwota (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)'
                                }
                            }
                        }
                    }
                });
            }
        });
    <?php }?>

    <?php if ($_smarty_tpl->getValue('subCategoryIncome') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('subCategoryIncome')) > 0) {?>
        // Wykres podkategorii przychodów
        let subCategoryIncomeChart;
        document.getElementById('subcategories-income-tab').addEventListener('shown.bs.tab', function() {
            if (!subCategoryIncomeChart) {
                const ctx = document.getElementById('subCategoryIncomeChart').getContext('2d');
                subCategoryIncomeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategoryIncome'), 'sc', true);
$_smarty_tpl->getVariable('sc')->iteration = 0;
$foreach19DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sc')->value) {
$foreach19DoElse = false;
$_smarty_tpl->getVariable('sc')->iteration++;
$_smarty_tpl->getVariable('sc')->last = $_smarty_tpl->getVariable('sc')->iteration === $_smarty_tpl->getVariable('sc')->total;
$foreach19Backup = clone $_smarty_tpl->getVariable('sc');
?>'<?php echo strtr((string)$_smarty_tpl->getValue('sc')['sub_category'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
						"\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
						"`" => "\\`", "\${" => "\\\$\{"));?>
'
                                <?php if (!$_smarty_tpl->getVariable('sc')->last) {?>,
                                <?php }?>
                            <?php
$_smarty_tpl->setVariable('sc', $foreach19Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        ],
                        datasets: [{
                            label: 'Przychody (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)',
                            data: [
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategoryIncome'), 'sc', true);
$_smarty_tpl->getVariable('sc')->iteration = 0;
$foreach20DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sc')->value) {
$foreach20DoElse = false;
$_smarty_tpl->getVariable('sc')->iteration++;
$_smarty_tpl->getVariable('sc')->last = $_smarty_tpl->getVariable('sc')->iteration === $_smarty_tpl->getVariable('sc')->total;
$foreach20Backup = clone $_smarty_tpl->getVariable('sc');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('sc')['total']), ENT_QUOTES, 'UTF-8');?>

                                    <?php if (!$_smarty_tpl->getVariable('sc')->last) {?>,
                                    <?php }?>
                                <?php
$_smarty_tpl->setVariable('sc', $foreach20Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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
                                    text: 'Kwota (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
)'
                                }
                            }
                        }
                    }
                });
            }
        });
    <?php }?>
    // Analiza trendu czasowego Z LINIĄ TRENDU
    <?php if ($_smarty_tpl->getValue('trend') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('trend')) > 0 && $_smarty_tpl->getValue('trendAnalysis')) {?>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('trendAnalysisChart');
            if (!ctx) return;

            ctx.style.height = '200px';

            const dates = [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach21DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach21DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach21Backup = clone $_smarty_tpl->getVariable('t');
?>'<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['date']), ENT_QUOTES, 'UTF-8');?>
'
                <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                <?php }?>
            <?php
$_smarty_tpl->setVariable('t', $foreach21Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>];
            const actualValues = [<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('trend'), 't', true);
$_smarty_tpl->getVariable('t')->iteration = 0;
$foreach22DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('t')->value) {
$foreach22DoElse = false;
$_smarty_tpl->getVariable('t')->iteration++;
$_smarty_tpl->getVariable('t')->last = $_smarty_tpl->getVariable('t')->iteration === $_smarty_tpl->getVariable('t')->total;
$foreach22Backup = clone $_smarty_tpl->getVariable('t');
echo htmlspecialchars((string) ($_smarty_tpl->getValue('t')['total']), ENT_QUOTES, 'UTF-8');?>

                <?php if (!$_smarty_tpl->getVariable('t')->last) {?>,
                <?php }?>
            <?php
$_smarty_tpl->setVariable('t', $foreach22Backup);
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>];

            // Oblicz linię trendu
            const trendLine = [];
            const n = actualValues.length;
            <?php if ($_smarty_tpl->getValue('trendAnalysis')['slope'] && $_smarty_tpl->getValue('trendAnalysis')['intercept']) {?>
                for (let i = 0; i < n; i++) {
                    trendLine.push(<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trendAnalysis')['intercept']), ENT_QUOTES, 'UTF-8');?>
 + <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trendAnalysis')['slope']), ENT_QUOTES, 'UTF-8');?>
 * (i + 1));
                }
            <?php } else { ?>
                // Fallback - prosta linia trendu
                const firstValue = actualValues[0];
                const lastValue = actualValues[n - 1];
                const slope = (lastValue - firstValue) / (n - 1);
                for (let i = 0; i < n; i++) {
                    trendLine.push(firstValue + slope * i);
                }
            <?php }?>

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
                                    return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('currency')), ENT_QUOTES, 'UTF-8');?>
';
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
    <?php } else { ?>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('trendAnalysisChart');
            if (container) {
                container.innerHTML =
                    '<div class="text-center py-3 text-muted"><small>Brak danych do analizy trendu</small></div>';
            }
        });
    <?php }
echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
