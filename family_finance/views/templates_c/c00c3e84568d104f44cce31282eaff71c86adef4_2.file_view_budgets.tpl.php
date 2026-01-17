<?php
/* Smarty version 5.6.0, created on 2026-01-17 14:11:49
  from 'file:view_budgets.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_696b8a95be5887_76481565',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c00c3e84568d104f44cce31282eaff71c86adef4' => 
    array (
      0 => 'view_budgets.tpl',
      1 => 1768655509,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_696b8a95be5887_76481565 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Twoje budżety</h2>

<?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
<?php }?>

<?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
    <div class="alert alert-success" role="alert"><?php echo $_smarty_tpl->getValue('success');?>
</div>
<?php }?>

<?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
    <div class="d-flex justify-content-end mb-3">
        <a href="index.php?action=addBudget" class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            <span class="ms-1">Dodaj nowy budżet</span>
        </a>
    </div>
<?php }?>

<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('budgets')) > 0) {?>
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
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('budgets'), 'budget');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('budget')->value) {
$foreach0DoElse = false;
?>
                <tr>
                    <td class="fw-semibold text-break">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['name']), ENT_QUOTES, 'UTF-8');?>

                    </td>

                    <td class="d-none d-md-table-cell text-nowrap small">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('budget')['start_date'],"%d.%m.%y")), ENT_QUOTES, 'UTF-8');?>
 – <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('budget')['end_date'],"%d.%m.%y")), ENT_QUOTES, 'UTF-8');?>

                    </td>

                    <td class="d-table-cell d-md-none">
                        <div class="d-flex flex-column gap-1">
                            <div class="small text-secondary" style="font-size: 0.7rem;">
                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('budget')['start_date'],"%d.%m.%y")), ENT_QUOTES, 'UTF-8');?>
 – <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('budget')['end_date'],"%d.%m.%y")), ENT_QUOTES, 'UTF-8');?>

                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small fw-bold">
                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('budget')['total_spent'],0,","," ")), ENT_QUOTES, 'UTF-8');?>
/<br><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('budget')['total_limit'],0,","," ")), ENT_QUOTES, 'UTF-8');?>

                                    <span class="mobile-unit"><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('budget')['currency'] ?? null)===null||$tmp==='' ? "zł" ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</span>
                                </span>
                                <span class="badge <?php if ($_smarty_tpl->getValue('budget')['used_percent'] > 100) {?>bg-danger<?php } else { ?>bg-secondary<?php }?>"
                                    style="font-size: 0.65rem;"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar <?php if ($_smarty_tpl->getValue('budget')['used_percent'] < 70) {?>bg-success<?php } elseif ($_smarty_tpl->getValue('budget')['used_percent'] < 100) {?>bg-warning<?php } else { ?>bg-danger<?php }?>"
                                    style="width: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%"></div>
                            </div>
                        </div>
                    </td>

                    <td class="d-none d-md-table-cell text-nowrap">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('budget')['total_limit'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <span
                            class="small text-secondary"><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('budget')['currency'] ?? null)===null||$tmp==='' ? "zł" ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</span>
                    </td>

                    <td class="d-none d-md-table-cell text-nowrap text-white">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('budget')['total_spent'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <span
                            class="small text-secondary"><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('budget')['currency'] ?? null)===null||$tmp==='' ? "zł" ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</span>
                    </td>

                    <td class="d-none d-md-table-cell">
                        <div class="progress" style="height:14px;">
                            <div class="progress-bar <?php if ($_smarty_tpl->getValue('budget')['used_percent'] < 70) {?>bg-success<?php } elseif ($_smarty_tpl->getValue('budget')['used_percent'] < 100) {?>bg-warning<?php } else { ?>bg-danger<?php }?>"
                                style="width: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%">
                                <small style="font-size: 0.65rem;"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['used_percent']), ENT_QUOTES, 'UTF-8');?>
%</small>
                            </div>
                        </div>
                    </td>

                    <td class="col-actions">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="index.php?action=viewBudget&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-primary"
                                title="Szczegóły">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin' || $_smarty_tpl->getValue('session')['family_role'] == null) {?>
                                <a href="index.php?action=editBudget&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-warning" title="Edytuj">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="index.php?action=deleteBudget&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('budget')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Czy na pewno chcesz usunąć?');" title="Usuń">
                                    <i class="bi bi-trash"></i>
                                </a>
                            <?php }?>
                        </div>
                    </td>
                </tr>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="alert alert-info text-center">
        Nie masz jeszcze żadnych budżetów. <a href="index.php?action=addBudget" class="alert-link">Dodaj pierwszy</a>.
    </div>
<?php }?>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
