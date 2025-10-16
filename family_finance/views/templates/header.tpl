<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:"Zarządzanie finansami rodzinnymi"}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23007bff'><path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z'/></svg>">
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
