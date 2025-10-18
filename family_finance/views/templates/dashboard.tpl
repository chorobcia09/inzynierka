{include file='header.tpl'}

<div class="dashboard-container">
    <h2 class="mb-4 fw-bold text-primary">Dashboard</h2>

    {if $session.role == 'admin'}
        <!-- Sekcja dla administratora -->
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Zarządzaj użytkownikami</h5>
                    <p class="card-text">Dodawaj, edytuj lub usuwaj użytkowników.</p>
                    <a href="index.php?action=adminPanel" class="btn btn-danger w-100">Panel admina</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Zarządzaj rodzinami</h5>
                    <p class="card-text">Przeglądaj i edytuj rodziny w systemie. (DODAĆ W PRZYSZŁOŚCI MOŻE)</p>
                    <a href="" class="btn btn-danger w-100">Rodziny</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Raporty i statystyki</h5>
                    <p class="card-text">Przeglądaj raporty finansowe wszystkich rodzin. (DODAĆ W PRZYSZŁOŚCI MOŻE)</p>
                    <a href="" class="btn btn-danger w-100">Raporty</a>
                </div>
            </div>
        </div>

    {else}
        <!-- Sekcja dla zwykłego użytkownika -->
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Twoje konto</h5>
                    <p class="card-text">
                        Nazwa użytkownika: <strong>{$session.user_name}</strong><br>
                        Email: <strong>{$session.email}</strong><br>
                        {if isset($session.family_id)}
                            Rodzina: <strong>{$session.family_name|default:'Brak'}</strong><br>
                            Rola:
                            {if $session.family_role == 'family_admin'}
                                <span class="text-success fw-semibold">Administrator rodziny</span>
                            {elseif $session.family_role == 'family_member'}
                                <span class="text-primary fw-semibold">Członek rodziny</span>
                            {else}
                                <span class="text-muted">Brak roli</span>
                            {/if}
                        {else}
                            <span class="text-muted">Nie należysz do żadnej rodziny</span>
                        {/if}
                    </p>
                    <a href="index.php?action=userPanel" class="btn btn-primary w-100">Panel użytkownika</a>
                </div>
            </div>

            {if isset($session.family_id) && $session.family_role == 'family_admin'}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm p-3">
                        <h5 class="card-title">Zarządzaj członkami rodziny</h5>
                        <p class="card-text">Dodawaj, edytuj lub usuwaj członków swojej rodziny.</p>
                        <a href="index.php?action=usersFamily" class="btn btn-primary w-100">Członkowie rodziny</a>
                    </div>
                </div>
            {/if}

            {if !$session.family_id}
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm p-3">
                        <h5 class="card-title">Załóż rodzinę</h5>
                        <p class="card-text">Nie należysz jeszcze do rodziny. Możesz założyć własną.</p>
                        <a href="index.php?action=createFamily" class="btn btn-primary w-100">Załóż rodzinę</a>
                    </div>
                </div>
            {/if}
        </div>
    {/if}
</div>

{include file='footer.tpl'}