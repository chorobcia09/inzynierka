<?php
/* Smarty version 5.6.0, created on 2025-10-16 19:33:16
  from 'file:login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f12c5c1291b7_09208146',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b68ed31ae1b2eff7702baa28c983c0f516867da' => 
    array (
      0 => 'login.tpl',
      1 => 1760635975,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f12c5c1291b7_09208146 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="login-container mx-auto shadow p-4 rounded" style="max-width:400px;">
    <h2 class="text-center mb-4">Logowanie</h2>

    <?php if ($_smarty_tpl->getValue('error')) {?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>

    <form method="post" action="index.php?action=login">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Hasło</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Zaloguj się</button>
    </form>
</div>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
