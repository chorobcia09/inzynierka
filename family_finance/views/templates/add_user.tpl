{include file='header.tpl'}

<h2>Dodaj użytkownika</h2>

{if isset($error)}
    <div class="alert alert-danger">{$error}</div>
{/if}

<form method="post" class="mt-4">
    <div class="mb-3">
        <label for="username" class="form-label">Imię użytkownika</label>
        <input type="text" name="username" class="form-control" value="{$smarty.post.username|default:''}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{$smarty.post.email|default:''}" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Hasło</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Rola</label>
        <select name="role" class="form-select">
            <option value="member">Użytkownik</option>
            <option value="admin">Administrator</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Zapisz</button>
</form>

{include file='footer.tpl'}