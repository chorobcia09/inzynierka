<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:"Zarządzanie finansami rodzinnymi"}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<header class="bg-success text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4 m-0">Zarządzanie finansami rodzinnymi</h1>
        <nav>
            {if isset($session.user_id)}
                <span class="me-3">
                    Witaj! {$session.user_name} ({$session.role}) 
                    {if isset($session.account_type)}
                        Rodzaj konta: <strong>{$session.account_type}</strong>
                    {/if}
                </span>
                <a href="index.php?action=users" class="text-white me-3 text-decoration-none">Użytkownicy</a>
                <a href="index.php?action=userPanel" class="text-white me-3 text-decoration-none">Panel użytkownika</a>
                <a href="index.php?action=logout" class="text-white text-decoration-none">Wyloguj</a>
            {else}
                <a href="index.php?action=login" class="btn btn-outline-light me-2">Logowanie</a>
                <a href="index.php?action=register" class="btn btn-light text-success">Rejestracja</a>
            {/if}
        </nav>
    </div>
</header>
<main class="container my-5 flex-grow-1">
