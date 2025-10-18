{include file='header.tpl'}

{if isset($success)}
    <div class="alert alert-success">
        {$success}
    </div>
{/if}

{if isset($errors) && $errors|@count > 0}
    <div class="alert alert-danger">
        <ul>
            {foreach $errors as $error}
                <li>{$error}</li>
            {/foreach}
        </ul>
    </div>
{/if}

<form action="index.php?action=addTransaction" method="POST" class="p-4 bg-light rounded shadow-sm"
    id="transactionForm">
    <h4 class="mb-4">Dodaj nową transakcję</h4>

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


    <div class="mb-3">
        <label for="category_id" class="form-label">Kategoria główna:</label>
        <select class="form-select select2" id="category_id" name="category_id" required>
            <option value="">Wybierz kategorię...</option>
            {foreach $categories as $category}
                {if $category.parent_id == null}
                    <option value="{$category.id}">{$category.name}</option>
                    {foreach $categories as $sub}
                        {if $sub.parent_id == $category.id}
                            <option value="{$sub.id}">&nbsp;&nbsp;– {$sub.name}</option>
                        {/if}
                    {/foreach}
                {/if}
            {/foreach}
        </select>
        <div class="form-text">
            Nie znalazłeś kategorii? <a href="#" id="addCategoryLink">Dodaj nową kategorię</a>.
        </div>
    </div>


    <h5 class="mt-4">Pozycje transakcji:</h5>
    <table class="table table-bordered" id="transactionItems">
        <thead>
            <tr>
                <th>Nazwa</th>
                <th>Ilość</th>
                <th>Cena</th>
                <th>Usuń</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="items[0][name]" class="form-control" required></td>
                <td><input type="number" name="items[0][quantity]" class="form-control itemQuantity" value="1" min="1">
                </td>
                <td><input type="number" step="0.01" name="items[0][amount]" class="form-control itemAmount" required>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" id="addRow" class="btn btn-secondary mb-3">Dodaj pozycję</button>
    <div class="mb-3">
        <strong>Suma: </strong> <span id="totalAmount">0.00</span>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Opis (opcjonalny):</label>
        <input type="text" class="form-control" id="description" name="description" maxlength="255"
            placeholder="np. Zakupy w Lidlu">
    </div>

    <div class="mb-3">
        <label for="transaction_date" class="form-label">Data transakcji:</label>
        <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date" required>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_recurring" name="is_recurring" value="1">
        <label class="form-check-label" for="is_recurring">Oznacz jako transakcję cykliczną</label>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="amount" class="form-label">Kwota całkowita:</label>
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

    <div class="mb-3">
        <label for="payment_method" class="form-label">Forma płatności:</label>
        <select class="form-select" id="payment_method" name="payment_method" required>
            <option value="">Wybierz metodę...</option>
            <option value="cash">Gotówka</option>
            <option value="card">Karta płatnicza</option>
            <option value="crypto">Kryptowaluta</option>
        </select>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Zapisz transakcję</button>
    </div>
</form>

<script>
    let rowIndex = 1;

    // Funkcja do aktualizacji całkowitej kwoty
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
        // Select2 dla kategorii
        $('#category_id').select2({
            placeholder: "Wybierz kategorię",
            allowClear: true
        });

        $('input[name="type"]').change(function() {
            let type = $(this).val();
            if (type === 'income') {
                $('#transactionItems').removeClass('table-danger').addClass('table-success');
            } else {
                $('#transactionItems').removeClass('table-success').addClass('table-danger');
            }
        });

        // Dodawanie nowego wiersza
        $('#addRow').click(function() {
            let newRow = '<tr>' +
                '<td><input type="text" name="items[' + rowIndex +
                '][name]" class="form-control" required></td>' +
                '<td><input type="number" name="items[' + rowIndex +
                '][quantity]" class="form-control itemQuantity" value="1" min="1"></td>' +
                '<td><input type="number" step="0.01" name="items[' + rowIndex +
                '][amount]" class="form-control itemAmount" required></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>' +
                '</tr>';
            $('#transactionItems tbody').append(newRow);
            rowIndex++;
            updateTotal();
        });

        // Usuwanie wiersza
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
            updateTotal();
        });

        // Aktualizacja całkowitej kwoty przy zmianie wartości
        $(document).on('input', '.itemQuantity, .itemAmount', function() {
            updateTotal();
        });

        // Początkowe wyliczenie
        updateTotal();
    });
</script>

{include file='footer.tpl'}