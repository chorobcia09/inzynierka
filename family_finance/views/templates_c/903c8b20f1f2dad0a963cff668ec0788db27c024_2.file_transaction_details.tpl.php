<?php
/* Smarty version 5.6.0, created on 2025-10-22 19:21:31
  from 'file:transaction_details.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f9129b8d1570_29375838',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '903c8b20f1f2dad0a963cff668ec0788db27c024' => 
    array (
      0 => 'transaction_details.tpl',
      1 => 1761153689,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f9129b8d1570_29375838 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
<div class="container mt-4">
    <h2 class="mb-4 text-primary">Szczegóły transakcji</h2>

    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('transaction')) > 0) {?>
        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="table-primary">
                    <tr>
                        <th>Podkategoria</th>
                        <th>Cena za szt.</th>
                        <th>Ilość</th>
                        <th>Wartość</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $_smarty_tpl->assign('total', 0, false, NULL);?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('transaction'), 'trans');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('trans')->value) {
$foreach0DoElse = false;
?>
                        <?php $_smarty_tpl->assign('line_total', $_smarty_tpl->getValue('trans')['amount']*$_smarty_tpl->getValue('trans')['quantity'], false, NULL);?>
                        <?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('math')->handle(array('equation'=>"total + line",'total'=>$_smarty_tpl->getValue('total'),'line'=>$_smarty_tpl->getValue('line_total'),'assign'=>"total"), $_smarty_tpl);?>

                        <tr>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trans')['sub_category_name']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trans')['amount']), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trans')['transaction_currency']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trans')['quantity']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('line_total')), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trans')['transaction_currency']), ENT_QUOTES, 'UTF-8');?>
</td>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>

            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <tbody class="table-info">
                    <tr>
                        <td><strong>Suma:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('total')), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('trans')['transaction_currency']), ENT_QUOTES, 'UTF-8');?>
</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-2">
            <a href="index.php?action=manageTransactions" class="btn btn-secondary">
                <i class="bi bi-arrow-90deg-left"></i> Wróć
            </a>
        </div>

    <?php } else { ?>
        <div class="alert alert-info text-center mt-3">Brak szczegółow transakcji.</div>
    <?php }?>
</div>
<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
