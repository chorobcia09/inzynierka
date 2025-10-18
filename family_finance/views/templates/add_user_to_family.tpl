{include file='header.tpl'}

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4 text-primary">Dodaj użytkownika do rodziny</h2>

    {if isset($error)}
        <div class="alert alert-danger">{$error}</div>
    {/if}

    {if isset($success)}
        <div class="alert alert-success">{$success}</div>
    {/if}

    <form method="POST" action="index.php?action=addUserToFamily">
        <div class="mb-3">
            <label for="UID" class="form-label">Kod UID użytkownika</label>
            <input type="text" class="form-control" id="UID" name="UID" placeholder="Wpisz kod UID" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Dodaj użytkownika</button>
    </form>
</div>

{include file='footer.tpl'}
