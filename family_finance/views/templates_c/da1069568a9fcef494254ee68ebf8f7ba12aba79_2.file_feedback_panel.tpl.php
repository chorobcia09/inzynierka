<?php
/* Smarty version 5.6.0, created on 2026-01-19 18:05:29
  from 'file:feedback_panel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_696e6459b49c64_55326703',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da1069568a9fcef494254ee68ebf8f7ba12aba79' => 
    array (
      0 => 'feedback_panel.tpl',
      1 => 1768842328,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_696e6459b49c64_55326703 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<style>
    .table-wrapper {
        border-radius: 1rem;
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.45);
        overflow: hidden;
    }

    table {
        width: 100%;
        table-layout: fixed;
    }

    td, th {
        word-wrap: break-word;
        white-space: normal;
        vertical-align: top;
    }

    /* ===== MOBILE META INFO ===== */
    .mobile-meta {
        display: none;
        font-size: 0.75rem;
        margin-top: 0.4rem;
        opacity: 0.85;
    }

    .mobile-meta span {
        display: inline-block;
        background: rgba(255,255,255,0.1);
        border-radius: 0.5rem;
        padding: 0.15rem 0.45rem;
        margin: 0.1rem 0.1rem 0 0;
    }

    /* ===== MOBILE VIEW ===== */
    @media (max-width: 768px) {

        /* ukrycie kolumn */
        .col-user,
        .col-type,
        .col-date {
            display: none;
        }

        .mobile-meta {
            display: block;
        }

        .table-wrapper {
            overflow-x: hidden;
        }

        td, th {
            font-size: 0.85rem;
            padding: 0.5rem;
        }

        select.form-select-sm,
        button.btn-sm {
            font-size: 0.75rem;
        }
    }
</style>

<h2 class="mb-4 text-light-emphasis">Zarządzanie zgłoszeniami</h2>

<?php if ($_smarty_tpl->getValue('message')) {?>
    <div class="alert alert-info text-center bg-info bg-opacity-10 text-light border-0">
        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('message')), ENT_QUOTES, 'UTF-8');?>

    </div>
<?php }?>

<form method="get" class="mb-3 d-flex align-items-center gap-2">
    <input type="hidden" name="action" value="feedbackPanel">

    <label for="filter_status" class="form-label mb-0">
        Filtruj po statusie:
    </label>

    <select name="status"
            id="filter_status"
            class="form-select form-select-sm bg-secondary text-light border-0"
            onchange="this.form.submit()">

        <option value="">Wszystkie</option>
        <option value="new" <?php if ($_smarty_tpl->getValue('filter_status') == 'new') {?>selected<?php }?>>Nowe</option>
        <option value="in_progress" <?php if ($_smarty_tpl->getValue('filter_status') == 'in_progress') {?>selected<?php }?>>W trakcie</option>
        <option value="resolved" <?php if ($_smarty_tpl->getValue('filter_status') == 'resolved') {?>selected<?php }?>>Rozwiązane</option>
    </select>
</form>

<div class="table-wrapper">
    <table class="table table-dark table-striped table-bordered mb-0">

        <thead class="table-success text-dark">
            <tr>
                <th>ID</th>
                <th class="col-user">Użytkownik</th>
                <th class="col-type">Typ</th>
                <th>Temat</th>
                <th>Opis</th>
                <th class="col-date">Data</th>
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
                <tr>
                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['id']), ENT_QUOTES, 'UTF-8');?>
</td>

                    <td class="col-user"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['user_id']), ENT_QUOTES, 'UTF-8');?>
</td>

                    <td class="col-type"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['type']), ENT_QUOTES, 'UTF-8');?>
</td>

                    <td class="fw-semibold">
                        <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['subject']), ENT_QUOTES, 'UTF-8');?>


                        <!-- MOBILE META -->
                        <div class="mobile-meta">
                            <span>User ID: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['user_id']), ENT_QUOTES, 'UTF-8');?>
</span>
                            <span>Typ: <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['type']), ENT_QUOTES, 'UTF-8');?>
</span>
                            <span><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['created_at']), ENT_QUOTES, 'UTF-8');?>
</span>
                        </div>
                    </td>

                    <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['message']), ENT_QUOTES, 'UTF-8');?>
</td>

                    <td class="col-date"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['created_at']), ENT_QUOTES, 'UTF-8');?>
</td>

                    <td>
                        <form method="post"
                              action="index.php?action=changeStatus"
                              class="d-flex flex-column flex-md-row gap-2">

                            <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('feedback')['id']), ENT_QUOTES, 'UTF-8');?>
">

                            <select name="status"
                                    class="form-select form-select-sm bg-secondary text-light border-0">

                                <option value="new" <?php if ($_smarty_tpl->getValue('feedback')['status'] == 'new') {?>selected<?php }?>>Nowy</option>
                                <option value="in_progress" <?php if ($_smarty_tpl->getValue('feedback')['status'] == 'in_progress') {?>selected<?php }?>>
                                    W trakcie
                                </option>
                                <option value="resolved" <?php if ($_smarty_tpl->getValue('feedback')['status'] == 'resolved') {?>selected<?php }?>>
                                    Rozwiązane
                                </option>
                            </select>

                            <button type="submit" class="btn btn-sm btn-primary">
                                Zmień
                            </button>
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
