<?php
/* Smarty version 5.6.0, created on 2025-12-13 13:00:43
  from 'file:category_view.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_693d556b6cf188_75637133',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd2f1ecd92d0518666f21ff32676ba94832dc3adc' => 
    array (
      0 => 'category_view.tpl',
      1 => 1765627240,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_693d556b6cf188_75637133 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Podkategorie</h2>

<?php if ($_smarty_tpl->getValue('error')) {?>
    <div class="alert alert-danger text-center"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
<?php }?>

<?php if ($_smarty_tpl->getValue('success')) {?>
    <div class="alert alert-success text-center"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('success')), ENT_QUOTES, 'UTF-8');?>
</div>
<?php }?>


<div class="alert alert-info d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-info-circle-fill"></i>
    Wyświetlono podkategorie dla kategorii: <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category_name')), ENT_QUOTES, 'UTF-8');?>
</strong>
</div>

<a href="index.php?action=addSubCategory&category_id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category_id')), ENT_QUOTES, 'UTF-8');?>
"
    class="btn btn-success mb-3 d-flex align-items-center gap-1">
    <i class="bi bi-plus-circle"></i> Dodaj podkategorię
</a>

<div class="table-responsive shadow rounded bg-dark text-light p-3">
    <table class="table table-striped table-hover table-bordered table-dark mb-0 align-middle">
        <thead class="table-secondary text-dark">
            <tr>
                <th>Nazwa</th>
                <th>Data dodania</th>
                <th>Data aktualizacji</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('subcategories'), 'sub');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sub')->value) {
$foreach0DoElse = false;
?>
                <tr>
                    <td>
                        <i class="bi bi-folder-fill me-1 text-warning"></i> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('sub')['name']), ENT_QUOTES, 'UTF-8');?>

                    </td>
                    <td title="<?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('sub')['created_at'],"%d-%m-%Y %H:%M")), ENT_QUOTES, 'UTF-8');?>
">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('sub')['created_at'],"%d-%m-%Y")), ENT_QUOTES, 'UTF-8');?>

                    </td>
                    <td title="<?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('sub')['updated_at'],"%d-%m-%Y %H:%M")), ENT_QUOTES, 'UTF-8');?>
">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('sub')['updated_at'],"%d-%m-%Y")), ENT_QUOTES, 'UTF-8');?>

                    </td>
                    <td>
                        <?php if (($_smarty_tpl->getValue('session')['family_role'] == 'family_admin' && $_smarty_tpl->getValue('sub')['family_id'] == $_smarty_tpl->getValue('session')['family_id']) || ($_smarty_tpl->getValue('sub')['user_id'] == $_smarty_tpl->getValue('session')['user_id'])) {?>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('sub')['transaction_count'] ?? null))) && $_smarty_tpl->getValue('sub')['transaction_count'] > 0) {?>
                                <?php $_smarty_tpl->assign('confirmMessage', (("Uwaga! Podkategoria ma ").($_smarty_tpl->getValue('sub')['transaction_count'])).(" powiązane transakcje, które zostaną usunięte. Czy na pewno chcesz kontynuować?"), false, NULL);?>
                            <?php } else { ?>
                                <?php $_smarty_tpl->assign('confirmMessage', "Czy na pewno chcesz usunąć podkategorię?", false, NULL);?>
                            <?php }?>

                            <a href="index.php?action=deleteSubCategory&sub_category_id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('sub')['id']), ENT_QUOTES, 'UTF-8');?>
&category_id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category_id')), ENT_QUOTES, 'UTF-8');?>
"
                                class="btn btn-danger btn-sm" onclick="return confirm('<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('confirmMessage')), ENT_QUOTES, 'UTF-8');?>
')">
                                Usuń
                            </a>
                        <?php }?>





                    </td>
                </tr>
            <?php
}
if ($foreach0DoElse) {
?>
                <tr>
                    <td colspan="4" class="text-center text-muted">Brak podkategorii</td>
                </tr>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div>

<a href="index.php?action=categories" class="btn btn-secondary mt-3 d-flex align-items-center gap-1">
    <i class="bi bi-arrow-left-circle"></i> Powrót do listy kategorii
</a>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transition: background-color 0.2s;
    }

    .table-responsive table {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    a.btn:hover {
        text-decoration: none;
        opacity: 0.9;
    }
</style><?php }
}
