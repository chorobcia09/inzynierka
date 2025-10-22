{include file="header.tpl"}
<div class="container mt-4">
    <h2 class="mb-4 text-primary">Szczegóły transakcji</h2>

    {if $transaction|@count > 0}
        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="table-primary">
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
                        {math equation="total + line" total=$total line=$line_total assign="total"}
                        <tr>
                            <td>{$trans.sub_category_name}</td>
                            <td>{$trans.amount} {$trans.transaction_currency}</td>
                            <td>{$trans.quantity}</td>
                            <td>{$line_total} {$trans.transaction_currency}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>

            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <tbody class="table-info">
                    <tr>
                        <td><strong>Suma:</strong> {$total} {$trans.transaction_currency}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-2">
            <a href="index.php?action=manageTransactions" class="btn btn-secondary">
                <i class="bi bi-arrow-90deg-left"></i> Wróć
            </a>
        </div>

    {else}
        <div class="alert alert-info text-center mt-3">Brak szczegółow transakcji.</div>
    {/if}
</div>
{include file="footer.tpl"}