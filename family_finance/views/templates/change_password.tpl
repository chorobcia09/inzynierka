{include file='header.tpl'}

<div class="container py-5" style="max-width: 600px;">
    <div class="card bg-dark-subtle text-light shadow-lg p-4 rounded-4">
        <h3 class="text-center mb-4 fw-bold text-light-emphasis">
            <i class="bi bi-lock-fill me-2"></i> Zmień hasło
        </h3>

        {if isset($success)}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {$success}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        {/if}

        {if isset($errors) && $errors|@count > 0}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    {foreach $errors as $error}
                        <li>{$error}</li>
                    {/foreach}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        {/if}

        <form method="POST" action="index.php?action=changePassword">
            <div class="mb-3">
                <label for="current_password" class="form-label fw-semibold">Aktualne hasło:</label>
                <input type="password" class="form-control bg-dark text-light" id="current_password" name="current_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label fw-semibold">Nowe hasło:</label>
                <input type="password" class="form-control bg-dark text-light" id="new_password" name="new_password" required>
                <div class="form-text text-light-emphasis">Hasło musi mieć co najmniej 8 znaków.</div>
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="form-label fw-semibold">Potwierdź nowe hasło:</label>
                <input type="password" class="form-control bg-dark text-light" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php?action=panel" class="btn btn-outline-light fw-semibold">
                    <i class="bi bi-arrow-left"></i> Powrót
                </a>
                <button type="submit" class="btn btn-success fw-semibold">
                    <i class="bi bi-save"></i> Zapisz zmiany
                </button>
            </div>
        </form>
    </div>
</div>

{include file='footer.tpl'}
