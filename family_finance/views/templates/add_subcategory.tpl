{include file="header.tpl"}



<h2 class="mb-4 text-light-emphasis">Dodaj podkategorię do kategorii: {$category_name}</h2>

<div class="alert alert-info alert-dark" role="alert">
    Tutaj możesz dodać nową podkategorię do wybranej kategorii głównej. Jest ona widoczna tylko dla Ciebie i dla Twojej rodziny.
</div>

<form method="post" action="index.php?action=addSubCategory">
    <input type="hidden" name="category_id" value="{$category_id}">

    <div class="mb-3">
        <label for="name" class="form-label">Nazwa podkategorii:</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Dodaj podkategorię</button>
    <a href="index.php?action=viewCategory&id={$category_id}" class="btn btn-secondary">Anuluj</a>
</form>

{include file="footer.tpl"}