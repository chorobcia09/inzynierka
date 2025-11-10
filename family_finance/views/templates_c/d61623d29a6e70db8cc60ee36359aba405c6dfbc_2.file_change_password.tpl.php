<?php
/* Smarty version 5.6.0, created on 2025-11-10 16:26:59
  from 'file:change_password.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_69120443819271_15170948',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd61623d29a6e70db8cc60ee36359aba405c6dfbc' => 
    array (
      0 => 'change_password.tpl',
      1 => 1762788394,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_69120443819271_15170948 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container py-5" style="max-width: 600px;">
    <div class="card bg-dark-subtle text-light shadow-lg p-4 rounded-4">
        <h3 class="text-center mb-4 fw-bold text-light-emphasis">
            <i class="bi bi-lock-fill me-2"></i> Zmień hasło
        </h3>

        <?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('success')), ENT_QUOTES, 'UTF-8');?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php }?>

        <?php if ((true && ($_smarty_tpl->hasVariable('errors') && null !== ($_smarty_tpl->getValue('errors') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('errors')) > 0) {?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('errors'), 'error');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('error')->value) {
$foreach0DoElse = false;
?>
                        <li><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('error')), ENT_QUOTES, 'UTF-8');?>
</li>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php }?>

        <form method="POST" action="index.php?action=changePassword">
            <div class="mb-3">
                <label for="current_password" class="form-label fw-semibold">Aktualne hasło:</label>
                <input type="password" class="form-control bg-dark text-light" id="current_password" name="current_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label fw-semibold">Nowe hasło:</label>
                <input type="password" class="form-control bg-dark text-light" id="new_password" name="new_password" required>
                <div class="form-text text-light-emphasis">Hasło musi mieć co najmniej 8 znaków.</div>
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="form-label fw-semibold">Potwierdź nowe hasło:</label>
                <input type="password" class="form-control bg-dark text-light" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php?action=panel" class="btn btn-outline-light fw-semibold">
                    <i class="bi bi-arrow-left"></i> Powrót
                </a>
                <button type="submit" class="btn btn-success fw-semibold">
                    <i class="bi bi-save"></i> Zapisz zmiany
                </button>
            </div>
        </form>
    </div>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
