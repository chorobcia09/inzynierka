{include file='header.tpl'}

<h2 class="mb-4 text-primary">Panel administratora</h2>

<a href="index.php?action=addUserForm" class="btn btn-success mb-3">
    <i class="bi bi-person-plus"></i> Dodaj użytkownika
</a>

<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Email</th>
            <th>Rodzina</th>
            <th>Rola</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$users item=user}
            <tr>
                <td>{$user.id}</td>
                <td>{$user.username}</td>
                <td>{$user.email}</td>
                <td>{$user.family_name|default:'Brak'}</td>
                <td>{$user.role}</td>
                <td>
                    <a href="index.php?action=editUser&id={$user.id}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edytuj
                    </a>
                    <a href="index.php?action=deleteUser&id={$user.id}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                        <i class="bi bi-trash"></i> Usuń
                    </a>
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>

{include file='footer.tpl'}
