<?php
/* Smarty version 5.6.0, created on 2025-10-25 19:15:42
  from 'file:feedback_panel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fd05bedac237_95003290',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da1069568a9fcef494254ee68ebf8f7ba12aba79' => 
    array (
      0 => 'feedback_panel.tpl',
      1 => 1761412541,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fd05bedac237_95003290 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-primary">Zarządzanie zgłoszeniami</h2>

<?php if ($_smarty_tpl->getValue('message')) {?>
    <div class="alert alert-info text-center bg-info bg-opacity-10 text-light border-0"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('message')), ENT_QUOTES, 'UTF-8');?>
</div>
<?php }?>

<form method="get" class="mb-3 d-flex align-items-center gap-2">
    <input type="hidden" name="action" value="feedbackPanel">
    <label for="filter_status" class="form-label mb-0">Filtruj po statusie:</label>
    <select name="status" id="filter_status" class="form-select form-select-sm bg-secondary text-light border-0"
        onchange="this.form.submit()">
        <option value="">Wszystkie</option>
        <option value="new" <?php if ($_smarty_tpl->getValue('filter_status') == 'new') {?>selected<?php }?>>Nowe</option>
        <option value="in_progress" <?php if ($_smarty_tpl->getValue('filter_status') == 'in_progress') {?>selected<?php }?>>W trakcie</option>
        <option value="resolved" <?php if ($_smarty_tpl->getValue('filter_status') == 'resolved') {?>selected<?php }?>>Rozwiązane</option>
    </select>
</form>

<div class="table-responsive shadow rounded">
    <table class="table table-striped table-bordered mb-0 table-dark align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>ID Użytkownika</th>
                <th>Typ</th>
                <th>Temat</th>
                <th>Opis</th>
                <th>Data utworzenia</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('feedback'), 'feedback');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('feedback')->value) {
$foreach0DoElse = false;
?>
                <tr class="align-middle">
                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['id']), ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['user_id']), ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['type']), ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['subject']), ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['message']), ENT_QUOTES, 'UTF-8');?>
</td>
                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['created_at']), ENT_QUOTES, 'UTF-8');?>
</td>
                    <td>
                        <form method="post" action="index.php?action=changeStatus" class="d-flex gap-2">
                            <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['id']), ENT_QUOTES, 'UTF-8');?>
">
                            <select name="status" class="form-select form-select-sm bg-secondary text-light border-0">
                                <option value="new" <?php if ($_smarty_tpl->getValue('feedback')['status'] == 'new') {?>selected<?php }?>>Nowy</option>
                                <option value="in_progress" <?php if ($_smarty_tpl->getValue('feedback')['status'] == 'in_progress') {?>selected<?php }?>>W trakcie
                                </option>
                                <option value="resolved" <?php if ($_smarty_tpl->getValue('feedback')['status'] == 'resolved') {?>selected<?php }?>>Rozwiązane</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Zmień</button>
                        </form>
                    </td>
                </tr>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
