{include file='header.tpl'}
{if $success}
    <div class="alert alert-success text-center">{$success}</div>
{/if}

{if $error}
    <div class="alert alert-danger text-center">{$error}</div>
{/if}

<div class="user-panel-container mx-auto shadow-lg p-4 rounded-4 bg-dark-subtle text-light" style="max-width:600px;">
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

        <!-- UID z przyciskami -->
        <li
            class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <strong>UID:</strong>
                <span id="uidValue" class="text-monospace">•••••••••••••••</span>
            </div>
            <div class="d-flex gap-2">
                <button type="button" id="toggleUid" class="btn btn-sm btn-outline-light fw-semibold">
                    <i class="bi bi-eye"></i> Pokaż
                </button>
                <button type="button" id="copyUid" class="btn btn-sm btn-outline-success fw-semibold">
                    <i class="bi bi-clipboard"></i> Kopiuj
                </button>
            </div>
        </li>

    </ul>

    {if $user.account_type != 'premium'}
        <div class="text-center mt-3">
            <form method="post" action="index.php?action=upgradeToPremium">
                <button type="submit" class="btn btn-warning fw-semibold">
                    Przejdź na konto Premium
                </button>
            </form>
        </div>
    {/if}


    <div class="text-center mt-4">
        <a href="index.php?action=dashboard" class="btn btn-light text-dark fw-semibold me-2">Dashboard</a>
        <a href="index.php?action=usersFamily" class="btn btn-outline-light fw-semibold">Członkowie rodziny</a>
        <a href="index.php?action=changePassword" class="btn btn-outline-warning fw-semibold">Zmień hasło</a>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const uidElement = document.getElementById('uidValue');
        const toggleButton = document.getElementById('toggleUid');
        const copyButton = document.getElementById('copyUid');
        const realUid = '{$user.UID}';
        let isVisible = false;

        toggleButton.addEventListener('click', () => {
            if (isVisible) {
                uidElement.textContent = '•••••••••••••••';
                toggleButton.innerHTML = '<i class="bi bi-eye"></i> Pokaż';
            } else {
                uidElement.textContent = realUid;
                toggleButton.innerHTML = '<i class="bi bi-eye-slash"></i> Ukryj';
            }
            isVisible = !isVisible;
        });

        copyButton.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(realUid);
                copyButton.innerHTML = '<i class="bi bi-check-lg"></i> Skopiowano!';
                copyButton.classList.remove('btn-outline-success');
                copyButton.classList.add('btn-success');
                setTimeout(() => {
                    copyButton.innerHTML = '<i class="bi bi-clipboard"></i> Kopiuj';
                    copyButton.classList.remove('btn-success');
                    copyButton.classList.add('btn-outline-success');
                }, 2000);
            } catch (err) {
                alert('Nie udało się skopiować UID');
            }
        });
    });
</script>

<style>
    .text-monospace {
        font-family: monospace;
        letter-spacing: 0.1rem;
    }

    #toggleUid,
    #copyUid {
        transition: all 0.2s ease-in-out;
    }

    #toggleUid:hover,
    #copyUid:hover {
        transform: translateY(-2px);
    }
</style>

{include file='footer.tpl'}