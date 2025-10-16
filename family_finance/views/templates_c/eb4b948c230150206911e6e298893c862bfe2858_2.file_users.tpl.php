<?php
/* Smarty version 5.6.0, created on 2025-10-16 19:34:53
  from 'file:users.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f12cbd78f587_42938350',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb4b948c230150206911e6e298893c862bfe2858' => 
    array (
      0 => 'users.tpl',
      1 => 1760635983,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f12cbd78f587_42938350 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4">Lista użytkowników</h2>

<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('users')) > 0) {?>
<table class="table table-striped table-bordered">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Email</th>
            <th>ID Rodziny</th>
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
            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('user')['family_id']), ENT_QUOTES, 'UTF-8');?>
</td>
        </tr>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </tbody>
</table>
<?php } else { ?>
    <div class="alert alert-info">Brak użytkowników w bazie danych.</div>
<?php }?>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
