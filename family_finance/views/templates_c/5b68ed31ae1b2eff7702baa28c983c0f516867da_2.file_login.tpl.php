<?php
/* Smarty version 5.6.0, created on 2025-10-26 11:39:59
  from 'file:login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fdfa7fa58013_33176538',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b68ed31ae1b2eff7702baa28c983c0f516867da' => 
    array (
      0 => 'login.tpl',
      1 => 1761473612,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fdfa7fa58013_33176538 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="login-container mx-auto shadow p-4 rounded "
    style="max-width:400px;">
    <h2 class="text-center mb-4 fw-bold text-primary text-light">Logowanie</h2>

    <?php if ($_smarty_tpl->getValue('error')) {?>
        <div class="alert alert-danger text-center bg-danger bg-opacity-25 border-0"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>

    <form method="post" action="index.php?action=login">
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control rounded bg-secondary text-light border-0" name="email" id="email"
                placeholder="Wpisz email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Hasło</label>
            <input type="password" class="form-control rounded bg-secondary text-light border-0" name="password" id="password"
                placeholder="Wpisz hasło" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold">Zaloguj się</button>
    </form>

    <div class="text-center mt-3">
        <small>Nie masz konta? <a href="index.php?action=register" class="text-primary fw-bold">Zarejestruj się</a></small>
    </div>
</div>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
