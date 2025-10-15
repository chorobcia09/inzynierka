<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie finansami rodzinnymi</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Własny styl -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="bg-success text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4 m-0">Zarządzanie finansami rodzinnymi</h1>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?action=users" class="text-white me-3">Użytkownicy</a>
                <a href="index.php?action=logout" class="text-white">Wyloguj</a>
            <?php else: ?>
                <a href="index.php?action=login" class="text-white">Logowanie</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container my-5">
