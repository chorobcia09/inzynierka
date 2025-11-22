<?php
/* Smarty version 5.6.0, created on 2025-11-22 20:05:13
  from 'file:manage_transactions.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_692209699c41e6_65305440',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28c54071631267fbcf994c251e43738947422a52' => 
    array (
      0 => 'manage_transactions.tpl',
      1 => 1763838312,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_692209699c41e6_65305440 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="text-light fw-bold mb-3 mb-md-0">
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
        <div class="row g-3">
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('transactionsList'), 'transaction');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('transaction')->value) {
$foreach0DoElse = false;
?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card bg-dark text-light shadow-sm h-100 bg-dark-subtle">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5
                                    class="card-title mb-2 <?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>text-success<?php } else { ?>text-danger<?php }?>">
                                    <?php if ($_smarty_tpl->getValue('transaction')['type'] == 'income') {?>Przychód<?php } else { ?>Wydatek<?php }?> -
                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('transaction')['amount'],2,","," ")), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['currency']), ENT_QUOTES, 'UTF-8');?>

                                </h5>
                                <p class="card-text mb-1"><strong>Użytkownik:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['user_name']), ENT_QUOTES, 'UTF-8');?>
</p>
                                <p class="card-text mb-1"><strong>Kategoria:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['category_name']), ENT_QUOTES, 'UTF-8');?>
</p>
                                <p class="card-text mb-1"><strong>Płatność:</strong>
                                    <?php if ($_smarty_tpl->getValue('transaction')['payment_method'] == 'card') {?>Karta
                                    <?php } elseif ($_smarty_tpl->getValue('transaction')['payment_method'] == 'cash') {?>Gotówka
                                    <?php } else { ?>Krypto
                                    <?php }?>
                                </p>
                                <p class="card-text mb-1"><strong>Data transakcji:</strong> <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_date']), ENT_QUOTES, 'UTF-8');?>
</p>
                                <p class="card-text mb-1"><strong>Data dodania:</strong>
                                    <?php echo htmlspecialchars((string) ($_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('transaction')['created_at'],"%Y-%m-%d %H:%M")), ENT_QUOTES, 'UTF-8');?>
</p>
                                <p class="card-text mb-1 text-truncate" title="<?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('transaction')['description'] ?? null)===null||$tmp==='' ? '—' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
">
                                    <strong>Opis:</strong> <?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('transaction')['description'] ?? null)===null||$tmp==='' ? '—' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>

                                </p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap mt-3">
                                <a href="index.php?action=transactionDetails&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
"
                                    class="btn btn-outline-info btn-sm flex-grow-1">
                                    <i class="bi bi-eye"></i> Zobacz
                                </a>
                                <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin' || $_smarty_tpl->getValue('session')['family_id'] == null) {?>
                                    <a href="index.php?action=editTransaction&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
"
                                        class="btn btn-outline-warning btn-sm flex-grow-1">
                                        <i class="bi bi-pencil"></i> Edytuj
                                    </a>
                                    <a href="index.php?action=deleteTransaction&id=<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('transaction')['transaction_id']), ENT_QUOTES, 'UTF-8');?>
"
                                        class="btn btn-outline-danger btn-sm flex-grow-1"
                                        onclick="return confirm('Czy na pewno chcesz usunąć transakcję?');">
                                        <i class="bi bi-trash"></i> Usuń
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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
    .card {
        border-radius: 1rem;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.3);
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .btn-outline-info,
    .btn-outline-warning,
    .btn-outline-danger {
        min-width: 80px;
    }

    @media (max-width: 576px) {
        .btn {
            flex-grow: 1;
            text-align: center;
        }
    }
</style>

<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
