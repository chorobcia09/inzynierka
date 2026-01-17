<?php
/* Smarty version 5.6.0, created on 2026-01-17 14:42:21
  from 'file:users_family.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_696b91bde1c905_37854555',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8e300cf5e677cdbe32f4d3b622999c7baecdbafd' => 
    array (
      0 => 'users_family.tpl',
      1 => 1768657341,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_696b91bde1c905_37854555 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<style>
    /* Styl dla responsywności bez scrolla */
    .custom-table-container {
        overflow: hidden;
    }

    /* Ukrywanie tekstu "Usuń" na małych ekranach (poniżej 576px) */
    @media (max-width: 576px) {
        .btn-text {
            display: none;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.25rem !important;
            font-size: 0.85rem;
        }

        /* Styl dla badge roli na małych ekranach */
        .role-badge {
            font-size: 0.75rem;
            padding: 0.2rem 0.4rem;
            white-space: nowrap;
        }
    }

    /* Styl dla badge roli na większych ekranach */
    @media (min-width: 577px) {
        .role-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>

<div class="users-container bg-dark text-light p-4 rounded shadow bg-dark-subtle">
    <h2 class="mb-4 fw-bold text-primary text-light">Lista członków rodziny</h2>

    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['error'] ?? null)))) {?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['error']), ENT_QUOTES, 'UTF-8');?>

        </div>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
        <a href="index.php?action=addUserToFamily" class="btn btn-success mb-3">
            <i class="bi bi-person-plus"></i> Dodaj członka rodziny
        </a>
    <?php }?>

    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('users')) > 0) {?>
        <div class="shadow rounded custom-table-container">
            <table class="table table-dark table-bordered mb-0">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Użytkownik</th>
                        <th class="d-none d-md-table-cell">Rodzina</th>
                        <th>Rola</th>
                        <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                            <th style="width: 50px;">Akcja</th>
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
                            <td class="text-break fw-bold"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td class="text-break d-none d-md-table-cell"><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['family_name'] ?? null)===null||$tmp==='' ? '-' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->getValue('user')['family_role'] == 'family_admin') {?>
                                    <span class="badge bg-success role-badge">Administrator rodziny</span>
                                <?php } else { ?>
                                    <span class="badge bg-primary role-badge">Członek rodziny</span>
                                <?php }?>
                            </td>
                            <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                                <td class="text-center">
                                    <a href="index.php?action=deleteUserFromFamily&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['id']), ENT_QUOTES, 'UTF-8');?>
"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');"
                                        title="Usuń członka rodziny">
                                        <i class="bi bi-trash"></i><span class="btn-text ms-1">Usuń</span>
                                    </a>
                                </td>
                            <?php }?>
                        </tr>

                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                <tfoot class="d-md-none">
                    <tr>
                        <td colspan="<?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>5<?php } else { ?>4<?php }?>"
                            class="text-center small text-muted pt-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Rodzina: <strong><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('session')['family_name'] ?? null)===null||$tmp==='' ? 'Brak' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</strong>
                        </td>
                    </tr>
                </tfoot>
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
