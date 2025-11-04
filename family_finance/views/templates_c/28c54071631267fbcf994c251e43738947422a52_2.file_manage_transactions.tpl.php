<?php
/* Smarty version 5.6.0, created on 2025-11-04 21:11:07
  from 'file:manage_transactions.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_690a5ddb390137_25878466',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28c54071631267fbcf994c251e43738947422a52' => 
    array (
      0 => 'manage_transactions.tpl',
      1 => 1762287065,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_690a5ddb390137_25878466 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-light fw-bold">
            <i class="bi bi-credit-card-2-front me-2 text-success"></i> Twoje transakcje
        </h2>
        <a href="index.php?action=addTransaction" class="btn btn-success rounded-pill px-4 shadow-sm fw-semibold">
            <i class="bi bi-plus-circle me-2"></i> Dodaj transakcję
        </a>
    </div>

    <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_member' || $_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
        <?php $_smarty_tpl->assign('transactionsList', $_smarty_tpl->getValue('transactions'), false, NULL);?>
    <?php } else { ?>
        <?php $_smarty_tpl->assign('transactionsList', $_smarty_tpl->getValue('transactionsUser'), false, NULL);?>
    <?php }?>

    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('transactionsList')) > 0) {?>
        <div class="table-responsive shadow-lg rounded-4 overflow-hidden">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="bg-gradient bg-dark text-light small text-uppercase">
                    <tr>
                        <th class="text-nowrap"><i class="bi bi-person me-1 small"></i>Użytkownik</th>
                        <th class="text-nowrap"><i class="bi bi-tag me-1 small"></i>Kategoria</th>
                        <th class="text-nowrap"><i class="bi bi-arrow-left-right me-1 small"></i>Typ</th>
                        <th class="text-nowrap"><i class="bi bi-cash-stack me-1 small"></i>Kwota</th>
                        <th class="text-nowrap"><i class="bi bi-currency-exchange me-1 small"></i>Waluta</th>
                        <th class="text-nowrap"><i class="bi bi-wallet2 me-1 small"></i>Płatność</th>
                        <th class="text-nowrap"><i class="bi bi-pencil-square me-1 small"></i>Opis</th>
                        <th class="text-nowrap"><i class="bi bi-calendar-event me-1 small"></i>Data</th>
                        <th class="text-nowrap"><i class="bi bi-repeat me-1 small"></i>Cykliczność</th>
                        <th class="text-nowrap"><i class="bi bi-clock me-1 small"></i>Dodano</th>
                        <th class="text-nowrap"><i class="bi bi-eye me-1 small"></i>Szczegóły</th>
                        <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin' || !$_smarty_tpl->getValue('session')['family_id']) {?>
                            <th class="text-nowrap"><i class="bi bi-gear me-1 small"></i>Akcje</th>
                        <?php }?>
                    </tr>
                </thead>

                <tbody>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('transactionsList'), 'transaction');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('transaction')->value) {
$foreach0DoElse = false;
?>
                        <tr class="transition">
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['user_name']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><span class="badge bg-info text-dark px-3 py-2"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['category_name']), ENT_QUOTES, 'UTF-8');?>
</span></td>
                            <td>
                                <?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>
                                    <span class="badge bg-success px-3 py-2">Przychód</span>
                                <?php } else { ?>
                                    <span class="badge bg-danger px-3 py-2">Wydatek</span>
                                <?php }?>
                            </td>
                            <td class="fw-bold text-light">
                                <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('transaction')['amount'],2,","," ")), ENT_QUOTES, 'UTF-8');?>

                            </td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['currency']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->getValue('transaction')['payment_method'] == 'card') {?>
                                    <i class="bi bi-credit-card text-warning"></i> Karta
                                <?php } elseif ($_smarty_tpl->getValue('transaction')['payment_method'] == 'cash') {?>
                                    <i class="bi bi-cash text-success"></i> Gotówka
                                <?php } else { ?>
                                    <i class="bi bi-coin text-info"></i> Krypto
                                <?php }?>
                            </td>
                            <td class="text-muted"><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('transaction')['description'] ?? null)===null||$tmp==='' ? '—' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_date']), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->getValue('transaction')['is_recurring'] == 1) {?>
                                    <span class="badge bg-primary">Tak</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Nie</span>
                                <?php }?>
                            </td>
                            <td><?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('transaction')['created_at'],"%Y-%m-%d %H:%M")), ENT_QUOTES, 'UTF-8');?>
</td>
                            <td>
                                <a href="index.php?action=transactionDetails&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
"
                                    class="btn btn-outline-info btn-sm rounded-pill px-3">
                                    <i class="bi bi-eye"></i> Zobacz
                                </a>
                            </td>
                            <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin' || !$_smarty_tpl->getValue('session')['family_id']) {?>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="index.php?action=editTransaction&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
"
                                            class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="index.php?action=deleteTransaction&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
"
                                            class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                            onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
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
        <div class="text-center text-light mt-5">
            <i class="bi bi-inbox display-1 text-secondary"></i>
            <p class="lead mt-3">Nie znaleziono żadnych transakcji.</p>
            <a href="index.php?action=addTransaction" class="btn btn-outline-light rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i> Dodaj pierwszą transakcję
            </a>
        </div>
    <?php }?>
</div>

<style>
    .table-dark {
        background-color: #1e1e2f !important;
    }

    .table-dark tbody tr:hover {
        background-color: #2c2c3f !important;
        transition: 0.3s;
    }

    .transition {
        transition: all 0.2s ease-in-out;
    }

    .transition:hover {
        transform: scale(1.01);
    }

    .bg-gradient {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
    }
</style>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
