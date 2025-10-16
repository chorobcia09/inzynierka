<?php
/* Smarty version 5.6.0, created on 2025-10-16 21:09:36
  from 'file:panel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f142f095b438_05969961',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c910ae6a0b0f705df3d5dde92d429a02e8266750' => 
    array (
      0 => 'panel.tpl',
      1 => 1760641734,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f142f095b438_05969961 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2>Panel użytkownika</h2>

<p><strong>Imię:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['username']), ENT_QUOTES, 'UTF-8');?>
</p>
<p><strong>Email:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['email']), ENT_QUOTES, 'UTF-8');?>
</p>
<p><strong>Rodzina ID:</strong> <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('user')['family_id'] ?? null)===null||$tmp==='' ? 'Brak przypisanej rodziny' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</p>
<p><strong>Rola:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['role']), ENT_QUOTES, 'UTF-8');?>
</p>
<p><strong>Rodzaj konta:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['account_type']), ENT_QUOTES, 'UTF-8');?>
</p>



<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
