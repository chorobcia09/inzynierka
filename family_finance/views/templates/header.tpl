<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie finansami rodzinnymi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="shadow-sm py-3 mb-4" style="background-color: #f8f9fa; font-family: 'Inter', sans-serif;">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 m-0 fw-bold text-primary"><a href="index.php?action=dashboard"
                    style="text-decoration: none;">Zarządzanie finansami rodzinnymi</a></h1>
            <nav class="d-flex align-items-center">
                {if isset($session.user_id)}
                    {if $session.role == 'admin'}
                        <a href="index.php?action=adminPanel" class="btn btn-outline-danger btn-sm me-2">
                            <i class="bi bi-shield-lock"></i> Panel admina
                        </a>
                        <a href="index.php?action=logout" class="btn btn-primary btn-sm text-white">Wyloguj</a>
                    {else}
                        <span class="me-3 text-dark">
                            Witaj! <strong>{$session.user_name}</strong>

                        </span>

                        {if !$session.family_id}
                            <a href="index.php?action=createFamily" class="btn btn-outline-primary btn-sm me-2">Załóż rodzinę</a>
                        {/if}
                        {if isset($session.family_id)}
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
                        {/if}


                        {if isset($session.family_id)}
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
                                    {if $session.family_role == 'family_admin'}
                                        <li>
                                            <a class="dropdown-item" href="index.php?action=addUserToFamily">
                                                <i class="bi bi-person-plus"></i> Dodaj członka
                                            </a>
                                        </li>
                                    {/if}
                                </ul>
                            </div>
                        {/if}

                        <a href="index.php?action=userPanel" class="btn btn-outline-primary btn-sm me-2">Panel użytkownika</a>

                        <a href="index.php?action=logout" class="btn btn-primary btn-sm text-white">Wyloguj</a>
                    {/if}
                {else}
                    <a href="index.php?action=login" class="btn btn-outline-primary btn-sm me-2">Logowanie</a>
                    <a href="index.php?action=register" class="btn btn-primary btn-sm text-white">Rejestracja</a>
                {/if}

            </nav>
        </div>
    </header>

<main class="container my-5 flex-grow-1">