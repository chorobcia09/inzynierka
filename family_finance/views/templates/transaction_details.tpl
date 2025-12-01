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
                        {assign var=precision value=2}
                        {if in_array($trans.transaction_currency, ['BTC','ETH','BNB','XRP','DOGE','SOL','ADA','TRX','USDT'])}
                            {assign var=precision value=8}
                        {/if}
                        <tr>
                            <td>{$trans.sub_category_name}</td>
                            <td>{$trans.amount|number_format:$precision:",":" "} {$trans.transaction_currency}</td>
                            <td>{$trans.quantity}</td>
                            <td>{$line_total|number_format:$precision:",":" "} {$trans.transaction_currency}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>

            <table class="table table-dark table-bordered mt-2 mb-0">
                <tbody class="table-secondary text-dark">
                    <tr>
                        <td><strong>Suma:</strong> {$total|number_format:$precision:",":" "} {$transaction[0].transaction_currency}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-3 text-end">
                <button type="button" class="btn btn-info" id="showReceiptBtn"
                    data-transaction-id="{$transaction[0].transaction_id}">
                    <i class="bi bi-receipt"></i> Pokaż paragon
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiptModalLabel">Paragon</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="receiptImage" src="" class="img-fluid" alt="Paragon">
                        </div>
                    </div>
                </div>
            </div>

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

<script>
    $(document).ready(function() {
        $('#showReceiptBtn').click(function() {
            const transactionId = $(this).data('transaction-id');

            $.ajax({
                url: 'index.php?action=getTransactionReceiptAjax&id=' + transactionId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.receiptBase64) {
                        $('#receiptImage').attr('src', 'data:image/*;base64,' + response
                            .receiptBase64);
                        const receiptModal = new bootstrap.Modal(document.getElementById(
                            'receiptModal'));
                        receiptModal.show();
                    } else {
                        alert(response.error || 'Brak paragonu.');
                    }
                },
                error: function() {
                    alert('Błąd pobierania paragonu!');
                }
            });
        });
    });
</script>


{include file="footer.tpl"}