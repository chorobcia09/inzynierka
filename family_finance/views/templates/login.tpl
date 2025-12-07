{include file="header.tpl"}

<div class="login-container mx-auto shadow p-4 rounded bg-dark-subtle"
    style="max-width:400px;">
    <h2 class="text-center mb-4 fw-bold text-primary text-light ">Logowanie</h2>

    {if $error}
        <div class="alert alert-danger text-center bg-danger bg-opacity-25 border-0">{$error}</div>
    {/if}

    <form method="post" action="index.php?action=login">
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control rounded bg-secondary text-light border-0" name="email" id="email"
                placeholder="Wpisz email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Hasło</label>
            <input type="password" class="form-control rounded bg-secondary text-light border-0" name="password" id="password"
                placeholder="Wpisz hasło" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold">Zaloguj się</button>
    </form>

    <div class="text-center mt-3">
        <small>Nie masz konta? <a href="index.php?action=register" class="text-primary fw-bold">Zarejestruj się</a></small>
        <br>
        <small>Nie pamiętam hasła <a href="#" class="text-primary fw-bold">Przypomnij hasło</a></small>
    </div>
</div>

{include file="footer.tpl"}
