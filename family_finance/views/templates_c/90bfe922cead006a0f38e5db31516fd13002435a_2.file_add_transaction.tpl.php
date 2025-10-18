<?php
/* Smarty version 5.6.0, created on 2025-10-18 17:57:25
  from 'file:add_transaction.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f3b8e5ea80a1_54673320',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '90bfe922cead006a0f38e5db31516fd13002435a' => 
    array (
      0 => 'add_transaction.tpl',
      1 => 1760802908,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f3b8e5ea80a1_54673320 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('success')), ENT_QUOTES, 'UTF-8');?>

    </div>
<?php }?>

<?php if ((true && ($_smarty_tpl->hasVariable('errors') && null !== ($_smarty_tpl->getValue('errors') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('errors')) > 0) {?>
    <div class="alert alert-danger">
        <ul>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('errors'), 'error');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('error')->value) {
$foreach0DoElse = false;
?>
                <li><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</li>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </ul>
    </div>
<?php }?>


<form action="index.php?action=addTransaction" method="POST" class="p-4 bg-light rounded shadow-sm"
    id="transactionForm">
    <h4 class="mb-4">Dodaj nową transakcję</h4>

    <!-- Typ transakcji -->
    <div class="mb-3">
        <label class="form-label">Typ transakcji:</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="income" value="income" required>
                <label class="form-check-label" for="income">Przychód</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="expense" value="expense">
                <label class="form-check-label" for="expense">Wydatek</label>
            </div>
        </div>
    </div>

    <!-- Kwota -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="amount" class="form-label">Kwota:</label>
            <input type="number" step="0.01" min="0" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="col-md-6">
            <label for="currency" class="form-label">Waluta:</label>
            <select class="form-select" id="currency" name="currency" required>
                <option value="">Wybierz walutę...</option>
                <option value="PLN">PLN</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="BTC">BTC</option>
                <option value="ETH">ETH</option>
            </select>
        </div>
    </div>

    <!-- Forma płatności -->
    <div class="mb-3">
        <label for="payment_method" class="form-label">Forma płatności:</label>
        <select class="form-select" id="payment_method" name="payment_method" required>
            <option value="">Wybierz metodę...</option>
            <option value="cash">Gotówka</option>
            <option value="card">Karta płatnicza</option>
            <option value="crypto">Kryptowaluta</option>
        </select>
    </div>

    <!-- Kategoria -->
    <div class="mb-3">
        <label for="category_id" class="form-label">Kategoria:</label>
        <select class="form-select select2" id="category_id" name="category_id" required>
            <option value="">Wybierz kategorię...</option>
            <option value="1">Owoce i warzywa</option>
            <option value="2">Słodycze</option>
            <option value="3">Paliwo</option>
            <option value="4">Bilety komunikacji</option>
            <option value="5">Kino</option>
            <option value="6">Gry komputerowe</option>
        </select>
        <div class="form-text">
            Nie znalazłeś kategorii? <a href="#" id="addCategoryLink">Dodaj nową kategorię</a>.
        </div>
    </div>

    <!-- Opis -->
    <div class="mb-3">
        <label for="description" class="form-label">Opis (opcjonalny):</label>
        <input type="text" class="form-control" id="description" name="description" maxlength="255"
            placeholder="np. Zakupy w Lidlu">
    </div>

    <!-- Data transakcji -->
    <div class="mb-3">
        <label for="transaction_date" class="form-label">Data transakcji:</label>
        <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date" required>
    </div>

    <!-- Cykliczność -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_recurring" name="is_recurring" value="1">
        <label class="form-check-label" for="is_recurring">Oznacz jako transakcję cykliczną</label>
    </div>

    <!-- Przycisk -->
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Zapisz transakcję</button>
    </div>
</form>

<?php echo '<script'; ?>
>
    $(document).ready(function() {
        $('#category_id').select2({
            placeholder: "Wybierz kategorię",
            allowClear: true
        });
    });
<?php echo '</script'; ?>
>
<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
