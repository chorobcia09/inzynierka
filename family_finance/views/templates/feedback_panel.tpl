{include file='header.tpl'}

<h2 class="mb-4 text-primary">Zarządzanie zgłoszeniami</h2>
{if $message}
    <div class="alert alert-info text-center">{$message}</div>
{/if}

<form method="get" class="mb-3 d-flex align-items-center gap-2">
    <input type="hidden" name="action" value="indexFeedback">
    <label for="filter_status" class="form-label mb-0">Filtruj po statusie:</label>
    <select name="status" id="filter_status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">Wszystkie</option>
        <option value="new" {if $filter_status=='new'}selected{/if}>Nowe</option>
        <option value="in_progress" {if $filter_status=='in_progress'}selected{/if}>W trakcie</option>
        <option value="resolved" {if $filter_status=='resolved'}selected{/if}>Rozwiązane</option>
    </select>
</form>

<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>ID Użytkownika</th>
            <th>Typ</th>
            <th>Temat</th>
            <th>Opis</th>
            <th>Data utworzenia</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$feedback item=feedback}
            <tr>
                <td>{$feedback.id}</td>
                <td>{$feedback.user_id}</td>
                <td>{$feedback.type}</td>
                <td>{$feedback.subject}</td>
                <td>{$feedback.message}</td>
                <td>{$feedback.created_at}</td>
                <td>
                    <form method="post" action="index.php?action=changeStatus" class="d-flex gap-2">
                        <input type="hidden" name="feedback_id" value="{$feedback.id}">
                        <select name="status" class="form-select form-select-sm">
                            <option value="new" {if $feedback.status=='new'}selected{/if}>Nowy</option>
                            <option value="in_progress" {if $feedback.status=='in_progress'}selected{/if}>W trakcie</option>
                            <option value="resolved" {if $feedback.status=='resolved'}selected{/if}>Rozwiązane</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Zmień</button>
                    </form>
                </td>

            </tr>
        {/foreach}
    </tbody>
</table>

{include file='footer.tpl'}