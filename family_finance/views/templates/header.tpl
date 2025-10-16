<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:"Zarządzanie finansami rodzinnymi"}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body class="d-flex flex-column min-vh-100">
<header class="shadow-sm py-3 mb-4" style="background-color: #f8f9fa; font-family: 'Inter', sans-serif;">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4 m-0 fw-bold text-primary">Zarządzanie finansami rodzinnymi</h1>
        <nav class="d-flex align-items-center">
            {if isset($session.user_id)}
                <span class="me-3 text-dark">
                    Witaj! <strong>{$session.user_name}</strong> ({$session.role})
                    {if isset($session.account_type)}
                        • Rodzaj konta: <strong>{$session.account_type}</strong>
                    {/if}
                </span>
                <a href="index.php?action=users" class="btn btn-outline-primary btn-sm me-2">Użytkownicy</a>
                <a href="index.php?action=userPanel" class="btn btn-outline-primary btn-sm me-2">Panel użytkownika</a>
                <a href="index.php?action=logout" class="btn btn-primary btn-sm text-white">Wyloguj</a>
            {else}
                <a href="index.php?action=login" class="btn btn-outline-primary btn-sm me-2">Logowanie</a>
                <a href="index.php?action=register" class="btn btn-primary btn-sm text-white">Rejestracja</a>
            {/if}
        </nav>
    </div>
</header>

<main class="container my-5 flex-grow-1">
