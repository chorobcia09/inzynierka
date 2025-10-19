{include file="header.tpl"}


<h2 class="mb-4 text-primary">Zarządzaj transakcjami</h2>

<a href="index.php?action=addTransaction" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Dodaj transakcję
</a>

{if $session.family_role == 'family_member' || $session.family_role == 'family_admin'}
    {if $transactions|@count > 0}
        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="table-primary">
                    <tr>
                        <th>Nazwa użytkownika</th>
                        <th>Kategoria</th>
                        <th>Typ</th>
                        <th>Wartość</th>
                        <th>Waluta</th>
                        <th>Forma płatności</th>
                        <th>Opis</th>
                        <th>Data transakcji</th>
                        <th>Cykliczność</th>
                        <th>Data dodania</th>
                        {if $session.family_role == 'family_admin'}
                            <th>Akcje</th>
                        {/if}
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$transactions item=transaction}
                        <tr class="{if $transaction.type == 'income'}table-success{else}table-danger{/if}">
                            <td>{$transaction.user_name}</td>
                            <td>{$transaction.category_name}</td>
                            <td>{if $transaction.type == 'income'}
                                    Przychód
                                {else}
                                    Wydatek
                                {/if}</td>
                            <td>{$transaction.amount}</td>
                            <td>{$transaction.currency}</td>
                            <td>{if $transaction.payment_method == 'card'}
                                    Karta płatnicza
                                {else if $transaction.payment_method == 'cash'}
                                    Gotówka
                                {else}
                                    Kryptowaluta
                                {/if}</td>
                            <td>{$transaction.description}</td>
                            <td>{$transaction.transaction_date}</td>
                            <td>{if $transaction.is_recurring == 1}
                                Tak{else} Nie
                                {/if}</td>
                            <td>{$transaction.created_at|date_format:"%Y-%m-%d %H:%M:%S"}</td>


                            {if $session.family_role == 'family_admin'}
                                <td>
                                    <a href="{$transaction.transaction_id}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edytuj
                                    </a>
                                    <a href="{$transaction.transaction_id}" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                        <i class="bi bi-trash"></i> Usuń
                                    </a>
                                </td>
                            {/if}
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {else}
        <div class="alert alert-info text-center mt-3">Brak przypisanych członków do rodziny.</div>
    {/if}
{else}
    {if $transactionsUser|@count > 0}
        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="table-primary">
                    <tr>
                        <th>Nazwa użytkownika</th>
                        <th>Kategoria</th>
                        <th>Typ</th>
                        <th>Wartość</th>
                        <th>Waluta</th>
                        <th>Forma płatności</th>
                        <th>Opis</th>
                        <th>Data transakcji</th>
                        <th>Cykliczność</th>
                        <th>Data dodania</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$transactionsUser item=transaction}
                        <tr class="{if $transaction.type == 'income'}table-success{else}table-danger{/if}">
                            <td>{$transaction.user_name}</td>
                            <td>{$transaction.category_name}</td>
                            <td>{if $transaction.type == 'income'}
                                    Przychód
                                {else}
                                    Wydatek
                                {/if}</td>
                            <td>{$transaction.amount}</td>
                            <td>{$transaction.currency}</td>
                            <td>{if $transaction.payment_method == 'card'}
                                    Karta płatnicza
                                {else if $transaction.payment_method == 'cash'}
                                    Gotówka
                                {else}
                                    Kryptowaluta
                                {/if}</td>
                            <td>{$transaction.description}</td>
                            <td>{$transaction.transaction_date}</td>
                            <td>{if $transaction.is_recurring == 1}
                                Tak{else} Nie
                                {/if}</td>
                            <td>{$transaction.created_at|date_format:"%Y-%m-%d %H:%M:%S"}</td>


                            <td>
                                <a href="{$transaction.transaction_id}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edytuj
                                </a>
                                <a href="{$transaction.transaction_id}" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                    <i class="bi bi-trash"></i> Usuń
                                </a>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {else}
        <div class="alert alert-info text-center mt-3">Brak transakcji w bazie danych.</div>
    {/if}
{/if}

{include file="footer.tpl"}