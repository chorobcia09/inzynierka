<?php
/* Smarty version 5.6.0, created on 2025-10-16 19:34:40
  from 'file:footer.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f12cb0e2be56_84531099',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f5302a207ca4cc58bc9019982b4d460f3020792c' => 
    array (
      0 => 'footer.tpl',
      1 => 1760636076,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68f12cb0e2be56_84531099 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
?></main>
<footer class="bg-light text-center py-3 mt-auto border-top">
    <p class="m-0">&copy; <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')(time(),"%Y")), ENT_QUOTES, 'UTF-8');?>
 Zarządzanie finansami rodzinnymi.</p>

</footer>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
