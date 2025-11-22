<?php
/* Smarty version 5.6.0, created on 2025-11-22 14:56:58
  from 'file:dashboard.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6921c12ae41042_22472278',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf7293f29adcf680da2b976996f1d74f414782de' => 
    array (
      0 => 'dashboard.tpl',
      1 => 1763819784,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6921c12ae41042_22472278 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container py-5">
    <h2 class="mb-5 text-center text-light fw-bold display-5">
        <i class="bi bi-speedometer2 me-2"></i>Twój Panel
    </h2>

    <div class="row g-4">

        <?php if ($_smarty_tpl->getValue('session')['role'] == 'admin') {?>
            <!-- Sekcja dla administratora -->
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card admin-card admin-card-users">
                    <h5><i class="bi bi-person-gear me-2"></i>Zarządzaj użytkownikami</h5>
                    <p>Dodawaj, edytuj lub usuwaj użytkowników systemu.</p>
                    <a href="index.php?action=adminPanel" class="btn btn-light w-100 fw-semibold">Panel admina</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card admin-card admin-card-feedback">
                    <h5><i class="bi bi-folder me-2"></i>Zarządzaj zgłoszeniami</h5>
                    <p>Przeglądaj i zarządzaj zgłoszeniami użytkowników.</p>
                    <a href="index.php?action=feedbackPanel" class="btn btn-light w-100 fw-semibold">Zgłoszenia</a>
                </div>
            </div>
        <?php } else { ?>
            <!-- Sekcja użytkownika -->
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card glass-effect border-0">
                    <h5 class="text-info"><i class="bi bi-person-circle me-2"></i>Twoje konto</h5>
                    <p>
                        <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['user_name']), ENT_QUOTES, 'UTF-8');?>
</strong><br>
                        <small><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['email']), ENT_QUOTES, 'UTF-8');?>
</small><br>
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null)))) {?>
                            <hr class="my-2">
                            Rodzina: <strong><?php echo htmlspecialchars((string) ((($tmp = $_smarty_tpl->getValue('session')['family_name'] ?? null)===null||$tmp==='' ? 'Brak' ?? null : $tmp)), ENT_QUOTES, 'UTF-8');?>
</strong><br>
                            Rola:
                            <?php if ($_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                                <span class="badge bg-success">Administrator rodziny</span>
                            <?php } elseif ($_smarty_tpl->getValue('session')['family_role'] == 'family_member') {?>
                                <span class="badge bg-primary">Członek rodziny</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">Brak roli</span>
                            <?php }?>
                        <?php } else { ?>
                            <span class="text-muted">Nie należysz do żadnej rodziny</span>
                        <?php }?>
                    </p>
                    <a href="index.php?action=userPanel" class="btn btn-info w-100 fw-semibold mt-3">Panel użytkownika</a>
                </div>
            </div>

            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null))) && $_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card dashboard-card glass-effect">
                        <h5 class="text-primary"><i class="bi bi-people-fill me-2"></i>Członkowie rodziny</h5>
                        <p>Zarządzaj członkami swojej rodziny, zapraszaj lub usuwaj.</p>
                        <a href="index.php?action=usersFamily" class="btn btn-outline-primary w-100 fw-semibold">Zarządzaj</a>
                    </div>
                </div>
            <?php }?>

            <?php if (!$_smarty_tpl->getValue('session')['family_id']) {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card dashboard-card glass-effect">
                        <h5 class="text-warning"><i class="bi bi-house-add me-2"></i>Załóż rodzinę</h5>
                        <p>Nie należysz jeszcze do rodziny. Możesz założyć własną.</p>
                        <a href="index.php?action=createFamily" class="btn btn-warning w-100 fw-semibold">Załóż rodzinę</a>
                    </div>
                </div>
            <?php }?>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card glass-effect">
                    <h5 class="text-success"><i class="bi bi-card-list me-2"></i>Twoje transakcje</h5>
                    <p>Przeglądaj i zarządzaj swoimi transakcjami.</p>
                    <a href="index.php?action=manageTransactions" class="btn btn-success w-100 fw-semibold">Transakcje</a>
                </div>
            </div>

            <!-- Budżety -->
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card glass-effect">
                    <h5 class="text-danger"><i class="bi bi-wallet2 me-2"></i>Twoje budżety</h5>
                    <p>Zarządzaj swoimi budżetami, analizuj wydatki i postępy.</p>
                    <div class="d-flex gap-2">
                        <a href="index.php?action=addBudget" class="btn btn-outline-danger w-50 fw-semibold">Dodaj</a>
                        <a href="index.php?action=viewBudgets" class="btn btn-danger w-50 fw-semibold">Zobacz</a>
                    </div>
                </div>
            </div>


            <!-- Analiza -->
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card glass-effect">
                    <h5 class="text-info"><i class="bi bi-pie-chart-fill me-2"></i>Analityka</h5>
                    <p>Przejdź do analizy własnych transakcji.</p>
                    <a href="index.php?action=analysisDashboard" class="btn btn-info w-100 fw-semibold">Zobacz analizę</a>
                </div>
            </div>
        <?php }?>
    </div>
</div>

<style>

    .dashboard-card {
        background: rgba(25, 25, 25, 0.75);
        backdrop-filter: blur(8px);
        border-radius: 1.25rem;
        padding: 1.5rem;
        color: #f8f9fa;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
    }

    .admin-card {
        background: rgba(30, 30, 30, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(6px);
        border-radius: 1.25rem;
        padding: 1.5rem;
        color: #f8f9fa;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .admin-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }
    .admin-card-users h5 {
        color: #6f42c1;
    }
    .admin-card-feedback h5 {
        color: #fd7e14;
    }

    .btn {
        border-radius: 0.75rem;
    }
</style>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
