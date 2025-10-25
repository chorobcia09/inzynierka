<?php
/* Smarty version 5.6.0, created on 2025-10-25 19:18:58
  from 'file:users_family.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fd0682d4e894_43398998',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8e300cf5e677cdbe32f4d3b622999c7baecdbafd' => 
    array (
      0 => 'users_family.tpl',
      1 => 1761412736,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fd0682d4e894_43398998 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="users-container bg-dark text-light p-4 rounded shadow" style="font-family: 'Inter', sans-serif;">
    <h2 class="mb-4 fw-bold text-primary text-light">Lista członków rodziny</h2>

    <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
        <a href="index.php?action=addUserToFamily" class="btn btn-success mb-3">
            <i class="bi bi-person-plus"></i> Dodaj członka rodziny
        </a>
    <?php }?>

    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('users')) > 0) {?>
        <div class="table-responsive shadow rounded">
            <table class="table table-dark table-bordered mb-0">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Nazwa użytkownika</th>
                        <th>Email</th>
                        <th>Rodzina</th>
                        <th>Rola w rodzinie</th>
                        <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                            <th>Akcje</th>
                        <?php }?>
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
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['email']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['family_name'] ?? null)===null||$tmp==='' ? 'Brak przydzielonej rodziny' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->getValue('user')['family_role'] == 'family_admin') {?>
                                    <span class="badge bg-success">Administrator rodziny</span>
                                <?php } elseif ($_smarty_tpl->getValue('user')['family_role'] == 'family_member') {?>
                                    <span class="badge bg-primary">Członek rodziny</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Brak przypisania</span>
                                <?php }?>
                            </td>
                            <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                                <td>
                                    <a href="index.php?action=deleteUserFromFamily&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['id']), ENT_QUOTES, 'UTF-8');?>
"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                        <i class="bi bi-trash"></i> Usuń członka rodziny
                                    </a>
                                </td>
                            <?php }?>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-info text-center mt-3 bg-info bg-opacity-25 border-0 text-dark">
            Brak przypisanych członków do rodziny.
        </div>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
        <div class="mt-4 pt-3 border-top border-secondary">
            <a href="index.php?action=deleteFamily" class="btn btn-danger"
                onclick="return confirm('Czy na pewno chcesz usunąć całą rodzinę? Ta operacja jest nieodwracalna!');">
                <i class="bi bi-trash"></i> Usuń rodzinę
            </a>
        </div>
    <?php }?>
</div>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
