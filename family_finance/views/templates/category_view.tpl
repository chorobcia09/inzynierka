{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Podkategorie</h2>

<div class="alert alert-info alert-dark" role="alert">
    Wyświetlono podkategorie dla wybranej kategorii.
</div>

<div class="table-responsive shadow rounded bg-dark text-light p-3">
    <table class="table table-striped table-bordered table-dark mb-0">
        <thead class="table-dark">
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
                    <td colspan="3" class="text-center text-muted">Brak podkategorii</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>

<a href="index.php?action=categories" class="btn btn-secondary mt-3">← Powrót do listy kategorii</a>

{include file="footer.tpl"}
