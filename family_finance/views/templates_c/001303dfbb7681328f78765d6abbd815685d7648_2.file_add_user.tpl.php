<?php
/* Smarty version 5.6.0, created on 2025-10-17 18:14:44
  from 'file:add_user.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f26b742190c6_18117188',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '001303dfbb7681328f78765d6abbd815685d7648' => 
    array (
      0 => 'add_user.tpl',
      1 => 1760717649,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f26b742190c6_18117188 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2>Dodaj użytkownika</h2>

<?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
    <div class="alert alert-danger"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
<?php }?>

<form method="post" class="mt-4">
    <div class="mb-3">
        <label for="username" class="form-label">Imię użytkownika</label>
        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars((string) ((($tmp = $_POST['username'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars((string) ((($tmp = $_POST['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Hasło</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Rola</label>
        <select name="role" class="form-select">
            <option value="member">Użytkownik</option>
            <option value="admin">Administrator</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Zapisz</button>
</form>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
