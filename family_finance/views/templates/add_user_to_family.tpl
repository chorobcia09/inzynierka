{include file='header.tpl'}

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4 text-light-emphasis">Dodaj użytkownika do rodziny</h2>

    {if isset($error)}
        <div class="alert alert-danger">{ $error }</div>
    {/if}

    {if isset($success)}
        <div class="alert alert-success">{ $success }</div>
    {/if}

    <div class="alert alert-warning" role="alert">
        UWAGA! W MOMENCIE DODAWANIA UŻYTKOWNIKA DO RODZINY, KTÓRY POSIADA JUŻ JAKIEŚ TRANSAKCJE, JEGO TRANSAKCJE NIE
        ZOSTANĄ DODANE DO TRANSAKCJI RODZINNYCH!
    </div>

    <form method="POST" action="index.php?action=addUserToFamily" class="bg-dark p-4 rounded shadow-sm text-light">
        <div class="mb-3">
            <label for="UID" class="form-label">Kod UID użytkownika</label>
            <input type="text" class="form-control bg-secondary text-light border-0" id="UID" name="UID" placeholder="Wpisz kod UID" required>
        </div>
        <button type="submit" class="btn btn-outline-light w-100">Dodaj użytkownika</button>
    </form>
</div>

{include file='footer.tpl'}
