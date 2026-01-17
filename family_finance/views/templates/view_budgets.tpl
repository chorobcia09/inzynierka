{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Twoje budżety</h2>

{if isset($error)}
    <div class="alert alert-danger" role="alert">{$error}</div>
{/if}

{if isset($success)}
    <div class="alert alert-success" role="alert">{$success nofilter}</div>
{/if}

{if $session['family_role'] == 'family_admin'}
    <div class="d-flex justify-content-end mb-3">
        <a href="index.php?action=addBudget" class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            <span class="ms-1">Dodaj nowy budżet</span>
        </a>
    </div>
{/if}

{if $budgets|@count > 0}
    <style>
        @media (min-width: 768px) {

            .col-limit,
            .col-spent {
                width: 15%;
                min-width: 120px;
            }

            .col-progress {
                width: 20%;
                min-width: 150px;
            }

            .col-actions {
                width: 130px;
                text-align: right;
            }

        }

        @media (max-width: 576px) {
            .mobile-table {
                table-layout: fixed;
                width: 100%;
            }

            .mobile-unit {
                font-size: 0.75rem;
                color: #adb5bd;
            }
        }
    </style>

    <table class="table table-dark table-striped align-middle shadow-lg rounded-3 overflow-hidden mobile-table">
        <thead class="table-success text-dark">
            <tr>
                <th>Nazwa</th>
                <th class="d-none d-md-table-cell">Okres</th>
                <th class="d-table-cell d-md-none text-center">Informacje</th>
                <th class="d-none d-md-table-cell col-limit">Limit</th>
                <th class="d-none d-md-table-cell col-spent">Wydano</th>
                <th class="d-none d-md-table-cell col-progress">Postęp</th>
                <th class="col-actions">Akcje</th>
            </tr>
        </thead>

        <tbody>
            {foreach $budgets as $budget}
                <tr>
                    <td class="fw-semibold text-break">
                        {$budget.name}
                    </td>

                    <td class="d-none d-md-table-cell text-nowrap small">
                        {$budget.start_date|date_format:"%d.%m.%y"} – {$budget.end_date|date_format:"%d.%m.%y"}
                    </td>

                    <td class="d-table-cell d-md-none">
                        <div class="d-flex flex-column gap-1">
                            <div class="small text-secondary" style="font-size: 0.7rem;">
                                {$budget.start_date|date_format:"%d.%m.%y"} – {$budget.end_date|date_format:"%d.%m.%y"}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small fw-bold">
                                    {$budget.total_spent|number_format:0:",":" "}/<br>{$budget.total_limit|number_format:0:",":" "}
                                    <span class="mobile-unit">{$budget.currency|default:"zł"}</span>
                                </span>
                                <span class="badge {if $budget.used_percent > 100}bg-danger{else}bg-secondary{/if}"
                                    style="font-size: 0.65rem;">{$budget.used_percent}%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar {if $budget.used_percent < 70}bg-success{elseif $budget.used_percent < 100}bg-warning{else}bg-danger{/if}"
                                    style="width: {$budget.used_percent}%"></div>
                            </div>
                        </div>
                    </td>

                    <td class="d-none d-md-table-cell text-nowrap">
                        {$budget.total_limit|number_format:2:",":" "} <span
                            class="small text-secondary">{$budget.currency|default:"zł"}</span>
                    </td>

                    <td class="d-none d-md-table-cell text-nowrap text-white">
                        {$budget.total_spent|number_format:2:",":" "} <span
                            class="small text-secondary">{$budget.currency|default:"zł"}</span>
                    </td>

                    <td class="d-none d-md-table-cell">
                        <div class="progress" style="height:14px;">
                            <div class="progress-bar {if $budget.used_percent < 70}bg-success{elseif $budget.used_percent < 100}bg-warning{else}bg-danger{/if}"
                                style="width: {$budget.used_percent}%">
                                <small style="font-size: 0.65rem;">{$budget.used_percent}%</small>
                            </div>
                        </div>
                    </td>

                    <td class="col-actions">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="index.php?action=viewBudget&id={$budget.id}" class="btn btn-sm btn-primary"
                                title="Szczegóły">
                                <i class="bi bi-eye"></i>
                            </a>
                            {if $session['family_role'] == 'family_admin' || $session['family_role'] == null}
                                <a href="index.php?action=editBudget&id={$budget.id}" class="btn btn-sm btn-warning" title="Edytuj">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="index.php?action=deleteBudget&id={$budget.id}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Czy na pewno chcesz usunąć?');" title="Usuń">
                                    <i class="bi bi-trash"></i>
                                </a>
                            {/if}
                        </div>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    <div class="alert alert-info text-center">
        Nie masz jeszcze żadnych budżetów. <a href="index.php?action=addBudget" class="alert-link">Dodaj pierwszy</a>.
    </div>
{/if}

{include file="footer.tpl"}