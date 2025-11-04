{include file="header.tpl"}

<div class="container my-5">
    <div class="p-4 bg-dark-subtle text-light rounded-4 shadow-lg">

        <h2 class="mb-4 fw-bold text-light-emphasis">
            <i class="bi bi-wallet2 me-2"></i>Dodaj nowy budżet
        </h2>

        <div class="alert alert-info bg-dark text-light border-light" role="alert">
            <i class="bi bi-lightbulb-fill"></i> Tutaj możesz utworzyć nowy budżet rodzinny lub indywidualny. Określ
            okres obowiązywania oraz limity dla poszczególnych kategorii.
        </div>

        {if isset($error)}
            <div class="alert alert-danger" role="alert">{$error}</div>
        {/if}
        {if isset($success)}
            <div class="alert alert-success" role="alert">{$success nofilter}</div>
        {/if}

        <form method="post" action="index.php?action=addBudget" id="budgetForm">
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nazwa budżetu:</label>
                <input type="text" name="name" id="name" class="form-control bg-dark text-light border-secondary"
                    placeholder="np. Budżet listopad 2025" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="period_type" class="form-label fw-semibold">Typ okresu:</label>
                    <select name="period_type" id="period_type" class="form-select bg-dark text-light border-secondary"
                        required>
                        <option value="monthly">Miesięczny</option>
                        <option value="yearly">Roczny</option>
                        <option value="custom">Niestandardowy</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="start_date" class="form-label fw-semibold">Data początkowa:</label>
                    <input type="date" name="start_date" id="start_date"
                        class="form-control bg-dark text-light border-secondary" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label fw-semibold">Data końcowa:</label>
                    <input type="date" name="end_date" id="end_date"
                        class="form-control bg-dark text-light border-secondary" required>
                </div>
            </div>

            <hr class="my-4 border-secondary">

            <h4 class="mb-3 text-light-emphasis fw-bold">
                <i class="bi bi-pie-chart-fill me-2"></i>Limity w kategoriach
            </h4>

            <div id="categories-container">
                <div class="row mb-3 align-items-center category-row bg-dark p-3 rounded-3 shadow-sm">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategoria:</label>
                        <select class="form-select bg-dark text-light border-secondary"
                            name="categories[0][category_id]" required>
                            <option value="">Wybierz kategorię...</option>
                            {foreach $categories as $category}
                                <option value="{$category.id}">{$category.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Limit kategorii (PLN):</label>
                        <input type="number" step="0.01" name="categories[0][limit_amount]"
                            class="form-control bg-dark text-light border-secondary" placeholder="np. 500.00" required>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-outline-info mb-4" id="add-category">
                <i class="bi bi-plus-circle me-2"></i>Dodaj kolejną kategorię
            </button>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check2-circle me-2"></i>Zapisz budżet
                </button>
                <a href="index.php?action=viewBudgets" class="btn btn-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Anuluj
                </a>
            </div>
        </form>
    </div>
</div>

{literal}
    <script>
        let counter = 1;
        document.getElementById('add-category').addEventListener('click', function() {
            const container = document.getElementById('categories-container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-3 align-items-center category-row bg-dark p-3 rounded-3 shadow-sm fade-in';
            newRow.innerHTML = `
            <div class="col-md-6">
                <label class="form-label fw-semibold">Kategoria:</label>
<select class="form-select bg-dark text-light border-secondary" name="categories[${counter}][category_id]" required>
                    <option value="">Wybierz kategorię...</option>
${document.querySelector('select[name="categories[0][category_id]"]').innerHTML}
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Limit kategorii (PLN):</label>
<input type="number" step="0.01" name="categories[${counter}][limit_amount]" class="form-control bg-dark text-light border-secondary" placeholder="np. 500.00" required>
            </div>`;
            container.appendChild(newRow);
            newRow.scrollIntoView({ behavior: "smooth", block: "center" });
            counter++;
        });

        // efekt płynnego pojawiania się nowego wiersza
        const style = document.createElement('style');
        style.innerHTML = `
        .fade-in {
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeIn 0.3s ease forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
        document.head.appendChild(style);
    </script>
{/literal}

{include file="footer.tpl"}