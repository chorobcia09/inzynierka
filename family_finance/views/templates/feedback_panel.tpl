{include file='header.tpl'}

<h2 class="mb-4 text-primary text-light">Zarządzanie zgłoszeniami</h2>

{if $message}
    <div class="alert alert-info text-center bg-info bg-opacity-10 text-light border-0">{$message}</div>
{/if}

<form method="get" class="mb-3 d-flex align-items-center gap-2">
    <input type="hidden" name="action" value="feedbackPanel">
    <label for="filter_status" class="form-label mb-0">Filtruj po statusie:</label>
    <select name="status" id="filter_status" class="form-select form-select-sm bg-secondary text-light border-0"
        onchange="this.form.submit()">
        <option value="">Wszystkie</option>
        <option value="new" {if $filter_status=='new'}selected{/if}>Nowe</option>
        <option value="in_progress" {if $filter_status=='in_progress'}selected{/if}>W trakcie</option>
        <option value="resolved" {if $filter_status=='resolved'}selected{/if}>Rozwiązane</option>
    </select>
</form>

<div class="table-responsive shadow rounded">
    <table class="table table-striped table-bordered mb-0 table-dark align-middle">
        <thead class="table-dark">
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
                <tr class="align-middle">
                    <td>{$feedback.id}</td>
                    <td>{$feedback.user_id}</td>
                    <td>{$feedback.type}</td>
                    <td>{$feedback.subject}</td>
                    <td>{$feedback.message}</td>
                    <td>{$feedback.created_at}</td>
                    <td>
                        <form method="post" action="index.php?action=changeStatus" class="d-flex gap-2">
                            <input type="hidden" name="feedback_id" value="{$feedback.id}">
                            <select name="status" class="form-select form-select-sm bg-secondary text-light border-0">
                                <option value="new" {if $feedback.status=='new'}selected{/if}>Nowy</option>
                                <option value="in_progress" {if $feedback.status=='in_progress'}selected{/if}>W trakcie
                                </option>
                                <option value="resolved" {if $feedback.status=='resolved'}selected{/if}>Rozwiązane</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Zmień</button>
                        </form>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>

{include file='footer.tpl'}