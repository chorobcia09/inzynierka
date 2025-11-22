<?php
/* Smarty version 5.6.0, created on 2025-11-22 17:35:46
  from 'file:add_budget.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6921e6623450a3_43688827',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ee1837b410515a4daa213bbaae414cdf8b22b950' => 
    array (
      0 => 'add_budget.tpl',
      1 => 1763829345,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6921e6623450a3_43688827 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container my-5">
    <div class="p-4 bg-dark-subtle text-light rounded-4 shadow-lg">

        <h2 class="mb-4 fw-bold text-light-emphasis">
            <i class="bi bi-wallet2 me-2"></i>Dodaj nowy budżet
        </h2>

        <div class="alert alert-info bg-dark text-light border-light" role="alert">
            <i class="bi bi-lightbulb-fill"></i> Tutaj możesz utworzyć nowy budżet rodzinny lub indywidualny. Określ
            okres obowiązywania oraz limity dla poszczególnych kategorii.
        </div>

        <?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
        <?php }?>
        <?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
            <div class="alert alert-success" role="alert"><?php echo $_smarty_tpl->getValue('success');?>
</div>
        <?php }?>

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
                <div class="col-md-4 mb-3">
                    <label for="currency" class="form-label fw-semibold">Waluta:</label>
                    <select name="currency" id="currency" class="form-select bg-dark text-light border-secondary"
                        required>
                        <option value="PLN" selected>PLN - Złoty</option>
                        <option value="USD">USD - Dolar amerykański</option>
                        <option value="EUR">EUR - Euro</option>
                        <option value="BTC">BTC - Bitcoin</option>
                        <option value="ETH">ETH - Ethereum</option>
                        <!-- dodaj inne w razie potrzeby -->
                    </select>
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
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'category');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('category')->value) {
$foreach0DoElse = false;
?>
                                <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['id']), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['name']), ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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


    <?php echo '<script'; ?>
>
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
    <?php echo '</script'; ?>
>


<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
