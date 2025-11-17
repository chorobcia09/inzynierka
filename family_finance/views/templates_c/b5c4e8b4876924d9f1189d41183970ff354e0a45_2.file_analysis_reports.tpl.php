<?php
/* Smarty version 5.6.0, created on 2025-11-17 16:48:28
  from 'file:analysis_reports.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_691b43ccdbb9a4_35845748',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b5c4e8b4876924d9f1189d41183970ff354e0a45' => 
    array (
      0 => 'analysis_reports.tpl',
      1 => 1763394452,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_691b43ccdbb9a4_35845748 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<h2 class="mb-4 text-light-emphasis">Raporty finansowe (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
)</h2>

<div class="row g-4">

    <!-- Wybór okresu -->
    <div class="col-md-4">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Wybierz okres raportu</h5>
            <form method="get" action="index.php">
                <input type="hidden" name="action" value="analysisReports">
                <div class="mb-3">
                    <select name="period" class="form-select bg-dark text-light">
                        <option value="monthly" <?php if ($_smarty_tpl->getValue('period') == 'monthly') {?>selected<?php }?>>Miesięczny</option>
                        <option value="quarterly" <?php if ($_smarty_tpl->getValue('period') == 'quarterly') {?>selected<?php }?>>Kwartalny</option>
                        <option value="yearly" <?php if ($_smarty_tpl->getValue('period') == 'yearly') {?>selected<?php }?>>Roczny</option>
                        <option value="custom" <?php if ($_smarty_tpl->getValue('period') == 'custom') {?>selected<?php }?>>Niestandardowy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Pokaż raport</button>
            </form>
        </div>
    </div>

    <!-- Dostępne raporty -->
    <div class="col-md-8">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Dostępne raporty</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport podsumowania
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
&type=summary" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg kategorii
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
&type=categories" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg płatności
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
&type=payments" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport budżet vs wydatki
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
&type=budget" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport top wydatków
                    <a href="index.php?action=analysisPdf&period=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('period')), ENT_QUOTES, 'UTF-8');?>
&type=top" class="btn btn-sm btn-danger">
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
