{include file="header.tpl"}

<style>
    /* Styl dla responsywności bez scrolla */
    .custom-table-container {
        overflow: hidden;
    }

    /* Ukrywanie tekstu "Usuń" na małych ekranach (poniżej 576px) */
    @media (max-width: 576px) {
        .btn-text {
            display: none;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.25rem !important;
            font-size: 0.85rem;
        }

        /* Styl dla badge roli na małych ekranach */
        .role-badge {
            font-size: 0.75rem;
            padding: 0.2rem 0.4rem;
            white-space: nowrap;
        }
    }

    /* Styl dla badge roli na większych ekranach */
    @media (min-width: 577px) {
        .role-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>

<div class="users-container bg-dark text-light p-4 rounded shadow bg-dark-subtle">
    <h2 class="mb-4 fw-bold text-primary text-light">Lista członków rodziny</h2>

    {if isset($session.error)}
        <div class="alert alert-danger">
            {$session.error}
        </div>
    {/if}

    {if $session.family_role == 'family_admin'}
        <a href="index.php?action=addUserToFamily" class="btn btn-success mb-3">
            <i class="bi bi-person-plus"></i> Dodaj członka rodziny
        </a>
    {/if}

    {if $users|@count > 0}
        <div class="shadow rounded custom-table-container">
            <table class="table table-dark table-bordered mb-0">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Użytkownik</th>
                        <th class="d-none d-md-table-cell">Rodzina</th>
                        <th>Rola</th>
                        {if $session.family_role == 'family_admin'}
                            <th style="width: 50px;">Akcja</th>
                        {/if}
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$users item=user}
                        <tr>
                            <td class="text-break fw-bold">{$user.username}</td>
                            <td class="text-break d-none d-md-table-cell">{$user.family_name|default:'-'}</td>
                            <td>
                                {if $user.family_role == 'family_admin'}
                                    <span class="badge bg-success role-badge">Administrator rodziny</span>
                                {else}
                                    <span class="badge bg-primary role-badge">Członek rodziny</span>
                                {/if}
                            </td>
                            {if $session.family_role == 'family_admin'}
                                <td class="text-center">
                                    <a href="index.php?action=deleteUserFromFamily&id={$user.id}"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');"
                                        title="Usuń członka rodziny">
                                        <i class="bi bi-trash"></i><span class="btn-text ms-1">Usuń</span>
                                    </a>
                                </td>
                            {/if}
                        </tr>

                    {/foreach}
                <tfoot class="d-md-none">
                    <tr>
                        <td colspan="{if $session.family_role == 'family_admin'}5{else}4{/if}"
                            class="text-center small text-muted pt-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Rodzina: <strong>{$session.family_name|default:'Brak'}</strong>
                        </td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    {else}
        <div class="alert alert-info text-center mt-3 bg-info bg-opacity-25 border-0 text-dark">
            Brak przypisanych członków do rodziny.
        </div>
    {/if}

    {if $session.family_role == 'family_admin'}
        <div class="mt-4 pt-3 border-top border-secondary">
            <a href="index.php?action=deleteFamily" class="btn btn-danger"
                onclick="return confirm('Czy na pewno chcesz usunąć całą rodzinę? Ta operacja jest nieodwracalna!');">
                <i class="bi bi-trash"></i> Usuń rodzinę
            </a>
        </div>
    {/if}
</div>

{include file="footer.tpl"}