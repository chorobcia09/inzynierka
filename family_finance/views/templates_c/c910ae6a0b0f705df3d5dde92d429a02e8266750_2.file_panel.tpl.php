<?php
/* Smarty version 5.6.0, created on 2025-10-25 19:03:09
  from 'file:panel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fd02cd684232_20360302',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c910ae6a0b0f705df3d5dde92d429a02e8266750' => 
    array (
      0 => 'panel.tpl',
      1 => 1761411788,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fd02cd684232_20360302 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="user-panel-container mx-auto shadow-lg p-4 rounded-4 bg-dark-subtle text-light"
    style="max-width:600px; font-family: 'Inter', sans-serif;">
    <h2 class="text-center mb-4 fw-bold text-light-emphasis">Panel użytkownika</h2>

    <ul class="list-group list-group-flush rounded-3 overflow-hidden">
        <li class="list-group-item bg-dark text-light"><strong>Nazwa użytkownika:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
</li>
        <li class="list-group-item bg-dark text-light"><strong>Email:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['email']), ENT_QUOTES, 'UTF-8');?>
</li>
        <li class="list-group-item bg-dark text-light">
            <strong>Rodzina:</strong> <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['family_name'] ?? null)===null||$tmp==='' ? 'Brak przypisanej rodziny' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>

        </li>
        <li class="list-group-item bg-dark text-light">
            <strong>Rola:</strong>
            <?php if ($_smarty_tpl->getValue('user')['family_role'] == 'family_admin') {?>
                <span class="badge bg-success bg-opacity-75">Administrator rodziny</span>
            <?php } elseif ($_smarty_tpl->getValue('user')['family_role'] == 'family_member') {?>
                <span class="badge bg-primary bg-opacity-75">Członek rodziny</span>
            <?php } else { ?>
                <span class="badge bg-secondary bg-opacity-75">Brak przypisania</span>
            <?php }?>
        </li>
        <li class="list-group-item bg-dark text-light"><strong>Rodzaj konta:</strong>
            <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['account_type'] ?? null)===null||$tmp==='' ? 'Brak' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</li>
        <li class="list-group-item bg-dark text-light"><strong>UID:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['UID']), ENT_QUOTES, 'UTF-8');?>
</li>
    </ul>

    <div class="text-center mt-4">
        <a href="index.php?action=dashboard" class="btn btn-light text-dark fw-semibold me-2">Dashboard</a>
        <a href="index.php?action=usersFamily" class="btn btn-outline-light fw-semibold">Członkowie rodziny</a>
    </div>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
