{include file='header.tpl'}

<div class="mx-auto shadow p-4 rounded bg-dark-subtle text-light" style="max-width:500px;">
    <h2 class="mb-4 text-center text-primary text-light">Edytuj użytkownika</h2>

    {* Wyświetl komunikat błędu *}
    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}

    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="username" class="form-label">Imię użytkownika</label>
            <input type="text" name="username" class="form-control bg-secondary text-light border-0"
                value="{$user.username}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control bg-secondary text-light border-0"
                value="{$user.email}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nowe hasło (pozostaw puste aby nie zmieniać)</label>
            <input type="password" name="password" class="form-control bg-secondary text-light border-0">
            <div class="form-text text-light">
                Wpisz nowe hasło tylko jeśli chcesz je zmienić.<br>
                Hasło musi mieć min. 8 znaków, zawierać cyfrę, dużą i małą literę oraz znak specjalny (!@#$%^&*()-_=+).
            </div>
        </div>

        <div class="mb-3">
            <label for="account_type" class="form-label">Typ konta</label>
            <select name="account_type" class="form-select bg-secondary text-light border-0">
                <option value="standard" {if $user.account_type == 'standard'}selected{/if}>Standard</option>
                <option value="premium" {if $user.account_type == 'premium'}selected{/if}>Premium</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            <a href="index.php?action=adminPanel" class="btn btn-secondary">Anuluj</a>
        </div>
    </form>
</div>

{include file='footer.tpl'}
