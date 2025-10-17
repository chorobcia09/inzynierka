<?php
/* Smarty version 5.6.0, created on 2025-10-17 19:01:58
  from 'file:create_family.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f2768613c335_03386190',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48a0f8ec1772a863fe785c2be643794041dee406' => 
    array (
      0 => 'create_family.tpl',
      1 => 1760720491,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f2768613c335_03386190 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="mx-auto shadow p-4 rounded" style="max-width:400px;">
    <h2 class="text-center mb-4">Utwórz rodzinę</h2>

    <?php if ($_smarty_tpl->getValue('error')) {?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('success')) {?>
        <div class="alert alert-success text-center"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('success')), ENT_QUOTES, 'UTF-8');?>
</div>
    <?php }?>

    <form method="post" action="index.php?action=createFamily">
        <div class="mb-3">
            <label for="family_name" class="form-label">Nazwa rodziny</label>
            <input type="text" name="family_name" id="family_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="region" class="form-label">Region</label>
            <select name="region" id="region" class="form-select" required>
                <option value="">Wybierz województwo</option>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('voivodeships'), 'voivodeship');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('voivodeship')->value) {
$foreach0DoElse = false;
?>
                    <option value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('voivodeship')), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('capitalize')($_smarty_tpl->getValue('voivodeship'))), ENT_QUOTES, 'UTF-8');?>
</option>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Utwórz rodzinę</button>
    </form>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
