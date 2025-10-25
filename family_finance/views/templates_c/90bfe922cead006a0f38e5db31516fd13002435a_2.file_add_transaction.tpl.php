<?php
/* Smarty version 5.6.0, created on 2025-10-25 19:06:13
  from 'file:add_transaction.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fd0385366a07_20231832',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '90bfe922cead006a0f38e5db31516fd13002435a' => 
    array (
      0 => 'add_transaction.tpl',
      1 => 1761411967,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fd0385366a07_20231832 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('success')), ENT_QUOTES, 'UTF-8');?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }?>

<?php if ((true && ($_smarty_tpl->hasVariable('errors') && null !== ($_smarty_tpl->getValue('errors') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('errors')) > 0) {?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
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
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php }?>

<form action="index.php?action=addTransaction" method="POST"
    class="p-4 bg-dark-subtle text-light rounded-4 shadow-lg" id="transactionForm">
    <h4 class="mb-4 fw-bold text-light-emphasis">Dodaj nową transakcję</h4>

    <!-- Typ transakcji -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Typ transakcji:</label>
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

    <!-- Kategoria -->
    <div class="mb-3">
        <label for="category_id" class="form-label fw-semibold">Kategoria główna:</label>
        <select class="form-select select2" id="category_id" name="category_id" required>
            <option value="">Wybierz kategorię...</option>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'category');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('category')->value) {
$foreach1DoElse = false;
?>
                <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['id']), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['name']), ENT_QUOTES, 'UTF-8');?>
</option>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </select>
        <div class="form-text text-light-emphasis">
            Nie znalazłeś kategorii? <a href="#" id="addCategoryLink">Dodaj nową kategorię</a>.
        </div>
    </div>

    <!-- Pozycje transakcji -->
    <h5 class="mt-4 fw-semibold">Pozycje transakcji:</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-dark-subtle text-light" id="transactionItems">
            <thead class="table-dark">
                <tr>
                    <th>Nazwa</th>
                    <th>Ilość</th>
                    <th>Cena</th>
                    <th>Usuń</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select class="form-select subcategory-select" name="items[0][subcategory_id]" required>
                            <option value="">Wybierz podkategorię...</option>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategories'), 'subCategory');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('subCategory')->value) {
$foreach2DoElse = false;
?>
                                <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('subCategory')['id']), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('subCategory')['name']), ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>
                    </td>
                    <td><input type="number" name="items[0][quantity]" class="form-control itemQuantity" value="1" min="1"></td>
                    <td><input type="number" step="0.01" name="items[0][amount]" class="form-control itemAmount" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="button" id="addRow" class="btn btn-secondary mb-3">Dodaj pozycję</button>

    <div class="mb-3 fw-semibold">
        Suma: <span id="totalAmount">0.00</span>
    </div>

    <!-- Opis -->
    <div class="mb-3">
        <label for="description" class="form-label fw-semibold">Opis (opcjonalny):</label>
        <input type="text" class="form-control bg-dark text-light" id="description" name="description" maxlength="255" placeholder="np. Zakupy w Lidlu">
    </div>

    <!-- Data -->
    <div class="mb-3">
        <label for="transaction_date" class="form-label fw-semibold">Data transakcji:</label>
        <input type="datetime-local" class="form-control bg-dark text-light" id="transaction_date" name="transaction_date" required>
    </div>

    <!-- Transakcja cykliczna -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_recurring" name="is_recurring" value="1">
        <label class="form-check-label" for="is_recurring">Oznacz jako transakcję cykliczną</label>
    </div>

    <!-- Kwota i waluta -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="amount" class="form-label fw-semibold">Kwota całkowita:</label>
            <input type="number" step="0.01" min="0" class="form-control bg-dark text-light" id="amount" name="amount" required>
        </div>
        <div class="col-md-6">
            <label for="currency" class="form-label fw-semibold">Waluta:</label>
            <select class="form-select bg-dark text-light" id="currency" name="currency" required>
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
        <label for="payment_method" class="form-label fw-semibold">Forma płatności:</label>
        <select class="form-select bg-dark text-light" id="payment_method" name="payment_method" required>
            <option value="">Wybierz metodę...</option>
            <option value="cash">Gotówka</option>
            <option value="card">Karta płatnicza</option>
            <option value="crypto">Kryptowaluta</option>
        </select>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary fw-semibold">Zapisz transakcję</button>
    </div>
</form>

<div class="d-flex justify-content-end mt-4">
    <a href="index.php?action=manageTransactions" class="btn btn-success fw-semibold">
        <i class="bi bi-list-ul"></i> Przejdź do zarządzania transakcjami
    </a>
</div>

<?php echo '<script'; ?>
>
    let rowIndex = 1;

    function updateTotal() {
        let total = 0;
        $('#transactionItems tbody tr').each(function() {
            let qty = parseFloat($(this).find('.itemQuantity').val()) || 0;
            let amount = parseFloat($(this).find('.itemAmount').val()) || 0;
            total += qty * amount;
        });
        $('#totalAmount').text(total.toFixed(2));
    }

    $(document).ready(function() {
        $('#category_id, #subCategory_id').select2({ placeholder: "Wybierz kategorię", allowClear: true });

        $('input[name="type"]').change(function() {
            let type = $(this).val();
            $('#transactionItems').removeClass('table-success table-danger');
            $('#transactionItems').addClass(type === 'income' ? 'table-success' : 'table-danger');
        });

        $('#addRow').click(function() {
            let newRow = '<tr>' +
                '<td><select class="form-select subcategory-select" name="items[' + rowIndex + '][subcategory_id]" required>' +
                '<option value="">Wybierz podkategorię...</option>' +
                '<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategories'), 'subCategory');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('subCategory')->value) {
$foreach3DoElse = false;
?>' +
                    '<option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('subCategory')['id']), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('subCategory')['name']), ENT_QUOTES, 'UTF-8');?>
</option>' +
                '<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>' +
                '</select></td>' +
                '<td><input type="number" name="items[' + rowIndex + '][quantity]" class="form-control itemQuantity" value="1" min="1"></td>' +
                '<td><input type="number" step="0.01" name="items[' + rowIndex + '][amount]" class="form-control itemAmount" required></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>' +
                '</tr>';
            $('#transactionItems tbody').append(newRow);
            rowIndex++;
            updateTotal();
        });

        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
            updateTotal();
        });

        $(document).on('input', '.itemQuantity, .itemAmount', function() {
            updateTotal();
        });

        updateTotal();
    });
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
