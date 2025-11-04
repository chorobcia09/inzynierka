<?php
/* Smarty version 5.6.0, created on 2025-11-04 21:01:07
  from 'file:budget_details.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_690a5b83921c34_27550249',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b81901c8c21d70a7a6c81397acd37cd237448c8' => 
    array (
      0 => 'budget_details.tpl',
      1 => 1762285796,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_690a5b83921c34_27550249 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Szczegóły budżetu: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['name']), ENT_QUOTES, 'UTF-8');?>
</h2>

<div class="card bg-dark text-light mb-4 shadow-lg border-0">
    <div class="card-body">
        <p><strong>Okres:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['start_date']), ENT_QUOTES, 'UTF-8');?>
 → <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['end_date']), ENT_QUOTES, 'UTF-8');?>
</p>
        <p><strong>Typ:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('capitalize')($_smarty_tpl->getValue('budget')['period_type'])), ENT_QUOTES, 'UTF-8');?>
</p>
    </div>
</div>

<h4 class="mb-3 text-light-emphasis">Podział według kategorii</h4>

<div class="list-group">
    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categories'), 'cat');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('cat')->value) {
$foreach0DoElse = false;
?>
        <div class="list-group-item bg-dark-subtle text-light rounded-3 mb-2 p-3 shadow-sm">
            <div class="d-flex justify-content-between">
                <span class="fw-semibold"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('cat')['category_name']), ENT_QUOTES, 'UTF-8');?>
</span>
                <span>
                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cat')['spent_amount'],2)), ENT_QUOTES, 'UTF-8');?>
 / <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('cat')['limit_amount'],2)), ENT_QUOTES, 'UTF-8');?>
 PLN
                    (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('cat')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%)
                </span>
            </div>
            <div class="progress mt-2" style="height: 10px;">
                <div class="progress-bar <?php if ($_smarty_tpl->getValue('cat')['used_percent'] >= 100) {?>bg-danger<?php } elseif ($_smarty_tpl->getValue('cat')['used_percent'] >= 80) {?>bg-warning<?php } else { ?>bg-success<?php }?>"
                    role="progressbar" style="width: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('cat')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%;" aria-valuenow="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('cat')['used_percent']), ENT_QUOTES, 'UTF-8');?>
"
                    aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
</div>

<a href="index.php?action=viewBudgets" class="btn btn-secondary mt-4">
    <i class="bi bi-arrow-left"></i> Powrót do listy budżetów
</a>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
