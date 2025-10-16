{include file="header.tpl"}

<div class="users-container">
    <h2 class="mb-4 fw-bold text-primary">Lista użytkowników</h2>

    {if $users|@count > 0}
    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Email</th>
                    <th>Rodzina</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$users item=user}
                <tr>
                    <td>{$user.id}</td>
                    <td>{$user.username}</td>
                    <td>{$user.email}</td>
                    <td>{$user.family_name|default:'Brak przydzielonej rodziny'}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    {else}
        <div class="alert alert-info text-center mt-3">Brak użytkowników w bazie danych.</div>
    {/if}
</div>

{include file="footer.tpl"}
