<?php
/* Smarty version 5.6.0, created on 2026-01-19 18:11:35
  from 'file:admin_panel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_696e65c7a28825_04255582',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3109ee7d5a8cde23b272d8861fff9b81f35827c2' => 
    array (
      0 => 'admin_panel.tpl',
      1 => 1768842694,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_696e65c7a28825_04255582 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<style>
    .table-wrapper {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.45);
    }

    .table-scroll {
        overflow-x: auto;
    }
</style>

<div class="container mt-5">

    <h2 class="mb-4 text-light-emphasis">Panel administratora</h2>

    <a href="index.php?action=addUserForm" class="btn btn-success mb-4">
        <i class="bi bi-person-plus"></i> Dodaj użytkownika
    </a>

    <div class="table-wrapper">
        <div class="table-scroll">
            <table class="table table-dark table-striped align-middle mb-0 rounded-4">

                <thead class="table-success text-dark">
                    <tr>
                        <th>ID</th>
                        <th>ID Rodziny</th>
                        <th>Imię</th>
                        <th>Email</th>
                        <th>Rodzaj konta</th>
                        <th>Rodzina</th>
                        <th>Rola</th>
                        <th>Rola w rodzinie</th>
                        <th class="text-center">Akcje</th>
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
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['family_id']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="fw-semibold"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['email']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['account_type']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['family_name'] ?? null)===null||$tmp==='' ? 'Brak' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</td>

                            <td>
                                <?php if ($_smarty_tpl->getValue('user')['role'] == 'admin') {?>
                                    <span class="badge bg-danger">Administrator</span>
                                <?php } else { ?>
                                    <span class="badge bg-warning text-dark">Użytkownik</span>
                                <?php }?>
                            </td>

                            <td>
                                <?php if ($_smarty_tpl->getValue('user')['family_role'] == 'family_admin') {?>
                                    <span class="badge bg-success">Administrator rodziny</span>
                                <?php } elseif ($_smarty_tpl->getValue('user')['family_role'] == 'family_member') {?>
                                    <span class="badge bg-primary">Członek rodziny</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary text-dark">Brak</span>
                                <?php }?>
                            </td>

                            <td class="text-center">
                                <a href="index.php?action=editUser&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['id']), ENT_QUOTES, 'UTF-8');?>
"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="index.php?action=deleteUser&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>

                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </tbody>

            </table>

        </div>
    </div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
