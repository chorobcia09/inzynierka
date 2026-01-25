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
        <nav class="navbar navbar-expand-xl bg-dark navbar-dark shadow-sm border-bottom border-secondary sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
                    href="index.php?action={if isset($session.user_id)}dashboard{else}home{/if}">
                    <i class="bi bi-piggy-bank-fill"></i>
                    <span>Manage Your Finances</span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarDark" aria-controls="navbarDark" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarDark">
                    <ul class="navbar-nav ms-auto mb-2 mb-xl-0 align-items-xl-center gap-1">

                        {if isset($session.user_id)}
                            {if $session.role == 'admin'}
                                <li class="nav-item">
                                    <a href="index.php?action=adminPanel" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-person-gear"></i> Zarządzanie użytkownikami
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?action=feedbackPanel" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-folder"></i> Zarządzanie zgłoszeniami
                                    </a>
                                </li>
                            {else}
                                <li class="nav-item px-2 text-light d-none d-xl-block">
                                    <span class="small opacity-75">Witaj,</span> <strong>{$session.user_name}</strong>
                                </li>

                                {if !$session.family_id}
                                    <li class="nav-item">
                                        <a href="index.php?action=createFamily" class="btn btn-outline-light btn-sm w-100">
                                            Załóż rodzinę
                                        </a>
                                    </li>
                                {/if}

                                <li class="nav-item dropdown">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle w-100" id="budgetDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-bar-chart-line-fill"></i> Budżety
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow"
                                        aria-labelledby="budgetDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=viewBudgets"><i
                                                    class="bi bi-list-ul me-2"></i>Przeglądaj budżety</a></li>
                                        <li><a class="dropdown-item" href="index.php?action=addBudget"><i
                                                    class="bi bi-plus-circle me-2"></i>Dodaj budżet</a></li>
                                    </ul>
                                </li>

                                <li class="nav-item dropdown">
                                    <button class="btn btn-outline-success btn-sm dropdown-toggle w-100"
                                        id="transactionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-cash-stack"></i> Transakcje
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow"
                                        aria-labelledby="transactionsDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=manageTransactions"><i
                                                    class="bi bi-wallet2 me-2"></i>Zarządzaj transakcjami</a></li>
                                        <li><a class="dropdown-item" href="index.php?action=addTransaction"><i
                                                    class="bi bi-plus-circle me-2"></i>Dodaj transakcję</a></li>
                                    </ul>
                                </li>

                                <li class="nav-item dropdown">
                                    <button class="btn btn-outline-warning btn-sm dropdown-toggle w-100" id="categoryDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-tags-fill"></i> Kategorie
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow"
                                        aria-labelledby="categoryDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=categories"><i
                                                    class="bi bi-list-ul me-2"></i>Przeglądaj kategorie</a></li>
                                    </ul>
                                </li>

                                {if isset($session.family_id) && $session.family_id}
                                    <li class="nav-item dropdown">
                                        <button class="btn btn-outline-info btn-sm dropdown-toggle w-100" id="familyDropdown"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-people-fill"></i> Rodzina
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow"
                                            aria-labelledby="familyDropdown">
                                            <li><a class="dropdown-item" href="index.php?action=usersFamily"><i
                                                        class="bi bi-people me-2"></i>Członkowie rodziny</a></li>
                                            {if $session.family_role == 'family_admin'}
                                                <li><a class="dropdown-item" href="index.php?action=addUserToFamily"><i
                                                            class="bi bi-person-plus me-2"></i>Dodaj członka</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item text-danger" href="index.php?action=deleteFamily"
                                                        onclick="return confirm('Czy na pewno chcesz usunąć rodzinę?')">
                                                        <i class="bi bi-trash me-2"></i>Usuń rodzinę</a></li>
                                            {/if}
                                        </ul>
                                    </li>
                                {/if}

                                <li class="nav-item dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100" id="analysisDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-graph-up-arrow"></i> Analiza
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow"
                                        aria-labelledby="analysisDropdown">
                                        <li><a class="dropdown-item" href="index.php?action=analysisDashboard"><i
                                                    class="bi bi-graph-up me-2"></i>Dashboard</a></li>
                                        {if $session.family_role == 'family_admin' || !$session.family_id}
                                            <li><a class="dropdown-item" href="index.php?action=analysisReports"><i
                                                        class="bi bi-file-earmark-bar-graph me-2"></i>Raporty</a></li>
                                        {/if}
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="index.php?action=userPanel" class="btn btn-outline-light btn-sm w-100">Panel użytkownika</a>
                                </li>
                            {/if}

                            <li class="nav-item ms-xl-2">
                                <a href="index.php?action=logout"
                                    class="btn btn-light btn-sm text-dark fw-bold w-100 px-3">Wyloguj</a>
                            </li>

                        {else}
                            <li class="nav-item">
                                <a href="index.php?action=login"
                                    class="btn btn-outline-light btn-sm px-3 w-100">Logowanie</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.php?action=register"
                                    class="btn btn-light btn-sm text-dark fw-bold px-3 w-100">Rejestracja</a>
                            </li>
                        {/if}
                    </ul>
                </div>
            </div>
        </nav>
    </header>



<main class="container my-5 flex-grow-1">