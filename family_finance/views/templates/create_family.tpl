{include file='header.tpl'}

<div class="mx-auto shadow p-4 rounded bg-dark-subtle text-light" style="max-width:400px;">
    <h2 class="text-center mb-4 text-primary text-light">Utwórz rodzinę</h2>

    {if $error}
        <div class="alert alert-danger text-center">{$error}</div>
    {/if}

    {if $success}
        <div class="alert alert-success text-center">{$success}</div>
    {/if}

    <form method="post" action="index.php?action=createFamily">
        <div class="mb-3">
            <label for="family_name" class="form-label">Nazwa rodziny</label>
            <input type="text" name="family_name" id="family_name" class="form-control bg-secondary text-light border-0"
                required>
        </div>

        <div class="mb-3">
            <label for="region" class="form-label">Region</label>
            <select name="region" id="region" class="form-select bg-secondary text-light border-0" required>
                <option value="">Wybierz województwo</option>
                {foreach from=$voivodeships item=voivodeship}
                    <option value="{$voivodeship}">{$voivodeship|capitalize}</option>
                {/foreach}
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Utwórz rodzinę</button>
    </form>
</div>

{include file='footer.tpl'}