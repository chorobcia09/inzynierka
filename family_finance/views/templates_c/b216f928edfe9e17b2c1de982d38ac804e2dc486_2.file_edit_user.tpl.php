<?php
/* Smarty version 5.6.0, created on 2025-10-25 19:15:09
  from 'file:edit_user.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fd059d7eeeb0_08820786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b216f928edfe9e17b2c1de982d38ac804e2dc486' => 
    array (
      0 => 'edit_user.tpl',
      1 => 1761412507,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fd059d7eeeb0_08820786 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="mx-auto shadow p-4 rounded bg-dark text-light" style="max-width:500px;">
    <h2 class="mb-4 text-center text-primary text-light">Edytuj użytkownika</h2>

        <?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
        <div class="alert alert-danger"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>

    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="username" class="form-label">Imię użytkownika</label>
            <input type="text" name="username" class="form-control bg-secondary text-light border-0"
                value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control bg-secondary text-light border-0" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['email']), ENT_QUOTES, 'UTF-8');?>
"
                required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nowe hasło (pozostaw puste aby nie zmieniać)</label>
            <input type="password" name="password" class="form-control bg-secondary text-light border-0">
            <div class="form-text text-light">Wpisz nowe hasło tylko jeśli chcesz je zmienić.</div>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rola</label>
            <select name="role" class="form-select bg-secondary text-light border-0">
                <option value="member" <?php if ($_smarty_tpl->getValue('user')['role'] == 'member') {?>selected<?php }?>>Użytkownik</option>
                <option value="admin" <?php if ($_smarty_tpl->getValue('user')['role'] == 'admin') {?>selected<?php }?>>Administrator</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="family_id" class="form-label">ID Rodziny (opcjonalnie)</label>
            <input type="number" name="family_id" class="form-control bg-secondary text-light border-0"
                value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['family_id']), ENT_QUOTES, 'UTF-8');?>
">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            <a href="index.php?action=adminPanel" class="btn btn-secondary">Anuluj</a>
        </div>
    </form>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
