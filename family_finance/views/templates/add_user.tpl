{include file='header.tpl'}

<div class="mx-auto mt-5 p-4 rounded border-form bg-dark-subtle text-light" style="max-width:500px;">
    <!-- Nagłówek wewnątrz karty -->
    <h2 class="text-center mb-4 text-light-emphasis">Dodaj użytkownika</h2>

    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}

    <form method="post" class="mt-2">
        <div class="mb-3">
            <label for="username" class="form-label">Imię użytkownika</label>
            <input type="text" name="username" class="form-control bg-secondary text-light border-0"
                   value="{$smarty.post.username|default:''}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control bg-secondary text-light border-0"
                   value="{$smarty.post.email|default:''}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Hasło</label>
            <input type="password" name="password" class="form-control bg-secondary text-light border-0" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rola</label>
            <select name="role" class="form-select bg-secondary text-light border-0">
                <option value="member">Użytkownik</option>
                <option value="admin">Administrator</option>
            </select>
        </div>

        <button type="submit" class="btn btn-outline-light w-100">Zapisz</button>
    </form>
</div>


{include file='footer.tpl'}
