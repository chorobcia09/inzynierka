{include file='header.tpl'}

<div class="user-panel-container mx-auto shadow p-4 rounded" style="max-width:600px; font-family: 'Inter', sans-serif; background-color: #ffffff;">
    <h2 class="text-center mb-4 fw-bold text-primary">Panel użytkownika</h2>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Imię:</strong> {$user.username}</li>
        <li class="list-group-item"><strong>Email:</strong> {$user.email}</li>
        <li class="list-group-item"><strong>Rodzina:</strong> {$user.family_name|default:'Brak przypisanej rodziny'}</li>
        <li class="list-group-item"><strong>Rola:</strong> {$user.role}</li>
        <li class="list-group-item"><strong>Rodzaj konta:</strong> {$user.account_type|default:'Brak'}</li>
    </ul>

    <div class="text-center mt-4">
        <a href="index.php?action=dashboard" class="btn btn-primary me-2">Dashboard</a>
        <a href="index.php?action=users" class="btn btn-outline-primary">Lista użytkowników</a>
    </div>
</div>

{include file='footer.tpl'}
