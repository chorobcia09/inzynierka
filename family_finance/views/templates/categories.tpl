{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Kategorie</h2>

<div class="alert alert-warning" role="alert">
    W tym miejscu możesz przeglądać kategorie wraz z podkategoriami, które są dostępne w systemie globalnie, jak i
    lokalnie (utworzone przez użytkownika).
</div>

<div class="table-responsive shadow rounded bg-dark text-light p-3">
    <table class="table table-striped table-bordered table-dark mb-0">
        <thead class="table-dark">
            <tr>
                <th>Nazwa</th>
                <th>Typ</th>
                <th>Zasięg</th>
                <th>Data dodania</th>
                <th>Data aktualizacji</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$category item=category}
                <tr>
                    <td>
                        <a href="index.php?action=viewCategory&id={$category.id}" class="text-light">
                            {$category.name}
                        </a>
                    </td>
                    <td>{if $category.type == 'expense'}Wydatek{else}Przychód{/if}</td>
                    <td>{if $category.is_global == 1}Globalna{else}Lokalna{/if}</td>
                    <td>{$category.created_at}</td>
                    <td>{$category.updated_at}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>

{include file="footer.tpl"}