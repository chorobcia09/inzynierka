{include file='header.tpl'}

<div class="container mt-5">
    <h2 class="mb-4 text-light-emphasis">Panel administratora</h2>

    <a href="index.php?action=addUserForm" class="btn btn-success mb-3">
        <i class="bi bi-person-plus"></i> Dodaj użytkownika
    </a>

    <div class="table-responsive shadow rounded bg-dark text-light p-3">
        <table class="table table-striped table-bordered table-dark mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>ID RODZINY</th>
                    <th>Imię</th>
                    <th>Email</th>
                    <th>Rodzaj konta</th>
                    <th>Rodzina</th>
                    <th>Rola</th>
                    <th>Rola w rodzinie</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$users item=user}
                    <tr>
                        <td>{$user.id}</td>
                        <td>{$user.family_id}</td>
                        <td>{$user.username}</td>
                        <td>{$user.email}</td>
                        <td>{$user.account_type}</td>
                        <td>{$user.family_name|default:'Brak'}</td>

                        <td>
                            {if $user.role == 'admin'}
                                <span class="badge bg-danger">Administrator</span>
                            {else}
                                <span class="badge bg-warning text-dark">Użytkownik</span>
                            {/if}
                        </td>
                        <td>
                            {if $user.family_role == 'family_admin'}
                                <span class="badge bg-success">Administrator rodziny</span>
                            {elseif $user.family_role == 'family_member'}
                                <span class="badge bg-primary">Członek rodziny</span>
                            {else}
                                <span class="badge bg-secondary text-dark">Brak przypisania</span>
                            {/if}
                        </td>
                        <td>
                            <a href="index.php?action=editUser&id={$user.id}" class="btn btn-sm btn-outline-light">
                                <i class="bi bi-pencil"></i> Edytuj
                            </a>
                            <a href="index.php?action=deleteUser&id={$user.id}" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                <i class="bi bi-trash"></i> Usuń
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>

{include file='footer.tpl'}