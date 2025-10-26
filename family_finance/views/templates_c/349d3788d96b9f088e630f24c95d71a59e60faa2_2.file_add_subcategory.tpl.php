<?php
/* Smarty version 5.6.0, created on 2025-10-26 15:05:14
  from 'file:add_subcategory.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fe2a9a61bbf6_49130778',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '349d3788d96b9f088e630f24c95d71a59e60faa2' => 
    array (
      0 => 'add_subcategory.tpl',
      1 => 1761487179,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fe2a9a61bbf6_49130778 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>



<h2 class="mb-4 text-light-emphasis">Dodaj podkategorię do kategorii: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category_name')), ENT_QUOTES, 'UTF-8');?>
</h2>

<div class="alert alert-info alert-dark" role="alert">
    Tutaj możesz dodać nową podkategorię do wybranej kategorii głównej. Jest ona widoczna tylko dla Ciebie i dla Twojej rodziny.
</div>

<form method="post" action="index.php?action=addSubCategory">
    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category_id')), ENT_QUOTES, 'UTF-8');?>
">

    <div class="mb-3">
        <label for="name" class="form-label">Nazwa podkategorii:</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Dodaj podkategorię</button>
    <a href="index.php?action=viewCategory&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('category_id')), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-secondary">Anuluj</a>
</form>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
