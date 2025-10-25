{include file='header.tpl'}

<div class="container py-5">
    <h2 class="mb-5 text-center text-light fw-bold display-6">Dashboard</h2>

    <div class="row g-4">
        {if $session.role == 'admin'}
            <!-- Karty administratora -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-light shadow-lg border-0 rounded-4 p-4 bg-gradient" style="background: linear-gradient(135deg, #6f42c1, #6610f2); transition: transform .3s;">
                    <h5 class="card-title"><i class="bi bi-person-gear me-2"></i> Zarządzaj użytkownikami</h5>
                    <p class="card-text">Dodawaj, edytuj lub usuwaj użytkowników.</p>
                    <a href="index.php?action=adminPanel" class="btn btn-light w-100 fw-semibold mt-3">Panel admina</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card text-light shadow-lg border-0 rounded-4 p-4 bg-gradient" style="background: linear-gradient(135deg, #d63384, #fd7e14); transition: transform .3s;">
                    <h5 class="card-title"><i class="bi bi-people-fill me-2"></i> Zarządzaj rodzinami</h5>
                    <p class="card-text">Przeglądaj i edytuj rodziny w systemie. (Wkrótce)</p>
                    <a href="#" class="btn btn-light w-100 fw-semibold mt-3">Rodziny</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card text-light shadow-lg border-0 rounded-4 p-4 bg-gradient" style="background: linear-gradient(135deg, #198754, #20c997); transition: transform .3s;">
                    <h5 class="card-title"><i class="bi bi-bar-chart me-2"></i> Raporty i statystyki</h5>
                    <p class="card-text">Przeglądaj raporty finansowe wszystkich rodzin. (Wkrótce)</p>
                    <a href="#" class="btn btn-light w-100 fw-semibold mt-3">Raporty</a>
                </div>
            </div>
        {else}
            <!-- Karty zwykłego użytkownika -->
            <div class="col-md-6 col-lg-4">
                <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                    <h5 class="card-title text-primary"><i class="bi bi-person-circle me-2"></i> Twoje konto</h5>
                    <p class="card-text">
                        Nazwa użytkownika: <strong>{$session.user_name}</strong><br>
                        Email: <strong>{$session.email}</strong><br>
                        {if isset($session.family_id)}
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
                    <a href="index.php?action=userPanel" class="btn btn-primary w-100 fw-semibold mt-3">Panel użytkownika</a>
                </div>
            </div>

            {if isset($session.family_id) && $session.family_role == 'family_admin'}
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                        <h5 class="card-title text-primary"><i class="bi bi-people-fill me-2"></i> Członkowie rodziny</h5>
                        <p class="card-text">Dodawaj, edytuj lub usuwaj członków swojej rodziny.</p>
                        <a href="index.php?action=usersFamily" class="btn btn-outline-primary w-100 fw-semibold mt-3">Zarządzaj</a>
                    </div>
                </div>
            {/if}

            {if !$session.family_id}
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                        <h5 class="card-title text-primary"><i class="bi bi-house-add me-2"></i> Załóż rodzinę</h5>
                        <p class="card-text">Nie należysz jeszcze do rodziny. Możesz założyć własną.</p>
                        <a href="index.php?action=createFamily" class="btn btn-primary w-100 fw-semibold mt-3">Załóż rodzinę</a>
                    </div>
                </div>
            {/if}

            <div class="col-md-6 col-lg-4">
                <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                    <h5 class="card-title text-success"><i class="bi bi-card-list me-2"></i> Twoje transakcje</h5>
                    <p class="card-text">Przeglądaj i zarządzaj transakcjami finansowymi.</p>
                    <a href="index.php?action=manageTransactions" class="btn btn-success w-100 fw-semibold mt-3">Transakcje</a>
                </div>
            </div>
        {/if}
    </div>
</div>

<style>
    .bg-gradient {
        background-size: 200% 200%;
    }
    .bg-gradient:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    }
    .hover-zoom:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>

{include file='footer.tpl'}
