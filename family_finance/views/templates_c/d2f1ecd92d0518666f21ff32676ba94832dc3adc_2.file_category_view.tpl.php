<?php
/* Smarty version 5.6.0, created on 2025-10-20 18:42:43
  from 'file:category_view.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f6668346f170_74589055',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd2f1ecd92d0518666f21ff32676ba94832dc3adc' => 
    array (
      0 => 'category_view.tpl',
      1 => 1760978561,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f6668346f170_74589055 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-primary">Podkategorie</h2>

<div class="alert alert-info">
    Wyświetlono podkategorie dla wybranej kategorii.
</div>

<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>Nazwa</th>
            <th>Data dodania</th>
            <th>Data aktualizacji</th>
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
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('sub')['name']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('sub')['created_at']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('sub')['updated_at']), ENT_QUOTES, 'UTF-8');?>
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

<a href="index.php?action=categories" class="btn btn-secondary mt-3">← Powrót do listy kategorii</a>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
