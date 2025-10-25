{include file="header.tpl"}

<div class="register-container mx-auto shadow p-4 rounded"
    style="max-width:400px; font-family: 'Inter', sans-serif; background-color: #212529; color: #f8f9fa;">
    <h2 class="text-center mb-4 fw-bold text-primary text-light">Rejestracja</h2>

    {if $error}
        <div class="alert alert-danger text-center bg-danger bg-opacity-25 border-0">{$error}</div>
    {/if}

    <form method="post" action="index.php?action=register">
        <div class="mb-3">
            <label for="username" class="form-label fw-semibold">Imię użytkownika</label>
            <input type="text" class="form-control rounded bg-secondary text-light border-0" name="username"
                id="username" placeholder="Wpisz nazwę użytkownika" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control rounded bg-secondary text-light border-0" name="email" id="email"
                placeholder="Wpisz email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Hasło</label>
            <input type="password" class="form-control rounded bg-secondary text-light border-0" name="password"
                id="password" placeholder="Wpisz hasło" required>
        </div>

        <div class="mb-3">
            <label for="password_confirm" class="form-label fw-semibold">Powtórz hasło</label>
            <input type="password" class="form-control rounded bg-secondary text-light border-0" name="password_confirm"
                id="password_confirm" placeholder="Powtórz hasło" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold">Zarejestruj się</button>
    </form>

    <div class="text-center mt-3">
        <small>Masz już konto? <a href="index.php?action=login" class="text-primary fw-bold">Zaloguj się</a></small>
    </div>
</div>

{include file="footer.tpl"}