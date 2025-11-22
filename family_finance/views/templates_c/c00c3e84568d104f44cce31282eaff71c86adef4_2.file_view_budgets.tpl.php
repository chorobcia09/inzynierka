<?php
/* Smarty version 5.6.0, created on 2025-11-22 19:21:09
  from 'file:view_budgets.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6921ff159bac43_16651215',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c00c3e84568d104f44cce31282eaff71c86adef4' => 
    array (
      0 => 'view_budgets.tpl',
      1 => 1763835622,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6921ff159bac43_16651215 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Twoje budżety</h2>

<?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
<?php }
if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
    <div class="alert alert-success" role="alert"><?php echo $_smarty_tpl->getValue('success');?>
</div>
<?php }?>

<div class="d-flex justify-content-end mb-3">
    <a href="index.php?action=addBudget" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Dodaj nowy budżet
    </a>
</div>

<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('budgets')) > 0) {?>
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle shadow-lg rounded-3 overflow-hidden">
            <thead class="table-success text-dark">
                <tr>
                    <th>Nazwa</th>
                    <th>Okres</th>
                    <th>Limit</th>
                    <th>Wydano</th>
                    <th>Postęp</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('budgets'), 'budget');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('budget')->value) {
$foreach0DoElse = false;
?>
                    <tr>
                        <td class="fw-semibold"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['name']), ENT_QUOTES, 'UTF-8');?>
</td>
                        <td>
                            <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('budget')['start_date'],"%d.%m.%Y")), ENT_QUOTES, 'UTF-8');?>
 -
                            <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('budget')['end_date'],"%d.%m.%Y")), ENT_QUOTES, 'UTF-8');?>

                        </td>
                        <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('budget')['total_limit'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('budget')['currency'] ?? null)===null||$tmp==='' ? "zł" ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</td>
                        <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('budget')['total_spent'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('budget')['currency'] ?? null)===null||$tmp==='' ? "zł" ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</td>

                        <td style="min-width:180px;">
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar 
                                    <?php if ($_smarty_tpl->getValue('budget')['used_percent'] < 70) {?>
                                        bg-success
                                    <?php } elseif ($_smarty_tpl->getValue('budget')['used_percent'] < 100) {?>
                                        bg-warning
                                    <?php } else { ?>
                                        bg-danger
                                    <?php }?>" role="progressbar" style="width: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%;"
                                    aria-valuenow="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['used_percent']), ENT_QUOTES, 'UTF-8');?>
" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="index.php?action=viewBudget&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Szczegóły
                            </a>

                            <a href="index.php?action=editBudget&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Edytuj
                            </a>
                            <a href="index.php?action=deleteBudget&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-danger"
                                onclick="return confirm('Czy na pewno chcesz usunąć ten budżet?');">
                                <i class="bi bi-trash me-2"></i>Usuń budżet
                            </a>


                        </td>
                    </tr>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="alert alert-info text-center">
        Nie masz jeszcze żadnych budżetów. <a href="index.php?action=addBudget">Dodaj pierwszy budżet</a>.
    </div>
<?php }?>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
