{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Kategorie</h2>

<div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-info-circle-fill"></i>
    W tym miejscu możesz przeglądać kategorie wraz z podkategoriami, które są dostępne w systemie globalnie i lokalnie.
    Kliknij w dowolną kategorię, aby przejść do podkategorii.
</div>

<div class="table-responsive shadow rounded bg-dark text-light p-3">
    <table class="table table-dark table-hover table-bordered mb-0 align-middle">
        <thead class="table-secondary text-dark">
            <tr>
                <th>Nazwa</th>
                <th>Typ</th>
                <th>Data dodania</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$category item=category}
                <tr class="align-middle">
                    <td>
                        <a href="index.php?action=viewCategory&id={$category.id}" class="text-light text-decoration-none">
                            <i class="bi bi-folder-fill me-1"></i> {$category.name}
                        </a>
                    </td>
                    <td>
                        {if $category.type == 'expense'}
                            <span class="badge bg-danger"><i class="bi bi-cash-stack me-1"></i>Wydatek</span>
                        {else}
                            <span class="badge bg-success"><i class="bi bi-wallet2 me-1"></i>Przychód</span>
                        {/if}
                    </td>
                    <td title="{$category.created_at|date_format:"%d-%m-%Y %H:%M"}">
                        {$category.created_at|date_format:"%d-%m-%y"}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>

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

    .table a:hover {
        text-decoration: underline;
    }
</style>