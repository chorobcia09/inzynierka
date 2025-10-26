{include file='header.tpl'}

<div class="user-panel-container mx-auto shadow-lg p-4 rounded-4 bg-dark-subtle text-light"
    style="max-width:600px;">
    <h2 class="text-center mb-4 fw-bold text-light-emphasis">Panel użytkownika</h2>

    <ul class="list-group list-group-flush rounded-3 overflow-hidden">
        <li class="list-group-item bg-dark text-light"><strong>Nazwa użytkownika:</strong> {$user.username}</li>
        <li class="list-group-item bg-dark text-light"><strong>Email:</strong> {$user.email}</li>
        <li class="list-group-item bg-dark text-light">
            <strong>Rodzina:</strong> {$user.family_name|default:'Brak przypisanej rodziny'}
        </li>
        <li class="list-group-item bg-dark text-light">
            <strong>Rola:</strong>
            {if $user.family_role == 'family_admin'}
                <span class="badge bg-success bg-opacity-75">Administrator rodziny</span>
            {elseif $user.family_role == 'family_member'}
                <span class="badge bg-primary bg-opacity-75">Członek rodziny</span>
            {else}
                <span class="badge bg-secondary bg-opacity-75">Brak przypisania</span>
            {/if}
        </li>
        <li class="list-group-item bg-dark text-light"><strong>Rodzaj konta:</strong>
            {$user.account_type|default:'Brak'}</li>
        <li class="list-group-item bg-dark text-light"><strong>UID:</strong> {$user.UID}</li>
    </ul>

    <div class="text-center mt-4">
        <a href="index.php?action=dashboard" class="btn btn-light text-dark fw-semibold me-2">Dashboard</a>
        <a href="index.php?action=usersFamily" class="btn btn-outline-light fw-semibold">Członkowie rodziny</a>
    </div>
</div>

{include file='footer.tpl'}