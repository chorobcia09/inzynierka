{include file="header.tpl"}

<h2 class="mb-4">Lista użytkowników</h2>

{if $users|@count > 0}
<table class="table table-striped table-bordered">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Email</th>
            <th>ID Rodziny</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$users item=user}
        <tr>
            <td>{$user.id}</td>
            <td>{$user.username}</td>
            <td>{$user.email}</td>
            <td>{$user.family_id}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
{else}
    <div class="alert alert-info">Brak użytkowników w bazie danych.</div>
{/if}

{include file="footer.tpl"}
