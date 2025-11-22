{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Szczegóły budżetu: {$budget.name}</h2>

<div class="card bg-dark text-light mb-4 shadow-lg border-0">
    <div class="card-body">
        <p><strong>Okres:</strong> {$budget.start_date} → {$budget.end_date}</p>
        <p><strong>Typ:</strong> {$budget.period_type|capitalize}</p>
    </div>
</div>

<h4 class="mb-3 text-light-emphasis">Podział według kategorii</h4>

<div class="list-group">
    {foreach $categories as $cat}
        <div class="list-group-item bg-dark-subtle text-light rounded-3 mb-2 p-3 shadow-sm">
            <div class="d-flex justify-content-between">
                <span class="fw-semibold">{$cat.category_name}</span>
                <span>
                    {$cat.spent_amount|number_format:2} {$budget.currency|default:"PLN"} /
                    {$cat.limit_amount|number_format:2} {$budget.currency|default:"PLN"}
                    ({$cat.used_percent}%)
                </span>
            </div>

            <div class="progress mt-2" style="height: 10px;">
                <div class="progress-bar {if $cat.used_percent >= 100}bg-danger{elseif $cat.used_percent >= 80}bg-warning{else}bg-success{/if}"
                    role="progressbar" style="width: {$cat.used_percent}%;" aria-valuenow="{$cat.used_percent}"
                    aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    {/foreach}
</div>

<a href="index.php?action=viewBudgets" class="btn btn-secondary mt-4">
    <i class="bi bi-arrow-left"></i> Powrót do listy budżetów
</a>

{include file="footer.tpl"}