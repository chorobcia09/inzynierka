{include file='header.tpl'}

<div class="container py-5">
    <h2 class="mb-5 text-center text-light fw-bold display-5 animate__animated animate__fadeInDown">
        <i class="bi bi-speedometer2 me-2"></i>Twój Panel
    </h2>

    <div class="row g-4">

        {if $session.role == 'admin'}
            <!-- PANEL ADMINA -->
            <div class="col-md-6 col-lg-4">
                <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                    <h5 class="text-warning fw-bold"><i class="bi bi-person-gear me-2"></i>Zarządzaj użytkownikami</h5>
                    <p>Dodawaj, edytuj lub usuwaj użytkowników systemu.</p>
                    <a href="index.php?action=adminPanel" class="btn btn-warning w-100 fw-semibold mt-auto">Panel admina</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                    <h5 class="text-info fw-bold"><i class="bi bi-folder me-2"></i>Zgłoszenia</h5>
                    <p>Przeglądaj i zarządzaj zgłoszeniami użytkowników.</p>
                    <a href="index.php?action=feedbackPanel" class="btn btn-info w-100 fw-semibold mt-auto">Zgłoszenia</a>
                </div>
            </div>

        {else}
            <!-- PANEL UŻYTKOWNIKA -->
            <div class="col-md-6 col-lg-4">
                <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                    <h5 class="text-primary fw-bold"><i class="bi bi-person-circle me-2"></i>Twoje konto</h5>
                    <p>
                        <strong>{$session.user_name}</strong><br>
                        <small>{$session.email}</small><br>
                        {if isset($session.family_id)}
                            <hr>
                            Rodzina: <strong>{$session.family_name|default:'Brak'}</strong><br>
                            Rola:
                            {if $session.family_role == 'family_admin'}
                                <span class="badge bg-success">Administrator rodziny</span>
                            {elseif $session.family_role == 'family_member'}
                                <span class="badge bg-primary">Członek rodziny</span>
                            {else}
                                <span class="badge bg-secondary">Brak roli</span>
                            {/if}
                        {else}
                            <span class="text-muted">Nie należysz do żadnej rodziny</span>
                        {/if}
                    </p>
                    <a href="index.php?action=userPanel" class="btn btn-primary w-100 fw-semibold mt-auto">Panel użytkownika</a>
                </div>
            </div>

            {if isset($session.family_id) && $session.family_role == 'family_admin'}
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                        <h5 class="text-success fw-bold"><i class="bi bi-people-fill me-2"></i>Członkowie rodziny</h5>
                        <p>Zarządzaj członkami swojej rodziny, zapraszaj lub usuwaj.</p>
                        <a href="index.php?action=usersFamily" class="btn btn-success w-100 fw-semibold mt-auto">Zarządzaj</a>
                    </div>
                </div>
            {/if}

            {if !$session.family_id}
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                        <h5 class="text-warning fw-bold"><i class="bi bi-house-add me-2"></i>Załóż rodzinę</h5>
                        <p>Nie należysz jeszcze do żadnej rodziny. Możesz założyć własną.</p>
                        <a href="index.php?action=createFamily" class="btn btn-warning w-100 fw-semibold mt-auto">Załóż rodzinę</a>
                    </div>
                </div>
            {/if}

            <div class="col-md-6 col-lg-4">
                <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                    <h5 class="text-info fw-bold"><i class="bi bi-card-list me-2"></i>Twoje transakcje</h5>
                    <p>Przeglądaj i zarządzaj swoimi transakcjami.</p>
                    <a href="index.php?action=manageTransactions" class="btn btn-info w-100 fw-semibold mt-auto">Transakcje</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                    <h5 class="text-danger fw-bold"><i class="bi bi-wallet2 me-2"></i>Twoje budżety</h5>
                    <p>Zarządzaj swoimi budżetami i analizuj wydatki.</p>
                    <div class="d-flex gap-2 mt-auto">
                        <a href="index.php?action=addBudget" class="btn btn-outline-danger w-50 fw-semibold">Dodaj</a>
                        <a href="index.php?action=viewBudgets" class="btn btn-danger w-50 fw-semibold">Zobacz</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                    <h5 class="text-primary fw-bold"><i class="bi bi-pie-chart-fill me-2"></i>Analityka</h5>
                    <p>Przeglądaj wykresy i statystyki swoich finansów.</p>
                    <a href="index.php?action=analysisDashboard" class="btn btn-primary w-100 fw-semibold mt-auto">Zobacz analizę</a>
                </div>
            </div>

        {/if}

    </div>
</div>

<style>
    .bg-gradient-dark {
        background: linear-gradient(145deg, #1c1c1c, #2a2a2a);
    }
    .hover-glow:hover {
        transform: translateY(-8px);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        transition: all 0.4s ease;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

{include file='footer.tpl'}