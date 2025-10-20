<?php
/* Smarty version 5.6.0, created on 2025-10-19 20:49:46
  from 'file:add_user_to_family.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f532cab7f092_90694712',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ce93c687b699a83b3d099274374a63b24190efaf' => 
    array (
      0 => 'add_user_to_family.tpl',
      1 => 1760874465,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f532cab7f092_90694712 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4 text-primary">Dodaj użytkownika do rodziny</h2>

    <?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
        <div class="alert alert-danger"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>

    <?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
        <div class="alert alert-success"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('success')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>
    <div class="alert alert-danger" role="alert">
        UWAGA! W MOMENCIE DODAWANIA UŻYTKOWNIKA DO RODZINY, KTÓRY POSIADA JUŻ JAKIEŚ TRANSAKCJE, JEGO TRANSAKCJE NIE
        ZOSTANĄ DODANE DO TRANSAKCJI RODZINNYCH!
    </div>

    <form method="POST" action="index.php?action=addUserToFamily">
        <div class="mb-3">
            <label for="UID" class="form-label">Kod UID użytkownika</label>
            <input type="text" class="form-control" id="UID" name="UID" placeholder="Wpisz kod UID" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Dodaj użytkownika</button>
    </form>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
