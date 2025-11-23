<?php
/* Smarty version 5.6.0, created on 2025-11-23 12:25:08
  from 'file:dashboard.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6922ef14448967_59244761',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf7293f29adcf680da2b976996f1d74f414782de' => 
    array (
      0 => 'dashboard.tpl',
      1 => 1763897107,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6922ef14448967_59244761 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container py-5">
    <h2 class="mb-5 text-center text-light fw-bold display-5 animate__animated animate__fadeInDown">
        <i class="bi bi-speedometer2 me-2"></i>Twój Panel
    </h2>

    <div class="row g-4">

        <?php if ($_smarty_tpl->getValue('session')['role'] == 'admin') {?>
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

        <?php } else { ?>
            <!-- PANEL UŻYTKOWNIKA -->
            <div class="col-md-6 col-lg-4">
                <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                    <h5 class="text-primary fw-bold"><i class="bi bi-person-circle me-2"></i>Twoje konto</h5>
                    <p>
                        <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['user_name']), ENT_QUOTES, 'UTF-8');?>
</strong><br>
                        <small><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['email']), ENT_QUOTES, 'UTF-8');?>
</small><br>
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null)))) {?>
                            <hr>
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
                    <a href="index.php?action=userPanel" class="btn btn-primary w-100 fw-semibold mt-auto">Panel użytkownika</a>
                </div>
            </div>

            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null))) && $_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                        <h5 class="text-success fw-bold"><i class="bi bi-people-fill me-2"></i>Członkowie rodziny</h5>
                        <p>Zarządzaj członkami swojej rodziny, zapraszaj lub usuwaj.</p>
                        <a href="index.php?action=usersFamily" class="btn btn-success w-100 fw-semibold mt-auto">Zarządzaj</a>
                    </div>
                </div>
            <?php }?>

            <?php if (!$_smarty_tpl->getValue('session')['family_id']) {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-gradient-dark text-light border-0 rounded-4 p-4 shadow-lg h-100 hover-glow">
                        <h5 class="text-warning fw-bold"><i class="bi bi-house-add me-2"></i>Załóż rodzinę</h5>
                        <p>Nie należysz jeszcze do żadnej rodziny. Możesz założyć własną.</p>
                        <a href="index.php?action=createFamily" class="btn btn-warning w-100 fw-semibold mt-auto">Załóż rodzinę</a>
                    </div>
                </div>
            <?php }?>

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

        <?php }?>

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

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
