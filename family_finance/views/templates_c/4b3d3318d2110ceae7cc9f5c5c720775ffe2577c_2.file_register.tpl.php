<?php
/* Smarty version 5.6.0, created on 2025-10-16 22:20:23
  from 'file:register.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f153872efb21_91494795',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4b3d3318d2110ceae7cc9f5c5c720775ffe2577c' => 
    array (
      0 => 'register.tpl',
      1 => 1760646019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f153872efb21_91494795 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="register-container mx-auto shadow p-4 rounded" style="max-width:400px; font-family: 'Inter', sans-serif; background-color: #ffffff;">
    <h2 class="text-center mb-4 fw-bold text-primary">Rejestracja</h2>

    <?php if ($_smarty_tpl->getValue('error')) {?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>

    <form method="post" action="index.php?action=register">
        <div class="mb-3">
            <label for="username" class="form-label fw-semibold">Imię użytkownika</label>
            <input type="text" class="form-control rounded" name="username" id="username" placeholder="Wpisz imię" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control rounded" name="email" id="email" placeholder="Wpisz email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Hasło</label>
            <input type="password" class="form-control rounded" name="password" id="password" placeholder="Wpisz hasło" required>
        </div>

        <div class="mb-3">
            <label for="password_confirm" class="form-label fw-semibold">Powtórz hasło</label>
            <input type="password" class="form-control rounded" name="password_confirm" id="password_confirm" placeholder="Powtórz hasło" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold">Zarejestruj się</button>
    </form>

    <div class="text-center mt-3">
        <small>Masz już konto? <a href="index.php?action=login" class="text-primary fw-bold">Zaloguj się</a></small>
    </div>
</div>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
