<?php
/* Smarty version 5.6.0, created on 2025-10-19 13:39:09
  from 'file:manage_transactions.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f4cdddab4423_44791930',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28c54071631267fbcf994c251e43738947422a52' => 
    array (
      0 => 'manage_transactions.tpl',
      1 => 1760873948,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f4cdddab4423_44791930 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>


<h2 class="mb-4 text-primary">Zarządzaj transakcjami</h2>

<a href="index.php?action=addTransaction" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Dodaj transakcję
</a>

<?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_member' || $_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('transactions')) > 0) {?>
        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="table-primary">
                    <tr >
                        <th>ID Transakcji</th>
                        <th>Nazwa użytkownika</th>
                        <th>Kategoria</th>
                        <th>Typ</th>
                        <th>Wartość</th>
                        <th>Waluta</th>
                        <th>Forma płatności</th>
                        <th>Opis</th>
                        <th>Data transakcji</th>
                        <th>Cykliczność</th>
                        <th>Data dodania</th>
                        <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                            <th>Akcje</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('transactions'), 'transaction');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('transaction')->value) {
$foreach0DoElse = false;
?>
                        <tr class="<?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>table-success<?php } else { ?>table-danger<?php }?>">
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['user_name']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['category_name']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>
                                    Przychód
                                <?php } else { ?>
                                    Wydatek
                                <?php }?></td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['amount']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['currency']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php if ($_smarty_tpl->getValue('transaction')['payment_method'] == 'card') {?>
                                    Karta płatnicza
                                <?php } elseif ($_smarty_tpl->getValue('transaction')['payment_method'] == 'cash') {?>
                                    Gotówka
                                <?php } else { ?>
                                    Kryptowaluta
                                <?php }?></td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['description']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_date']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php if ($_smarty_tpl->getValue('transaction')['is_recurring'] == 1) {?>
                                Tak<?php } else { ?> Nie
                                <?php }?></td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('transaction')['created_at'],"%Y-%m-%d %H:%M:%S")), ENT_QUOTES, 'UTF-8');?>
</td>


                            <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                                <td>
                                    <a href="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edytuj
                                    </a>
                                    <a href="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                        <i class="bi bi-trash"></i> Usuń
                                    </a>
                                </td>
                            <?php }?>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-info text-center mt-3">Brak przypisanych członków do rodziny.</div>
    <?php }
} else { ?>
    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('transactionsUser')) > 0) {?>
        <div class="table-responsive shadow rounded">
            <table class="table table-striped table-bordered mb-0" style="font-family: 'Inter', sans-serif;">
                <thead class="table-primary">
                    <tr>
                        <th>ID Transakcji</th>
                        <th>Nazwa użytkownika</th>
                        <th>Kategoria</th>
                        <th>Typ</th>
                        <th>Wartość</th>
                        <th>Waluta</th>
                        <th>Forma płatności</th>
                        <th>Opis</th>
                        <th>Data transakcji</th>
                        <th>Cykliczność</th>
                        <th>Data dodania</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('transactionsUser'), 'transaction');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('transaction')->value) {
$foreach1DoElse = false;
?>
                        <tr class="<?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>table-success<?php } else { ?>table-danger<?php }?>">
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['user_name']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['category_name']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>
                                    Przychód
                                <?php } else { ?>
                                    Wydatek
                                <?php }?></td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['amount']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['currency']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php if ($_smarty_tpl->getValue('transaction')['payment_method'] == 'card') {?>
                                    Karta płatnicza
                                <?php } elseif ($_smarty_tpl->getValue('transaction')['payment_method'] == 'cash') {?>
                                    Gotówka
                                <?php } else { ?>
                                    Kryptowaluta
                                <?php }?></td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['description']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_date']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php if ($_smarty_tpl->getValue('transaction')['is_recurring'] == 1) {?>
                                Tak<?php } else { ?> Nie
                                <?php }?></td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('transaction')['created_at'],"%Y-%m-%d %H:%M:%S")), ENT_QUOTES, 'UTF-8');?>
</td>


                            <td>
                                <a href="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edytuj
                                </a>
                                <a href="<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                    <i class="bi bi-trash"></i> Usuń
                                </a>
                            </td>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-info text-center mt-3">Brak transakcji w bazie danych.</div>
    <?php }
}?>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
