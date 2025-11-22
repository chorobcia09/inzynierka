<?php
/* Smarty version 5.6.0, created on 2025-11-22 19:05:23
  from 'file:edit_budget.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6921fb63f37364_47335772',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a7029f5da6291037ee23a73f855fffceadeb455' => 
    array (
      0 => 'edit_budget.tpl',
      1 => 1763834722,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6921fb63f37364_47335772 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container my-5">
    <div class="p-4 bg-dark-subtle text-light rounded-4 shadow-lg">

        <h2 class="mb-4 fw-bold text-light-emphasis">
            <i class="bi bi-pencil-square me-2"></i>Edytuj budżet: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['name']), ENT_QUOTES, 'UTF-8');?>

        </h2>

        <?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
            <div class="alert alert-danger"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
        <?php }?>
        <?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
            <div class="alert alert-success"><?php echo $_smarty_tpl->getValue('success');?>
</div>
        <?php }?>

        <form method="post" action="index.php?action=editBudget&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget_id')), ENT_QUOTES, 'UTF-8');?>
" id="budgetForm">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nazwa budżetu:</label>
                <input type="text" name="name" class="form-control bg-dark text-light border-secondary"
                    value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['name']), ENT_QUOTES, 'UTF-8');?>
" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Typ okresu:</label>
                    <select name="period_type" class="form-select bg-dark text-light border-secondary" required>
                        <option value="custom" <?php if ($_smarty_tpl->getValue('budget')['period_type'] == 'custom') {?>selected<?php }?>>Niestandardowy</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data początkowa:</label>
                    <input type="date" name="start_date" class="form-control bg-dark text-light border-secondary"
                        value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['start_date']), ENT_QUOTES, 'UTF-8');?>
" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data końcowa:</label>
                    <input type="date" name="end_date" class="form-control bg-dark text-light border-secondary"
                        value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['end_date']), ENT_QUOTES, 'UTF-8');?>
" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Waluta:</label>
                    <select class="form-select bg-dark text-light" name="currency" required>
                        <option value="PLN" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'PLN') {?>selected<?php }?>>PLN - Złoty</option>
                        <option value="USD" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'USD') {?>selected<?php }?>>USD - Dolar amerykański</option>
                        <option value="EUR" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'EUR') {?>selected<?php }?>>EUR - Euro</option>
                        <option value="GBP" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'GBP') {?>selected<?php }?>>GBP - Funt brytyjski</option>
                        <option value="CHF" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'CHF') {?>selected<?php }?>>CHF - Frank szwajcarski</option>
                        <option value="CAD" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'CAD') {?>selected<?php }?>>CAD - Dolar kanadyjski</option>
                        <option value="AUD" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'AUD') {?>selected<?php }?>>AUD - Dolar australijski</option>
                        <option value="JPY" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'JPY') {?>selected<?php }?>>JPY - Jen japoński</option>
                        <option value="CZK" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'CZK') {?>selected<?php }?>>CZK - Korona czeska</option>
                        <option value="NOK" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'NOK') {?>selected<?php }?>>NOK - Korona norweska</option>
                        <option value="BTC" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'BTC') {?>selected<?php }?>>BTC - Bitcoin</option>
                        <option value="ETH" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'ETH') {?>selected<?php }?>>ETH - Ethereum</option>
                        <option value="BNB" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'BNB') {?>selected<?php }?>>BNB - Binance Coin</option>
                        <option value="XRP" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'XRP') {?>selected<?php }?>>XRP - Ripple</option>
                        <option value="DOGE" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'DOGE') {?>selected<?php }?>>DOGE - Dogecoin</option>
                        <option value="USDT" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'USDT') {?>selected<?php }?>>USDT - Tether</option>
                        <option value="SOL" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'SOL') {?>selected<?php }?>>SOL - Solana</option>
                        <option value="ADA" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'ADA') {?>selected<?php }?>>ADA - Cardano</option>
                        <option value="TRX" <?php if ($_smarty_tpl->getValue('budget')['currency'] == 'TRX') {?>selected<?php }?>>TRX - TRON</option>
                    </select>
                </div>
            </div>

            <hr class="my-4 border-secondary">
            <h4 class="mb-3 text-light-emphasis fw-bold">
                <i class="bi bi-pie-chart-fill me-2"></i>Limity w kategoriach
            </h4>

            <div id="categories-container">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('budgetItems'), 'item', false, 'i');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('i')->value => $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
                    <div class="row mb-3 align-items-center category-row bg-dark p-3 rounded-3 shadow-sm">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategoria:</label>
                            <select class="form-select bg-dark text-light border-secondary"
                                name="categories[<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('i')), ENT_QUOTES, 'UTF-8');?>
][category_id]" required>
                                <option value="">Wybierz kategorię...</option>
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'category');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('category')->value) {
$foreach1DoElse = false;
?>
                                    <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['id']), ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->getValue('category')['id'] == $_smarty_tpl->getValue('item')['category_id']) {?>selected<?php }?>>
                                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['name']), ENT_QUOTES, 'UTF-8');?>

                                    </option>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Limit kategorii:</label>
                            <input type="number" step="0.01" name="categories[<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('i')), ENT_QUOTES, 'UTF-8');?>
][limit_amount]"
                                class="form-control bg-dark text-light border-secondary" 
                                value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('item')['limit_amount']), ENT_QUOTES, 'UTF-8');?>
" required>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>

            
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check2-circle me-2"></i>Zapisz zmiany
                </button>
                <a href="index.php?action=viewBudgets" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Anuluj
                </a>
            </div>
        </form>
    </div>
</div>


<?php echo '<script'; ?>
>
    let counter = {$budgetItems|count};
    document.getElementById('add-category').addEventListener('click', function() {
        const container = document.getElementById('categories-container');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3 align-items-center category-row bg-dark p-3 rounded-3 shadow-sm fade-in';
        newRow.innerHTML = `
            <div class="col-md-6">
                <label class="form-label fw-semibold">Kategoria:</label>
                <select class="form-select bg-dark text-light border-secondary" name="categories[${counter}][category_id]" required>
                    <option value="">Wybierz kategorię...</option>
                    ${document.querySelector('select[name="categories[0][category_id]"]').innerHTML}
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Limit kategorii:</label>
                <input type="number" step="0.01" name="categories[${counter}][limit_amount]" 
                    class="form-control bg-dark text-light border-secondary" placeholder="np. 500.00" required>
            </div>
        `;
        container.appendChild(newRow);
        newRow.scrollIntoView({behavior: "smooth", block: "center"});
        counter++;
    });

    // Efekt płynnego pojawiania się nowego wiersza
    const style = document.createElement('style');
    style.innerHTML = `
        .fade-in {
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeIn 0.3s ease forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
<?php echo '</script'; ?>
>


<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
