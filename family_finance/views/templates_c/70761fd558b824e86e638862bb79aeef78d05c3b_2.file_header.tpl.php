<?php
/* Smarty version 5.6.0, created on 2025-10-16 19:33:16
  from 'file:header.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f12c5c142180_53574137',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70761fd558b824e86e638862bb79aeef78d05c3b' => 
    array (
      0 => 'header.tpl',
      1 => 1760635924,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68f12c5c142180_53574137 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
?><!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('title') ?? null)===null||$tmp==='' ? "Zarządzanie finansami rodzinnymi" ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<header class="bg-success text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4 m-0">Zarządzanie finansami rodzinnymi</h1>
        <nav>
            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['user_id'] ?? null)))) {?>
                <span class="me-3">👤 <?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['user_name']), ENT_QUOTES, 'UTF-8');?>
 (<?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['role']), ENT_QUOTES, 'UTF-8');?>
)</span>
                <a href="index.php?action=users" class="text-white me-3 text-decoration-none">Użytkownicy</a>
                <a href="index.php?action=logout" class="text-white text-decoration-none">Wyloguj</a>
            <?php } else { ?>
                <a href="index.php?action=login" class="text-white text-decoration-none">Logowanie</a>
            <?php }?>
        </nav>
    </div>
</header>
<main class="container my-5 flex-grow-1">
<?php }
}
