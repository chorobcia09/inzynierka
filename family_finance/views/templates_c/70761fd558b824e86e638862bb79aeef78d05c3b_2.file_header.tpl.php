<?php
/* Smarty version 5.6.0, created on 2025-10-17 18:54:47
  from 'file:header.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f274d7b79647_88675732',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70761fd558b824e86e638862bb79aeef78d05c3b' => 
    array (
      0 => 'header.tpl',
      1 => 1760720083,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68f274d7b79647_88675732 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
?><!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('title') ?? null)===null||$tmp==='' ? "Zarządzanie finansami rodzinnymi" ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23007bff'><path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z'/></svg>">
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="shadow-sm py-3 mb-4" style="background-color: #f8f9fa; font-family: 'Inter', sans-serif;">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 m-0 fw-bold text-primary">Zarządzanie finansami rodzinnymi</h1>
            <nav class="d-flex align-items-center">
                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['user_id'] ?? null)))) {?>
                    <span class="me-3 text-dark">
                        Witaj! <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['user_name']), ENT_QUOTES, 'UTF-8');?>
</strong> (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['role']), ENT_QUOTES, 'UTF-8');?>
)
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['account_type'] ?? null)))) {?>
                            • Rodzaj konta: <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['account_type']), ENT_QUOTES, 'UTF-8');?>
</strong>
                        <?php }?>
                    </span>
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['user_id'] ?? null))) && !$_smarty_tpl->getValue('session')['family_id']) {?>
    <a href="index.php?action=createFamily" class="btn btn-outline-primary btn-sm me-2">Załóż rodzinę</a>
<?php }?>

                    <?php if ($_smarty_tpl->getValue('session')['role'] == 'member') {?>
                    <a href="index.php?action=users" class="btn btn-outline-primary btn-sm me-2">Członkowie rodziny</a>
                    <a href="index.php?action=userPanel" class="btn btn-outline-primary btn-sm me-2">Panel użytkownika</a>
                    <?php }?>
                    <?php if ($_smarty_tpl->getValue('session')['role'] == 'admin') {?>
                        <a href="index.php?action=adminPanel" class="btn btn-outline-danger btn-sm me-2">
                            <i class="bi bi-shield-lock"></i> Panel admina
                        </a>
                    <?php }?>
                    <a href="index.php?action=logout" class="btn btn-primary btn-sm text-white">Wyloguj</a>
                <?php } else { ?>
                    <a href="index.php?action=login" class="btn btn-outline-primary btn-sm me-2">Logowanie</a>
                    <a href="index.php?action=register" class="btn btn-primary btn-sm text-white">Rejestracja</a>
                <?php }?>
            </nav>
        </div>
    </header>

<main class="container my-5 flex-grow-1"><?php }
}
