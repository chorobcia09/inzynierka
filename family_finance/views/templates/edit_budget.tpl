{include file="header.tpl"}

<div class="container my-5">
    <div class="p-4 bg-dark-subtle text-light rounded-4 shadow-lg">

        <h2 class="mb-4 fw-bold text-light-emphasis">
            <i class="bi bi-pencil-square me-2"></i>Edytuj budżet: {$budget.name}
        </h2>

        {if isset($error)}
            <div class="alert alert-danger">{$error}</div>
        {/if}
        {if isset($success)}
            <div class="alert alert-success">{$success nofilter}</div>
        {/if}

        <form method="post" action="index.php?action=editBudget&id={$budget_id}" id="budgetForm">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nazwa budżetu:</label>
                <input type="text" name="name" class="form-control bg-dark text-light border-secondary"
                    value="{$budget.name}" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Typ okresu:</label>
                    <select name="period_type" class="form-select bg-dark text-light border-secondary" required>
                        <option value="custom" {if $budget.period_type == 'custom'}selected{/if}>Niestandardowy</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data początkowa:</label>
                    <input type="date" name="start_date" class="form-control bg-dark text-light border-secondary"
                        value="{$budget.start_date}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data końcowa:</label>
                    <input type="date" name="end_date" class="form-control bg-dark text-light border-secondary"
                        value="{$budget.end_date}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Waluta:</label>
                    <select class="form-select bg-dark text-light" name="currency" required>
                        <option value="PLN" {if $budget.currency == 'PLN'}selected{/if}>PLN - Złoty</option>
                        <option value="USD" {if $budget.currency == 'USD'}selected{/if}>USD - Dolar amerykański</option>
                        <option value="EUR" {if $budget.currency == 'EUR'}selected{/if}>EUR - Euro</option>
                        <option value="GBP" {if $budget.currency == 'GBP'}selected{/if}>GBP - Funt brytyjski</option>
                        <option value="CHF" {if $budget.currency == 'CHF'}selected{/if}>CHF - Frank szwajcarski</option>
                        <option value="CAD" {if $budget.currency == 'CAD'}selected{/if}>CAD - Dolar kanadyjski</option>
                        <option value="AUD" {if $budget.currency == 'AUD'}selected{/if}>AUD - Dolar australijski</option>
                        <option value="JPY" {if $budget.currency == 'JPY'}selected{/if}>JPY - Jen japoński</option>
                        <option value="CZK" {if $budget.currency == 'CZK'}selected{/if}>CZK - Korona czeska</option>
                        <option value="NOK" {if $budget.currency == 'NOK'}selected{/if}>NOK - Korona norweska</option>
                        <option value="BTC" {if $budget.currency == 'BTC'}selected{/if}>BTC - Bitcoin</option>
                        <option value="ETH" {if $budget.currency == 'ETH'}selected{/if}>ETH - Ethereum</option>
                        <option value="BNB" {if $budget.currency == 'BNB'}selected{/if}>BNB - Binance Coin</option>
                        <option value="XRP" {if $budget.currency == 'XRP'}selected{/if}>XRP - Ripple</option>
                        <option value="DOGE" {if $budget.currency == 'DOGE'}selected{/if}>DOGE - Dogecoin</option>
                        <option value="USDT" {if $budget.currency == 'USDT'}selected{/if}>USDT - Tether</option>
                        <option value="SOL" {if $budget.currency == 'SOL'}selected{/if}>SOL - Solana</option>
                        <option value="ADA" {if $budget.currency == 'ADA'}selected{/if}>ADA - Cardano</option>
                        <option value="TRX" {if $budget.currency == 'TRX'}selected{/if}>TRX - TRON</option>
                    </select>
                </div>
            </div>

            <hr class="my-4 border-secondary">
            <h4 class="mb-3 text-light-emphasis fw-bold">
                <i class="bi bi-pie-chart-fill me-2"></i>Limity w kategoriach
            </h4>

            <div id="categories-container">
                {foreach $budgetItems as $i => $item}
                    <div class="row mb-3 align-items-center category-row bg-dark p-3 rounded-3 shadow-sm">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategoria:</label>
                            <select class="form-select bg-dark text-light border-secondary"
                                name="categories[{$i}][category_id]" required>
                                <option value="">Wybierz kategorię...</option>
                                {foreach $categories as $category}
                                    <option value="{$category.id}" {if $category.id == $item.category_id}selected{/if}>
                                        {$category.name}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Limit kategorii:</label>
                            <input type="number" step="0.01" name="categories[{$i}][limit_amount]"
                                class="form-control bg-dark text-light border-secondary" 
                                value="{$item.limit_amount}" required>
                        </div>
                    </div>
                {/foreach}
            </div>

            {* <button type="button" class="btn btn-outline-info mb-4" id="add-category">
                <i class="bi bi-plus-circle me-2"></i>Dodaj kolejną kategorię
            </button> *}

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

{literal}
<script>
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
</script>
{/literal}

{include file="footer.tpl"}