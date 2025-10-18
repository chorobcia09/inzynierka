<?php
/* Smarty version 5.6.0, created on 2025-10-18 17:09:30
  from 'file:header.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f3adaaa03a78_49909723',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70761fd558b824e86e638862bb79aeef78d05c3b' => 
    array (
      0 => 'header.tpl',
      1 => 1760800117,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68f3adaaa03a78_49909723 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
?><!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie finansami rodzinnymi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"><?php echo '</script'; ?>
>

</head>

<body class="d-flex flex-column min-vh-100">
    <header class="shadow-sm py-3 mb-4" style="background-color: #f8f9fa; font-family: 'Inter', sans-serif;">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 m-0 fw-bold text-primary"><a href="index.php?action=dashboard"
                    style="text-decoration: none;">Zarządzanie finansami rodzinnymi</a></h1>
            <nav class="d-flex align-items-center">
                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['user_id'] ?? null)))) {?>
                    <?php if ($_smarty_tpl->getValue('session')['role'] == 'admin') {?>
                        <a href="index.php?action=adminPanel" class="btn btn-outline-danger btn-sm me-2">
                            <i class="bi bi-shield-lock"></i> Panel admina
                        </a>
                        <a href="index.php?action=logout" class="btn btn-primary btn-sm text-white">Wyloguj</a>
                    <?php } else { ?>
                        <span class="me-3 text-dark">
                            Witaj! <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['user_name']), ENT_QUOTES, 'UTF-8');?>
</strong>

                        </span>

                        <?php if (!$_smarty_tpl->getValue('session')['family_id']) {?>
                            <a href="index.php?action=createFamily" class="btn btn-outline-primary btn-sm me-2">Załóż rodzinę</a>
                        <?php }?>
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null)))) {?>
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button"
                                    id="transactionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-cash-stack"></i> Transakcje
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionsDropdown">
                                    <li>
                                        <a class="dropdown-item" href="index.php?action=addTransaction">
                                            <i class="bi bi-plus-circle"></i> Dodaj transakcję
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="index.php?action=manageTransactions">
                                            <i class="bi bi-wallet2"></i> Zarządzaj transakcjami
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php }?>


                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null)))) {?>
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="familyDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-people-fill"></i> Rodzina
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="familyDropdown">
                                    <li>
                                        <a class="dropdown-item" href="index.php?action=usersFamily">
                                            <i class="bi bi-people"></i> Członkowie rodziny
                                        </a>
                                    </li>
                                    <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                                        <li>
                                            <a class="dropdown-item" href="index.php?action=addUserToFamily">
                                                <i class="bi bi-person-plus"></i> Dodaj członka
                                            </a>
                                        </li>
                                    <?php }?>
                                </ul>
                            </div>
                        <?php }?>

                        <a href="index.php?action=userPanel" class="btn btn-outline-primary btn-sm me-2">Panel użytkownika</a>

                        <a href="index.php?action=logout" class="btn btn-primary btn-sm text-white">Wyloguj</a>
                    <?php }?>
                <?php } else { ?>
                    <a href="index.php?action=login" class="btn btn-outline-primary btn-sm me-2">Logowanie</a>
                    <a href="index.php?action=register" class="btn btn-primary btn-sm text-white">Rejestracja</a>
                <?php }?>

            </nav>
        </div>
    </header>

<main class="container my-5 flex-grow-1"><?php }
}
