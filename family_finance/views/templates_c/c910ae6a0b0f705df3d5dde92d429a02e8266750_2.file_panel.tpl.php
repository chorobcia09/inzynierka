<?php
/* Smarty version 5.6.0, created on 2025-10-16 22:24:49
  from 'file:panel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f15491412f12_63521563',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c910ae6a0b0f705df3d5dde92d429a02e8266750' => 
    array (
      0 => 'panel.tpl',
      1 => 1760646273,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f15491412f12_63521563 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="user-panel-container mx-auto shadow p-4 rounded" style="max-width:600px; font-family: 'Inter', sans-serif; background-color: #ffffff;">
    <h2 class="text-center mb-4 fw-bold text-primary">Panel użytkownika</h2>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Imię:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
</li>
        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['email']), ENT_QUOTES, 'UTF-8');?>
</li>
        <li class="list-group-item"><strong>Rodzina:</strong> <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['family_name'] ?? null)===null||$tmp==='' ? 'Brak przypisanej rodziny' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</li>
        <li class="list-group-item"><strong>Rola:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['role']), ENT_QUOTES, 'UTF-8');?>
</li>
        <li class="list-group-item"><strong>Rodzaj konta:</strong> <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['account_type'] ?? null)===null||$tmp==='' ? 'Brak' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</li>
    </ul>

    <div class="text-center mt-4">
        <a href="index.php?action=dashboard" class="btn btn-primary me-2">Dashboard</a>
        <a href="index.php?action=users" class="btn btn-outline-primary">Lista użytkowników</a>
    </div>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
