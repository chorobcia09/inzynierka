{include file="header.tpl"}

<h2 class="mb-4 text-primary">Kategorie</h2>

<div class="alert alert-warning" role="alert">
W tym miejscu możesz przeglądać kategorie wraz z podkategoriami, które są dostępne w systemie globlanie, jak i loklanie (utworzone przez użytkownika).
</div>
<table class="table table-striped table-bordered">
    <thead class="table-light">
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
                <td>{$category.name}</td>
                <td>{if $category.type == 'expense'}Wydatek {else} Przychód{/if}</td>
                <td>{if $category.is_global = 1} Globalna {else} Loklana{/if}</td>
                <td>{$category.created_at}</td>
                <td>{$category.updated_at}</td>
            </tr>
        {/foreach}
    </tbody>
</table>



{include file="footer.tpl"}