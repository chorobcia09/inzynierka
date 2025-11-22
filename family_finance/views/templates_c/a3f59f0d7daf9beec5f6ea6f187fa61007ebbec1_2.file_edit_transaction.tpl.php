<?php
/* Smarty version 5.6.0, created on 2025-11-22 19:30:18
  from 'file:edit_transaction.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6922013ae7f992_17504458',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3f59f0d7daf9beec5f6ea6f187fa61007ebbec1' => 
    array (
      0 => 'edit_transaction.tpl',
      1 => 1763836216,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6922013ae7f992_17504458 (\Smarty\Template $_smarty_tpl) {
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

<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h4 class="mb-0 fw-bold text-light-emphasis">Edytuj transakcję</h4>
    <a href="index.php?action=manageTransactions" class="btn btn-secondary fw-semibold">
        <i class="bi bi-arrow-left"></i> Powrót do listy
    </a>
</div>

<form action="index.php?action=editTransaction&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction_id')), ENT_QUOTES, 'UTF-8');?>
" method="POST"
    class="p-4 bg-dark-subtle text-light rounded-4 shadow-lg" id="transactionForm">

        <div class="mb-3">
        <label class="form-label fw-semibold">Typ transakcji:</label>
        <div class="d-flex align-items-center gap-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="income" value="income"
                    <?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>checked<?php }?> required>
                <label class="form-check-label text-success fw-semibold" for="income">
                    <i class="bi bi-arrow-up-circle"></i> Przychód
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="expense" value="expense"
                    <?php if ($_smarty_tpl->getValue('transaction')['type'] == 'expense') {?>checked<?php }?>>
                <label class="form-check-label text-danger fw-semibold" for="expense">
                    <i class="bi bi-arrow-down-circle"></i> Wydatek
                </label>
            </div>
        </div>
    </div>

        <div class="mb-3">
        <label for="category_id" class="form-label fw-semibold">Kategoria główna:</label>
        <select class="form-select select2 text-light" id="category_id" name="category_id" required>
            <option value="">Wybierz kategorię...</option>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'category');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('category')->value) {
$foreach1DoElse = false;
?>
                <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['id']), ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->getValue('category')['id'] == $_smarty_tpl->getValue('transaction')['category_id']) {?>selected<?php }?>>
                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['name']), ENT_QUOTES, 'UTF-8');?>

                </option>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </select>
    </div>

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
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('transactionItems'), 'item', false, 'index');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('index')->value => $_smarty_tpl->getVariable('item')->value) {
$foreach2DoElse = false;
?>
                    <tr>
                        <td>
                            <select class="form-select subcategory-select" name="items[<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('index')), ENT_QUOTES, 'UTF-8');?>
][subcategory_id]" required>
                                <option value="">Wybierz podkategorię...</option>
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subCategories'), 'sub');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sub')->value) {
$foreach3DoElse = false;
?>
                                    <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('sub')['id']), ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->getValue('sub')['id'] == $_smarty_tpl->getValue('item')['sub_category_id']) {?>selected<?php }?>>
                                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('sub')['name']), ENT_QUOTES, 'UTF-8');?>

                                    </option>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('index')), ENT_QUOTES, 'UTF-8');?>
][quantity]" class="form-control itemQuantity"
                                value="<?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('item')['quantity'] ?? null)===null||$tmp==='' ? 1 ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
" min="1">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('index')), ENT_QUOTES, 'UTF-8');?>
][amount]" class="form-control itemAmount"
                                value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('item')['amount']), ENT_QUOTES, 'UTF-8');?>
" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                        </td>
                    </tr>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('transactionItems')) == 0) {?>
                    <tr>
                        <td>
                            <select class="form-select subcategory-select" name="items[0][subcategory_id]" required>
                                <option value="">Wybierz podkategorię...</option>
                            </select>
                        </td>
                        <td><input type="number" name="items[0][quantity]" class="form-control itemQuantity" value="1"
                                min="1"></td>
                        <td><input type="number" step="0.01" name="items[0][amount]" class="form-control itemAmount"
                                required></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

    <button type="button" id="addRow" class="btn btn-secondary mb-3">Dodaj pozycję</button>

        <div class="mb-3">
        <label for="description" class="form-label fw-semibold">Opis (opcjonalny):</label>
        <input type="text" class="form-control bg-dark text-light" id="description" name="description"
            value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['description']), ENT_QUOTES, 'UTF-8');?>
" maxlength="255" placeholder="np. Zakupy w Lidlu">
    </div>

    <div class="mb-3">
        <label for="transaction_date" class="form-label fw-semibold">Data transakcji:</label>
        <input type="datetime-local" class="form-control bg-dark text-light" id="transaction_date"
            name="transaction_date" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('transaction')['transaction_date'],'%Y-%m-%dT%H:%M')), ENT_QUOTES, 'UTF-8');?>
" required>
    </div>

    <div class="mb-3">
        <label for="payment_method" class="form-label fw-semibold">Forma płatności:</label>
        <select class="form-select bg-dark text-light" id="payment_method" name="payment_method" required>
            <option value="">Wybierz metodę...</option>
            <option value="cash" <?php if ($_smarty_tpl->getValue('transaction')['payment_method'] == 'cash') {?>selected<?php }?>>Gotówka</option>
            <option value="card" <?php if ($_smarty_tpl->getValue('transaction')['payment_method'] == 'card') {?>selected<?php }?>>Karta płatnicza</option>
            <option value="crypto" <?php if ($_smarty_tpl->getValue('transaction')['payment_method'] == 'crypto') {?>selected<?php }?>>Kryptowaluta</option>
        </select>
    </div>

    <div class="row mb-3 align-items-end">
        <div class="col-md-3">
            <label for="amount" class="form-label fw-semibold">Kwota całkowita:</label>
            <input type="number" step="0.0001" min="0" class="form-control bg-dark text-light" id="amount" name="amount"
                value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['amount']), ENT_QUOTES, 'UTF-8');?>
" readonly>
        </div>

        <div class="col-md-3">
            <label for="currency" class="form-label fw-semibold">Waluta:</label>
            <select class="form-select bg-dark text-light" id="currency" name="currency" required>
                <option value="">Wybierz walutę...</option>
                <option value="PLN" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'PLN') {?>selected<?php }?>>PLN - Złoty</option>
                <option value="USD" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'USD') {?>selected<?php }?>>USD - Dolar amerykański</option>
                <option value="EUR" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'EUR') {?>selected<?php }?>>EUR - Euro</option>
                <option value="GBP" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'GBP') {?>selected<?php }?>>GBP - Funt brytyjski</option>
                <option value="CHF" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'CHF') {?>selected<?php }?>>CHF - Frank szwajcarski</option>
                <option value="CAD" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'CAD') {?>selected<?php }?>>CAD - Dolar kanadyjski</option>
                <option value="AUD" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'AUD') {?>selected<?php }?>>AUD - Dolar australijski</option>
                <option value="JPY" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'JPY') {?>selected<?php }?>>JPY - Jen japoński</option>
                <option value="CZK" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'CZK') {?>selected<?php }?>>CZK - Korona czeska</option>
                <option value="NOK" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'NOK') {?>selected<?php }?>>NOK - Korona norweska</option>
                <option value="BTC" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'BTC') {?>selected<?php }?>>BTC - Bitcoin</option>
                <option value="ETH" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'ETH') {?>selected<?php }?>>ETH - Ethereum</option>
                <option value="BNB" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'BNB') {?>selected<?php }?>>BNB - Binance Coin</option>
                <option value="XRP" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'XRP') {?>selected<?php }?>>XRP - Ripple</option>
                <option value="DOGE" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'DOGE') {?>selected<?php }?>>DOGE - Dogecoin</option>
                <option value="USDT" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'USDT') {?>selected<?php }?>>USDT - Tether</option>
                <option value="SOL" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'SOL') {?>selected<?php }?>>SOL - Solana</option>
                <option value="ADA" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'ADA') {?>selected<?php }?>>ADA - Cardano</option>
                <option value="TRX" <?php if ($_smarty_tpl->getValue('transaction')['currency'] == 'TRX') {?>selected<?php }?>>TRX - TRON</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Wartość w PLN:</label>
            <input type="text" id="convertedValue" class="form-control bg-dark text-success fw-semibold" readonly
                value="0.00 PLN">
        </div>
        <div class="col-md-3 text-center">
            <button type="button" id="refreshRates" class="btn btn-outline-light w-100">
                <i class="bi bi-arrow-repeat"></i> Odśwież kursy
            </button>
            <small id="lastUpdated" class="text-secondary d-block mt-1" style="font-size: 0.8rem;">Ładowanie...</small>
        </div>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_recurring" id="is_recurring" value="1"
            <?php if ($_smarty_tpl->getValue('transaction')['is_recurring']) {?>checked<?php }?>>
        <label class="form-check-label" for="is_recurring">
            Transakcja cykliczna
        </label>
    </div>

    <div class="d-flex justify-content-between">
        <a href="index.php?action=manageTransactions" class="btn btn-secondary fw-semibold">Anuluj</a>
        <button type="submit" class="btn btn-primary fw-semibold">Zapisz zmiany</button>
    </div>
</form>

<?php echo '<script'; ?>
>
    let rowIndex = <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('transactionItems'))), ENT_QUOTES, 'UTF-8');?>
;
    if (rowIndex === 0) rowIndex = 1;

    function updateTotal() {
        let total = 0;
        $('#transactionItems tbody tr').each(function() {
            let qty = parseFloat($(this).find('.itemQuantity').val()) || 0;
            let amount = parseFloat($(this).find('.itemAmount').val()) || 0;
            total += qty * amount;
        });
        $('#amount').val(total.toFixed(2));
        updateConversion();
    }

    function loadSubcategoriesForAllRows(categoryId) {
        if (!categoryId) {
            $('.subcategory-select').empty().append('<option value="">Wybierz podkategorię...</option>');
            return;
        }

        $.ajax({
            url: 'index.php?action=getSubcategoriesByCategory',
            method: 'GET',
            data: { category_id: categoryId },
            dataType: 'json',
            success: function(data) {
                $('.subcategory-select').each(function() {
                    const $select = $(this);
                    const currentValue = $select.val();
                    $select.empty().append('<option value="">Wybierz podkategorię...</option>');
                    if (data.length > 0) {
                        data.forEach(sub => {
                            $select.append('<option value="' + sub.id + '">' + sub.name +
                                '</option>');
                        });
                    } else {
                        $select.append('<option value="">Brak podkategorii</option>');
                    }
                    // Przywróć poprzednią wartość jeśli istnieje
                    if (currentValue) {
                        $select.val(currentValue);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Błąd pobierania podkategorii:', error);
                alert('Nie udało się pobrać podkategorii!');
            }
        });
    }

    $(document).ready(function() {
        // Inicjalizacja Select2
        $('#category_id, #subCategory_id').select2({
            theme: 'bootstrap-5',
            placeholder: "Wybierz kategorię",
            allowClear: true,
            width: '100%'
        });

        // Ładuj podkategorie dla wybranej kategorii przy starcie
        const initialCategoryId = $('#category_id').val();
        if (initialCategoryId) {
            loadSubcategoriesForAllRows(initialCategoryId);
        }

        $('#category_id').on('change', function() {
            const categoryId = $(this).val();
            loadSubcategoriesForAllRows(categoryId);
        });

        $('#addRow').click(function() {
            const categoryId = $('#category_id').val();
            let newRow = '<tr>' +
                '<td><select class="form-select subcategory-select" name="items[' + rowIndex +
                '][subcategory_id]" required>' +
                '<option value="">Wybierz podkategorię...</option>';

            if (categoryId) {
                $.ajax({
                    url: 'index.php?action=getSubcategoriesByCategory',
                    method: 'GET',
                    data: { category_id: categoryId },
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        if (data.length > 0) {
                            data.forEach(function(sub) {
                                newRow += '<option value="' + sub.id + '">' + sub
                                    .name + '</option>';
                            });
                        } else {
                            newRow += '<option value="">Brak podkategorii</option>';
                        }
                    },
                    error: function() {
                        newRow += '<option value="">Błąd ładowania</option>';
                    }
                });
            }

            newRow += '</select></td>' +
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

        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
            updateTotal();
        });

        $(document).on('input', '.itemQuantity, .itemAmount', function() {
            updateTotal();
        });

        // Inicjalna aktualizacja sumy
        updateTotal();
    });
<?php echo '</script'; ?>
>


    <?php echo '<script'; ?>
>
        // Waluty fiat i kryptowaluty
        const fiatCurrencies = {
            PLN: "PLN - Złoty",
            USD: "USD - Dolar amerykański",
            EUR: "EUR - Euro",
            GBP: "GBP - Funt brytyjski",
            CHF: "CHF - Frank szwajcarski",
            CAD: "CAD - Dolar kanadyjski",
            AUD: "AUD - Dolar australijski",
            JPY: "JPY - Jen japoński",
            CZK: "CZK - Korona czeska",
            NOK: "NOK - Korona norweska"
        };

        const cryptoCurrencies = {
            BTC: "BTC - Bitcoin",
            ETH: "ETH - Ethereum",
            BNB: "BNB - Binance Coin",
            XRP: "XRP - Ripple",
            DOGE: "DOGE - Dogecoin",
            USDT: "USDT - Tether",
            SOL: "SOL - Solana",
            ADA: "ADA - Cardano",
            TRX: "TRX - TRON"
        };

        const currencySelect = document.getElementById("currency");
        const paymentMethodSelect = document.getElementById("payment_method");
        const amountInput = document.getElementById("amount");
        const convertedValue = document.getElementById("convertedValue");
        const refreshRatesBtn = document.getElementById("refreshRates");
        const lastUpdated = document.getElementById("lastUpdated");

        let exchangeRates = {};

        // Funkcja odświeżania walut w select
        function updateCurrencyOptions() {
            const method = paymentMethodSelect.value;
            currencySelect.innerHTML = '<option value="">Wybierz walutę...</option>';
            let currencies = method === 'crypto' ? cryptoCurrencies : fiatCurrencies;
            for (const [code, label] of Object.entries(currencies)) {
                const option = document.createElement("option");
                option.value = code;
                option.textContent = label;
                currencySelect.appendChild(option);
            }

            // Ustaw aktualną walutę transakcji
            const currentCurrency = '<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['currency']), ENT_QUOTES, 'UTF-8');?>
';
            if (currentCurrency) {
                currencySelect.value = currentCurrency;
            }

            updateConversion();
        }

        // --- Pobranie kursów walut fiat z NBP ---
        async function fetchFiatRates() {
            try {
                const res = await fetch('https://api.nbp.pl/api/exchangerates/tables/A/?format=json');
                const data = await res.json();
                const rates = data[0].rates;

                exchangeRates['PLN'] = 1;
                rates.forEach(rate => {
                    const code = rate.code;
                    if (fiatCurrencies[code]) {
                        exchangeRates[code] = rate.mid;
                    }
                });

                // Dodaj brakujące waluty (dla USD, EUR itp.)
                if (!exchangeRates['USD']) exchangeRates['USD'] = 4.0;
                if (!exchangeRates['EUR']) exchangeRates['EUR'] = 4.5;
                if (!exchangeRates['GBP']) exchangeRates['GBP'] = 5.0;

                lastUpdated.textContent = "Ostatnia aktualizacja: " + new Date().toLocaleTimeString();
                updateConversion();
            } catch (err) {
                console.error("Błąd pobierania kursów fiat:", err);
                lastUpdated.textContent = "Nie udało się pobrać kursów!";
            }
        }

        // --- Pobranie kursów kryptowalut z CoinGecko ---
        async function fetchCryptoRates() {
            try {
                const ids = Object.values({
                    BTC: "bitcoin",
                    ETH: "ethereum",
                    BNB: "binancecoin",
                    XRP: "ripple",
                    DOGE: "dogecoin",
                    USDT: "tether",
                    SOL: "solana",
                    ADA: "cardano",
                    TRX: "tron"
                }).join(",");
                const res = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=' + ids +
                    '&vs_currencies=pln');
                const data = await res.json();
                for (const [code, id] of Object.entries({
                        BTC: "bitcoin",
                        ETH: "ethereum",
                        BNB: "binancecoin",
                        XRP: "ripple",
                        DOGE: "dogecoin",
                        USDT: "tether",
                        SOL: "solana",
                        ADA: "cardano",
                        TRX: "tron"
                    })) {
                    exchangeRates[code] = data[id] ? data[id].pln : 0;
                }
                lastUpdated.textContent = "Ostatnia aktualizacja: " + new Date().toLocaleTimeString();
                updateConversion();
            } catch (err) {
                console.error("Błąd pobierania kursów crypto:", err);
                lastUpdated.textContent = "Nie udało się pobrać kursów!";
            }
        }

        function updateConversion() {
            const amount = parseFloat(amountInput.value) || 0;
            const currency = currencySelect.value;
            const rate = exchangeRates[currency] || 0;

            if (currency === 'PLN') {
                convertedValue.value = amount.toFixed(2) + " PLN";
            } else if (rate > 0) {
                const converted = amount * rate;
                convertedValue.value = converted.toFixed(2) + " PLN";
            } else {
                convertedValue.value = "Brak kursu";
            }
        }

        // Eventy
        paymentMethodSelect.addEventListener("change", function() {
            updateCurrencyOptions();
            if (this.value === 'crypto') {
                fetchCryptoRates();
            } else {
                fetchFiatRates();
            }
        });

        currencySelect.addEventListener("change", updateConversion);
        amountInput.addEventListener("input", updateConversion);
        refreshRatesBtn.addEventListener("click", async function() {
            refreshRatesBtn.disabled = true;
            refreshRatesBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Odświeżanie...';

            if (paymentMethodSelect.value === 'crypto') {
                await fetchCryptoRates();
            } else {
                await fetchFiatRates();
            }

            refreshRatesBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Odśwież kursy';
            refreshRatesBtn.disabled = false;
        });

        // --- Pierwsze ładowanie ---
        updateCurrencyOptions();
        // Ustaw aktualną metodę płatności i załaduj odpowiednie kursy
        const currentPaymentMethod = '<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['payment_method']), ENT_QUOTES, 'UTF-8');?>
';
        if (currentPaymentMethod === 'crypto') {
            fetchCryptoRates();
        } else {
            fetchFiatRates();
        }
        // Wykonaj konwersję na starcie
        setTimeout(updateConversion, 500);
    <?php echo '</script'; ?>
>


<style>
    .select2-container--bootstrap-5 .select2-selection {
        background-color: #212529 !important;
        color: #f8f9fa !important;
        border: 1px solid #495057 !important;
        min-height: 38px;
        display: flex;
        align-items: center;
    }

    .select2-container--bootstrap-5 .select2-selection__rendered {
        color: #f8f9fa !important;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        background-color: #212529 !important;
        color: #f8f9fa !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: #495057 !important;
        color: #fff !important;
    }
</style>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
