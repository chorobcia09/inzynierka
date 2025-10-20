{include file="header.tpl"}

<h2 class="mb-4 text-primary">Podkategorie</h2>

<div class="alert alert-info">
    Wyświetlono podkategorie dla wybranej kategorii.
</div>

<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>Nazwa</th>
            <th>Data dodania</th>
            <th>Data aktualizacji</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$subcategories item=sub}
            <tr>
                <td>{$sub.name}</td>
                <td>{$sub.created_at}</td>
                <td>{$sub.updated_at}</td>
            </tr>
        {foreachelse}
            <tr>
                <td colspan="4" class="text-center text-muted">Brak podkategorii</td>
            </tr>
        {/foreach}
    </tbody>
</table>

<a href="index.php?action=categories" class="btn btn-secondary mt-3">← Powrót do listy kategorii</a>

{include file="footer.tpl"}