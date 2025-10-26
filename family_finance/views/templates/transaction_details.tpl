{include file="header.tpl"}

<div class="container mt-4">
    <h2 class="mb-4 text-primary text-light">Szczegóły transakcji</h2>

    {if $transaction|@count > 0}
        <div class="table-responsive shadow rounded bg-dark p-3 text-light">
            <table class="table table-dark table-bordered mb-0">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Podkategoria</th>
                        <th>Cena za szt.</th>
                        <th>Ilość</th>
                        <th>Wartość</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var="total" value=0}
                    {foreach from=$transaction item=trans}
                        {assign var="line_total" value=$trans.amount * $trans.quantity}
                        {assign var="total" value=$total + $line_total}
                        <tr>
                            <td>{$trans.sub_category_name}</td>
                            <td>{$trans.amount} {$trans.transaction_currency}</td>
                            <td>{$trans.quantity}</td>
                            <td>{$line_total} {$trans.transaction_currency}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>

            <table class="table table-dark table-bordered mt-2 mb-0">
                <tbody class="table-secondary text-dark">
                    <tr>
                        <td><strong>Suma:</strong> {$total} {$transaction[0].transaction_currency}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <a href="index.php?action=manageTransactions" class="btn btn-secondary">
                <i class="bi bi-arrow-90deg-left"></i> Wróć
            </a>
        </div>

    {else}
        <div class="alert alert-info text-center mt-3">Brak szczegółów transakcji.</div>
    {/if}
</div>

{include file="footer.tpl"}
