<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie finansami rodzinnymi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="views/css/styles.css">

</head>

<body class="d-flex flex-column min-vh-100" data-bs-theme="dark" class="bg-dark text-light">
    <header>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm border-bottom border-secondary">
            <div class="container">
                <!-- Logo -->
                {if isset($session.user_id)}
                    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php?action=dashboard">
                        <i class="bi bi-piggy-bank-fill"></i>
                        <span>Manage Your Finances</span>
                    </a>
                {else} <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php?action=home">
                        <i class="bi bi-piggy-bank-fill"></i>
                        <span>Manage Your Finances</span>
                    </a>
                {/if}
                <!-- Hamburger -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDark"
                    aria-controls="navbarDark" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="navbarDark">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                        {if isset($session.user_id)}

                            {if $session.role == 'admin'}
                                <li class="nav-item me-2">
                                    <a href="index.php?action=adminPanel" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-person-gear"></i> Użytkownicy
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <a href="index.php?action=feedbackPanel" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-folder"></i> Zgłoszenia
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?action=logout" class="btn btn-light btn-sm text-dark fw-semibold">
                                        Wyloguj
                                    </a>
                                </li>
                            {else}
                                <li class="nav-item me-3 text-light">
                                    Witaj, <strong>{$session.user_name}</strong>
                                </li>

                                {if !$session.family_id}
                                    <li class="nav-item me-2">
                                        <a href="index.php?action=createFamily" class="btn btn-outline-light btn-sm">
                                            Załóż rodzinę
                                        </a>
                                    </li>
                                {/if}
                                <!-- Budżety -->
                                <li class="nav-item dropdown me-2">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" id="budgetDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-bar-chart-line-fill"></i> Budżety
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="budgetDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=viewBudgets">
                                                <i class="bi bi-list-ul"></i> Przeglądaj budżety</a></li>
                                        <li><a class="dropdown-item" href="index.php?action=addBudget">
                                                <i class="bi bi-plus-circle"></i> Dodaj budżet</a></li>
                                    </ul>
                                </li>


                                <!-- Transakcje -->
                                <li class="nav-item dropdown me-2">
                                    <button class="btn btn-outline-success btn-sm dropdown-toggle" id="transactionsDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-cash-stack"></i> Transakcje
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="transactionsDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=manageTransactions">
                                                <i class="bi bi-wallet2"></i> Zarządzaj transakcjami</a></li>
                                        <li><a class="dropdown-item" href="index.php?action=addTransaction">
                                                <i class="bi bi-plus-circle"></i> Dodaj transakcję</a></li>
                                    </ul>
                                </li>

                                <!-- Kategorie -->
                                <li class="nav-item dropdown me-2">
                                    <button class="btn btn-outline-warning btn-sm dropdown-toggle" id="categoryDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-tags-fill"></i> Kategorie
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="categoryDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=categories">
                                                <i class="bi bi-list-ul"></i> Przeglądaj kategorie</a></li>
                                    </ul>
                                </li>

                                <!-- Rodzina -->
                                {if isset($session.family_id)}
                                    <li class="nav-item dropdown me-2">
                                        <button class="btn btn-outline-info btn-sm dropdown-toggle" id="familyDropdown"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-people-fill"></i> Rodzina
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="familyDropdown">
                                            <li><a class="dropdown-item" href="index.php?action=usersFamily">
                                                    <i class="bi bi-people"></i> Członkowie rodziny</a></li>
                                            {if $session.family_role == 'family_admin'}
                                                <li><a class="dropdown-item" href="index.php?action=addUserToFamily">
                                                        <i class="bi bi-person-plus"></i> Dodaj członka</a></li>
                                            {/if}
                                        </ul>
                                    </li>
                                {/if}

                                <!-- Analiza finansowa -->
                                <li class="nav-item dropdown me-2">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" id="analysisDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-graph-up-arrow"></i> Analiza
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="analysisDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=analysisDashboard">
                                                <i class="bi bi-graph-up"></i> Dashboard analityczny</a></li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li><a class="dropdown-item" href="index.php?action=analysisReports">
                                                <i class="bi bi-file-earmark-bar-graph"></i> Raporty</a></li>
                                    </ul>
                                </li>


                                <li class="nav-item me-2">
                                    <a href="index.php?action=userPanel" class="btn btn-outline-light btn-sm">Panel
                                        użytkownika</a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?action=logout"
                                        class="btn btn-light btn-sm text-dark fw-semibold">Wyloguj</a>
                                </li>

                            {/if}
                        {else}
                            <li class="nav-item me-2">
                                <a href="index.php?action=login" class="btn btn-outline-light btn-sm ">Logowanie</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.php?action=register"
                                    class="btn btn-light btn-sm text-dark fw-semibold">Rejestracja</a>
                            </li>
                        {/if}
                    </ul>
                </div>
            </div>
        </nav>
    </header>



<main class="container my-5 flex-grow-1">