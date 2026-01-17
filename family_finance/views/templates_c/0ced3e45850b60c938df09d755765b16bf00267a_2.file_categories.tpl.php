<?php
/* Smarty version 5.6.0, created on 2026-01-17 12:38:09
  from 'file:categories.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_696b74a118e6e5_54874054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0ced3e45850b60c938df09d755765b16bf00267a' => 
    array (
      0 => 'categories.tpl',
      1 => 1768649887,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_696b74a118e6e5_54874054 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Kategorie</h2>

<div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-info-circle-fill"></i>
    W tym miejscu możesz przeglądać kategorie wraz z podkategoriami, które są dostępne w systemie globalnie i lokalnie.
    Kliknij w dowolną kategorię, aby przejść do podkategorii.
</div>

<div class="table-responsive shadow rounded bg-dark text-light p-3">
    <table class="table table-dark table-hover table-bordered mb-0 align-middle">
        <thead class="table-secondary text-dark">
            <tr>
                <th>Nazwa</th>
                <th>Typ</th>
                <th>Data dodania</th>
            </tr>
        </thead>
        <tbody>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('category'), 'category');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('category')->value) {
$foreach0DoElse = false;
?>
                <tr class="align-middle">
                    <td>
                        <a href="index.php?action=viewCategory&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['id']), ENT_QUOTES, 'UTF-8');?>
" class="text-light text-decoration-none">
                            <i class="bi bi-folder-fill me-1"></i> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['name']), ENT_QUOTES, 'UTF-8');?>

                        </a>
                    </td>
                    <td>
                        <?php if ($_smarty_tpl->getValue('category')['type'] == 'expense') {?>
                            <span class="badge bg-danger"><i class="bi bi-cash-stack me-1"></i>Wydatek</span>
                        <?php } else { ?>
                            <span class="badge bg-success"><i class="bi bi-wallet2 me-1"></i>Przychód</span>
                        <?php }?>
                    </td>
                    <td title="<?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('category')['created_at'],"%d-%m-%Y %H:%M")), ENT_QUOTES, 'UTF-8');?>
">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('category')['created_at'],"%d-%m-%y")), ENT_QUOTES, 'UTF-8');?>

                    </td>
                </tr>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div>

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

    .table a:hover {
        text-decoration: underline;
    }
</style><?php }
}
