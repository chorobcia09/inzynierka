{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Twoje budżety</h2>

<div class="d-flex justify-content-end mb-3">
    <a href="index.php?action=addBudget" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Dodaj nowy budżet
    </a>
</div>

{if $budgets|@count > 0}
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle shadow-lg rounded-3 overflow-hidden">
            <thead class="table-success text-dark">
                <tr>
                    <th>Nazwa</th>
                    <th>Okres</th>
                    <th>Limit (PLN)</th>
                    <th>Wydano</th>
                    <th>Postęp</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                {foreach $budgets as $budget}
                    <tr>
                        <td class="fw-semibold">{$budget.name}</td>
                        <td>
                            {$budget.start_date|date_format:"%d.%m.%Y"} -
                            {$budget.end_date|date_format:"%d.%m.%Y"}
                        </td>
                        <td>{$budget.total_limit|number_format:2:",":" "} zł</td>
                        <td>{$budget.total_spent|number_format:2:",":" "} zł</td>
                        <td style="min-width:180px;">
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar 
                                    {if $budget.used_percent < 70}
                                        bg-success
                                    {elseif $budget.used_percent < 100}
                                        bg-warning
                                    {else}
                                        bg-danger
                                    {/if}" role="progressbar" style="width: {$budget.used_percent}%;"
                                    aria-valuenow="{$budget.used_percent}" aria-valuemin="0" aria-valuemax="100">
                                    {$budget.used_percent}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="index.php?action=viewBudget&id={$budget.id}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Szczegóły
                            </a>

                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
{else}
    <div class="alert alert-info text-center">
        Nie masz jeszcze żadnych budżetów. <a href="index.php?action=addBudget">Dodaj pierwszy budżet</a>.
    </div>
{/if}

{include file="footer.tpl"}