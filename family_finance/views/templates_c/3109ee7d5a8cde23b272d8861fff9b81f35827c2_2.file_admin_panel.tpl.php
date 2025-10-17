<?php
/* Smarty version 5.6.0, created on 2025-10-17 18:02:21
  from 'file:admin_panel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f2688db3a7d8_94740634',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3109ee7d5a8cde23b272d8861fff9b81f35827c2' => 
    array (
      0 => 'admin_panel.tpl',
      1 => 1760716940,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f2688db3a7d8_94740634 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-primary">Panel administratora</h2>

<a href="index.php?action=addUserForm" class="btn btn-success mb-3">
    <i class="bi bi-person-plus"></i> Dodaj użytkownika
</a>

<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Email</th>
            <th>Rodzina</th>
            <th>Rola</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('users'), 'user');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('user')->value) {
$foreach0DoElse = false;
?>
            <tr>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['id']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['email']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['family_name'] ?? null)===null||$tmp==='' ? 'Brak' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</td>
                <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['role']), ENT_QUOTES, 'UTF-8');?>
</td>
                <td>
                    <a href="index.php?action=editUser&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edytuj
                    </a>
                    <a href="index.php?action=deleteUser&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-outline-danger" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                        <i class="bi bi-trash"></i> Usuń
                    </a>
                </td>
            </tr>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </tbody>
</table>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
