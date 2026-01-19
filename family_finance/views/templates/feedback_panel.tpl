{include file='header.tpl'}

<style>
    .table-wrapper {
        border-radius: 1rem;
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.45);
        overflow: hidden;
    }

    table {
        width: 100%;
        table-layout: fixed;
    }

    td,
    th {
        word-wrap: break-word;
        white-space: normal;
        vertical-align: top;
    }

    /* ===== MOBILE META INFO ===== */
    .mobile-meta {
        display: none;
        font-size: 0.75rem;
        margin-top: 0.4rem;
        opacity: 0.85;
    }

    .mobile-meta span {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.5rem;
        padding: 0.15rem 0.45rem;
        margin: 0.1rem 0.1rem 0 0;
    }

    /* ===== MOBILE VIEW ===== */
    @media (max-width: 768px) {

        /* ukrycie kolumn */
        .col-user,
        .col-type,
        .col-date {
            display: none;
        }

        .mobile-meta {
            display: block;
        }

        .table-wrapper {
            overflow-x: hidden;
        }

        td,
        th {
            font-size: 0.85rem;
            padding: 0.5rem;
        }

        select.form-select-sm,
        button.btn-sm {
            font-size: 0.75rem;
        }
    }
</style>

<h2 class="mb-4 text-light-emphasis">Zarządzanie zgłoszeniami</h2>

{if $message}
    <div class="alert alert-info text-center bg-info bg-opacity-10 text-light border-0">
        {$message}
    </div>
{/if}

<form method="get" class="mb-3 d-flex align-items-center gap-2">
    <input type="hidden" name="action" value="feedbackPanel">

    <label for="filter_status" class="form-label mb-0">
        Filtruj po statusie:
    </label>

    <select name="status" id="filter_status" class="form-select form-select-sm bg-secondary text-light border-0"
        onchange="this.form.submit()">

        <option value="">Wszystkie</option>
        <option value="new" {if $filter_status=='new'}selected{/if}>Nowe</option>
        <option value="in_progress" {if $filter_status=='in_progress'}selected{/if}>W trakcie</option>
        <option value="resolved" {if $filter_status=='resolved'}selected{/if}>Rozwiązane</option>
    </select>
</form>

<div class="table-wrapper">
    <table class="table table-dark table-striped table-bordered mb-0">

        <thead class="table-success text-dark">
            <tr>
                <th>ID</th>
                <th class="col-user">Użytkownik</th>
                <th class="col-type">Typ</th>
                <th>Temat</th>
                <th>Opis</th>
                <th class="col-date">Data</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            {foreach from=$feedback item=feedback}
                <tr>
                    <td>{$feedback.id}</td>

                    <td class="col-user">{$feedback.user_id}</td>

                    <td class="col-type">{$feedback.type}</td>

                    <td class="fw-semibold">
                        {$feedback.subject}

                        <!-- MOBILE META -->
                        <div class="mobile-meta">
                            <span>User ID: {$feedback.user_id}</span>
                            <span>Typ: {$feedback.type}</span>
                            <span>{$feedback.created_at}</span>
                        </div>
                    </td>

                    <td>{$feedback.message}</td>

                    <td class="col-date">{$feedback.created_at}</td>

                    <td>
                        <form method="post" action="index.php?action=changeStatus"
                            class="d-flex flex-column flex-md-row gap-2">

                            <input type="hidden" name="feedback_id" value="{$feedback.id}">

                            <select name="status" class="form-select form-select-sm bg-secondary text-light border-0">

                                <option value="new" {if $feedback.status=='new'}selected{/if}>Nowy</option>
                                <option value="in_progress" {if $feedback.status=='in_progress'}selected{/if}>
                                    W trakcie
                                </option>
                                <option value="resolved" {if $feedback.status=='resolved'}selected{/if}>
                                    Rozwiązane
                                </option>
                            </select>

                            <button type="submit" class="btn btn-sm btn-primary">
                                Zmień
                            </button>
                        </form>
                    </td>
                </tr>
            {/foreach}
        </tbody>

    </table>
</div>

{include file='footer.tpl'}