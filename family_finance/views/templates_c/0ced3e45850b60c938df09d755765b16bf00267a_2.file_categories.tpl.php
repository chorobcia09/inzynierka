<?php
/* Smarty version 5.6.0, created on 2025-10-20 18:21:46
  from 'file:categories.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f6619a8ead27_76764811',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0ced3e45850b60c938df09d755765b16bf00267a' => 
    array (
      0 => 'categories.tpl',
      1 => 1760977304,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f6619a8ead27_76764811 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-primary">Kategorie</h2>

<div class="alert alert-warning" role="alert">
W tym miejscu możesz przeglądać kategorie wraz z podkategoriami, które są dostępne w systemie globlanie, jak i loklanie (utworzone przez użytkownika).
</div>
<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>Nazwa</th>
            <th>Typ</th>
            <th>Zasięg</th>
            <th>Data dodania</th>
            <th>Data aktualizacji</th>
        </tr>
    </thead>
    <tbody>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('category'), 'category');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('category')->value) {
$foreach0DoElse = false;
?>
            <tr>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['name']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php if ($_smarty_tpl->getValue('category')['type'] == 'expense') {?>Wydatek <?php } else { ?> Przychód<?php }?></td>
                <td><?php $_prefixVariable1 = 1;
$_tmp_array = $_smarty_tpl->getValue('category') ?? [];
if (!(is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess)) {
settype($_tmp_array, 'array');
}
$_tmp_array['is_global'] = $_prefixVariable1;
$_smarty_tpl->assign('category', $_tmp_array, false, NULL);
if ($_prefixVariable1) {?> Globalna <?php } else { ?> Loklana<?php }?></td>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['created_at']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category')['updated_at']), ENT_QUOTES, 'UTF-8');?>
</td>
            </tr>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </tbody>
</table>



<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
