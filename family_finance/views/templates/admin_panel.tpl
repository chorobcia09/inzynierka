{include file='header.tpl'}

<style>
    .table-wrapper {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.45);
    }

    .table-scroll {
        overflow-x: auto;
    }
</style>

<div class="container mt-5">

    <h2 class="mb-4 text-light-emphasis">Panel administratora</h2>

    <a href="index.php?action=addUserForm" class="btn btn-success mb-4">
        <i class="bi bi-person-plus"></i> Dodaj użytkownika
    </a>

    <div class="table-wrapper">
        <div class="table-scroll">
            <table class="table table-dark table-striped align-middle mb-0 rounded-4">

                <thead class="table-success text-dark">
                    <tr>
                        <th>ID</th>
                        <th>ID Rodziny</th>
                        <th>Imię</th>
                        <th>Email</th>
                        <th>Rodzaj konta</th>
                        <th>Rodzina</th>
                        <th>Rola</th>
                        <th>Rola w rodzinie</th>
                        <th class="text-center">Akcje</th>
                    </tr>
                </thead>

                <tbody>
                    {foreach from=$users item=user}
                        <tr>
                            <td>{$user.id}</td>
                            <td>{$user.family_id}</td>
                            <td class="fw-semibold">{$user.username}</td>
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
                                    <span class="badge bg-secondary text-dark">Brak</span>
                                {/if}
                            </td>

                            <td class="text-center">
                                <a href="index.php?action=editUser&id={$user.id}"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="index.php?action=deleteUser&id={$user.id}" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>

                        </tr>
                    {/foreach}
                </tbody>

            </table>

        </div>
    </div>

{include file='footer.tpl'}