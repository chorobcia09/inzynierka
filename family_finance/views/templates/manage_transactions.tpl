{include file="header.tpl"}

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-light fw-bold">
            <i class="bi bi-credit-card-2-front me-2 text-success"></i> Twoje transakcje
        </h2>
        <a href="index.php?action=addTransaction" class="btn btn-success rounded-pill px-4 shadow-sm fw-semibold">
            <i class="bi bi-plus-circle me-2"></i> Dodaj transakcję
        </a>
    </div>

    {if $session.family_role == 'family_member' || $session.family_role == 'family_admin'}
        {assign var=transactionsList value=$transactions}
    {else}
        {assign var=transactionsList value=$transactionsUser}
    {/if}

    {if $transactionsList|@count > 0}
        <div class="table-responsive shadow-lg rounded-4 overflow-hidden">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="bg-gradient bg-dark text-light small text-uppercase">
                    <tr>
                        <th class="text-nowrap"><i class="bi bi-person me-1 small"></i>Użytkownik</th>
                        <th class="text-nowrap"><i class="bi bi-tag me-1 small"></i>Kategoria</th>
                        <th class="text-nowrap"><i class="bi bi-arrow-left-right me-1 small"></i>Typ</th>
                        <th class="text-nowrap"><i class="bi bi-cash-stack me-1 small"></i>Kwota</th>
                        <th class="text-nowrap"><i class="bi bi-currency-exchange me-1 small"></i>Waluta</th>
                        <th class="text-nowrap"><i class="bi bi-wallet2 me-1 small"></i>Płatność</th>
                        <th class="text-nowrap"><i class="bi bi-pencil-square me-1 small"></i>Opis</th>
                        <th class="text-nowrap"><i class="bi bi-calendar-event me-1 small"></i>Data</th>
                        <th class="text-nowrap"><i class="bi bi-repeat me-1 small"></i>Cykliczność</th>
                        <th class="text-nowrap"><i class="bi bi-clock me-1 small"></i>Dodano</th>
                        <th class="text-nowrap"><i class="bi bi-eye me-1 small"></i>Szczegóły</th>
                        {if $session.family_role == 'family_admin' || !$session.family_id}
                            <th class="text-nowrap"><i class="bi bi-gear me-1 small"></i>Akcje</th>
                        {/if}
                    </tr>
                </thead>

                <tbody>
                    {foreach from=$transactionsList item=transaction}
                        <tr class="transition">
                            <td>{$transaction.user_name}</td>
                            <td><span class="badge bg-info text-dark px-3 py-2">{$transaction.category_name}</span></td>
                            <td>
                                {if $transaction.type == 'income'}
                                    <span class="badge bg-success px-3 py-2">Przychód</span>
                                {else}
                                    <span class="badge bg-danger px-3 py-2">Wydatek</span>
                                {/if}
                            </td>
                            <td class="fw-bold text-light">
                                {$transaction.amount|number_format:2:",":" "}
                            </td>
                            <td>{$transaction.currency}</td>
                            <td>
                                {if $transaction.payment_method == 'card'}
                                    <i class="bi bi-credit-card text-warning"></i> Karta
                                {elseif $transaction.payment_method == 'cash'}
                                    <i class="bi bi-cash text-success"></i> Gotówka
                                {else}
                                    <i class="bi bi-coin text-info"></i> Krypto
                                {/if}
                            </td>
                            <td class="text-muted">{$transaction.description|default:'—'}</td>
                            <td>{$transaction.transaction_date}</td>
                            <td>
                                {if $transaction.is_recurring == 1}
                                    <span class="badge bg-primary">Tak</span>
                                {else}
                                    <span class="badge bg-secondary">Nie</span>
                                {/if}
                            </td>
                            <td>{$transaction.created_at|date_format:"%Y-%m-%d %H:%M"}</td>
                            <td>
                                <a href="index.php?action=transactionDetails&id={$transaction.transaction_id}"
                                    class="btn btn-outline-info btn-sm rounded-pill px-3">
                                    <i class="bi bi-eye"></i> Zobacz
                                </a>
                            </td>
                            {if $session.family_role == 'family_admin' || !$session.family_id}
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="index.php?action=editTransaction&id={$transaction.transaction_id}"
                                            class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="index.php?action=deleteTransaction&id={$transaction.transaction_id}"
                                            class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                            onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            {/if}
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {else}
        <div class="text-center text-light mt-5">
            <i class="bi bi-inbox display-1 text-secondary"></i>
            <p class="lead mt-3">Nie znaleziono żadnych transakcji.</p>
            <a href="index.php?action=addTransaction" class="btn btn-outline-light rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i> Dodaj pierwszą transakcję
            </a>
        </div>
    {/if}
</div>

<style>
    .table-dark {
        background-color: #1e1e2f !important;
    }

    .table-dark tbody tr:hover {
        background-color: #2c2c3f !important;
        transition: 0.3s;
    }

    .transition {
        transition: all 0.2s ease-in-out;
    }

    .transition:hover {
        transform: scale(1.01);
    }

    .bg-gradient {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
    }
</style>

{include file="footer.tpl"}