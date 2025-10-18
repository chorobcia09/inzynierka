{include file="header.tpl"}

<div class="users-container">
    <h2 class="mb-4 fw-bold text-primary">Lista członków rodziny</h2>
{if $session.family_role == 'family_admin'}
    <a href="index.php?action=addUserToFamily" class="btn btn-success mb-3">
        <i class="bi bi-person-plus"></i> Dodaj członka rodziny
    </a>
{/if}
    {if $users|@count > 0}
        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="table-primary">
                    <tr>
                        <th>Nazwa użytkownika</th>
                        <th>Email</th>
                        <th>Rodzina</th>
                        <th>Rola w rodzinie</th>
                        {if $session.family_role == 'family_admin'}
                            <th>Akcje</th>
                        {/if}
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$users item=user}
                        <tr>
                            <td>{$user.username}</td>
                            <td>{$user.email}</td>
                            <td>{$user.family_name|default:'Brak przydzielonej rodziny'}</td>
                            <td>
                                {if $user.family_role == 'family_admin'}
                                    <span class="badge bg-success">Administrator rodziny</span>
                                {elseif $user.family_role == 'family_member'}
                                    <span class="badge bg-primary">Członek rodziny</span>
                                {else}
                                    <span class="badge bg-secondary">Brak przypisania</span>
                                {/if}
                            </td>
                            {if $session.family_role == 'family_admin'}
                                <td>
                                    <a href="index.php?action=deleteUserFromFamily&id={$user.id}"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                        <i class="bi bi-trash"></i> Usuń członka rodziny</a>
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

    {if $session.family_role == 'family_admin'}
    <div class="mt-4 pt-3 border-top">
        <a href="index.php?action=deleteFamily" class="btn btn-danger" 
           onclick="return confirm('Czy na pewno chcesz usunąć całą rodzinę? Ta operacja jest nieodwracalna!');">
            <i class="bi bi-trash"></i> Usuń rodzinę
        </a>
    </div>
    {/if}
</div>

{include file="footer.tpl"}