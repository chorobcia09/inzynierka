{include file='header.tpl'}

<h2>Edytuj użytkownika</h2>

{* Wyświetl komunikat błędu *}
{if isset($error)}
    <div class="alert alert-danger">{$error}</div>
{/if}

<form method="post" class="mt-4">
    <div class="mb-3">
        <label for="username" class="form-label">Imię użytkownika</label>
        <input type="text" name="username" class="form-control" value="{$user.username}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{$user.email}" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Nowe hasło (pozostaw puste aby nie zmieniać)</label>
        <input type="password" name="password" class="form-control">
        <div class="form-text">Wpisz nowe hasło tylko jeśli chcesz je zmienić.</div>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Rola</label>
        <select name="role" class="form-select">
            <option value="member" {if $user.role == 'member'}selected{/if}>Użytkownik</option>
            <option value="admin" {if $user.role == 'admin'}selected{/if}>Administrator</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="family_id" class="form-label">ID Rodziny (opcjonalnie)</label>
        <input type="number" name="family_id" class="form-control" value="{$user.family_id}">
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        <a href="index.php?action=adminPanel" class="btn btn-secondary">Anuluj</a>
    </div>
</form>

{include file='footer.tpl'}