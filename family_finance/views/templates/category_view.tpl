{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Podkategorie</h2>

<div class="alert alert-info d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-info-circle-fill"></i>
    Wyświetlono podkategorie dla kategorii: <strong>{$category_name}</strong>
</div>

<a href="index.php?action=addSubCategory&category_id={$category_id}"
    class="btn btn-success mb-3 d-flex align-items-center gap-1">
    <i class="bi bi-plus-circle"></i> Dodaj podkategorię
</a>

<div class="table-responsive shadow rounded bg-dark text-light p-3">
    <table class="table table-striped table-hover table-bordered table-dark mb-0 align-middle">
        <thead class="table-secondary text-dark">
            <tr>
                <th>Nazwa</th>
                <th>Data dodania</th>
                <th>Data aktualizacji</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$subcategories item=sub}
                <tr>
                    <td>
                        <i class="bi bi-folder-fill me-1 text-warning"></i> {$sub.name}
                    </td>
                    <td title="{$sub.created_at|date_format:"%d-%m-%Y %H:%M"}">
                        {$sub.created_at|date_format:"%d-%m-%Y"}
                    </td>
                    <td title="{$sub.updated_at|date_format:"%d-%m-%Y %H:%M"}">
                        {$sub.updated_at|date_format:"%d-%m-%Y"}
                    </td>
                </tr>
            {foreachelse}
                <tr>
                    <td colspan="3" class="text-center text-muted">Brak podkategorii</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>

<a href="index.php?action=categories" class="btn btn-secondary mt-3 d-flex align-items-center gap-1">
    <i class="bi bi-arrow-left-circle"></i> Powrót do listy kategorii
</a>

{include file="footer.tpl"}

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transition: background-color 0.2s;
    }

    .table-responsive table {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    a.btn:hover {
        text-decoration: none;
        opacity: 0.9;
    }
</style>