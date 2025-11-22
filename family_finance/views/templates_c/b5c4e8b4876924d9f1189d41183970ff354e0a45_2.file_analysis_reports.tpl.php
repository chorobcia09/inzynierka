<?php
/* Smarty version 5.6.0, created on 2025-11-22 14:39:14
  from 'file:analysis_reports.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6921bd02337261_06330119',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b5c4e8b4876924d9f1189d41183970ff354e0a45' => 
    array (
      0 => 'analysis_reports.tpl',
      1 => 1763584073,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6921bd02337261_06330119 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Raporty finansowe</h2>

<div class="row g-4">

    <!-- Wybór okresu -->
    <div class="col-md-4">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Wybierz zakres dat</h5>
            <form method="get" action="index.php">
                <input type="hidden" name="action" value="analysisReports">

                <div class="mb-3">
                    <label for="date_from" class="form-label">Od</label>
                    <input type="date" name="date_from" id="date_from" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('date_from')), ENT_QUOTES, 'UTF-8');?>
"
                        class="form-control bg-dark text-light">
                </div>
                <div class="mb-3">
                    <label for="date_to" class="form-label">Do</label>
                    <input type="date" name="date_to" id="date_to" value="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('date_to')), ENT_QUOTES, 'UTF-8');?>
"
                        class="form-control bg-dark text-light">
                </div>

                <button type="submit" class="btn btn-primary w-100">Pokaż dane</button>
            </form>
        </div>
    </div>

    <!-- Dostępne raporty -->
    <div class="col-md-8">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Dostępne raporty</h5>
            <ul class="list-group list-group-flush">
                <?php $_smarty_tpl->assign('dateParams', "&date_from=".((string)$_smarty_tpl->getValue('date_from'))."&date_to=".((string)$_smarty_tpl->getValue('date_to')), false, NULL);?>

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport podsumowania
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('period') ?? null)===null||$tmp==='' ? 'monthly' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
&type=summary<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('dateParams')), ENT_QUOTES, 'UTF-8');?>
"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg kategorii
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('period') ?? null)===null||$tmp==='' ? 'monthly' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
&type=categories<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('dateParams')), ENT_QUOTES, 'UTF-8');?>
"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg płatności
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('period') ?? null)===null||$tmp==='' ? 'monthly' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
&type=payments<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('dateParams')), ENT_QUOTES, 'UTF-8');?>
"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport top wydatków
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('period') ?? null)===null||$tmp==='' ? 'monthly' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
&type=top<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('dateParams')), ENT_QUOTES, 'UTF-8');?>
"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
