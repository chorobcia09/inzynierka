{include file="header.tpl"}

<div class="register-container mx-auto shadow p-4 rounded" style="max-width:400px;">
    <h2 class="text-center mb-4">Rejestracja</h2>

    {if $error}
        <div class="alert alert-danger text-center">{$error}</div>
    {/if}

    <form method="post" action="index.php?action=register">
        <div class="mb-3">
            <label for="username" class="form-label">Imię użytkownika</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Hasło</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirm" class="form-label">Powtórz hasło</label>
            <input type="password" class="form-control" name="password_confirm" id="password_confirm" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Zarejestruj się</button>
    </form>
</div>

{include file="footer.tpl"}
