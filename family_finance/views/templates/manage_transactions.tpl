{include file="header.tpl"}

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="text-light fw-bold mb-3 mb-md-0">
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
        <div class="row g-3">
            {foreach from=$transactionsList item=transaction}
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card bg-dark text-light shadow-sm h-100 bg-dark-subtle">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title mb-2 {if $transaction.type == 'income'}text-success{else}text-danger{/if}">
                                    {if $transaction.type == 'income'}Przychód{else}Wydatek{/if} - 
                                    {$transaction.amount|number_format:2:",":" "} {$transaction.currency}
                                </h5>
                                <p class="card-text mb-1"><strong>Użytkownik:</strong> {$transaction.user_name}</p>
                                <p class="card-text mb-1"><strong>Kategoria:</strong> {$transaction.category_name}</p>
                                <p class="card-text mb-1"><strong>Płatność:</strong> 
                                    {if $transaction.payment_method == 'card'}Karta
                                    {elseif $transaction.payment_method == 'cash'}Gotówka
                                    {else}Krypto{/if}
                                </p>
                                <p class="card-text mb-1"><strong>Data transakcji:</strong> {$transaction.transaction_date}</p>
                                <p class="card-text mb-1"><strong>Data dodania:</strong> {$transaction.created_at|date_format:"%Y-%m-%d %H:%M"}</p>
                                <p class="card-text mb-1 text-truncate" title="{$transaction.description|default:'—'}">
                                    <strong>Opis:</strong> {$transaction.description|default:'—'}
                                </p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap mt-3">
                                <a href="index.php?action=transactionDetails&id={$transaction.transaction_id}" class="btn btn-outline-info btn-sm flex-grow-1">
                                    <i class="bi bi-eye"></i> Zobacz
                                </a>
                                {if $session.family_role == 'family_admin' || $session.family_id|default:false}
                                    <a href="index.php?action=editTransaction&id={$transaction.transaction_id}" class="btn btn-outline-warning btn-sm flex-grow-1">
                                        <i class="bi bi-pencil"></i> Edytuj
                                    </a>
                                    <a href="index.php?action=deleteTransaction&id={$transaction.transaction_id}" class="btn btn-outline-danger btn-sm flex-grow-1"
                                        onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                        <i class="bi bi-trash"></i> Usuń
                                    </a>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
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
    .card {
        border-radius: 1rem;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.3);
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .btn-outline-info, .btn-outline-warning, .btn-outline-danger {
        min-width: 80px;
    }

    @media (max-width: 576px) {
        .btn {
            flex-grow: 1;
            text-align: center;
        }
    }
</style>

{include file="footer.tpl"}
