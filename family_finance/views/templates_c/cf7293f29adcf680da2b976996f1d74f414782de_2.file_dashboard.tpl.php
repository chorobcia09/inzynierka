<?php
/* Smarty version 5.6.0, created on 2025-10-25 19:23:42
  from 'file:dashboard.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fd079e9f2435_71600649',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf7293f29adcf680da2b976996f1d74f414782de' => 
    array (
      0 => 'dashboard.tpl',
      1 => 1761413020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fd079e9f2435_71600649 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="container py-5">
    <h2 class="mb-5 text-center text-light fw-bold display-6">Dashboard</h2>

    <div class="row g-4">
        <?php if ($_smarty_tpl->getValue('session')['role'] == 'admin') {?>
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
        <?php } else { ?>
            <!-- Karty zwykłego użytkownika -->
            <div class="col-md-6 col-lg-4">
                <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                    <h5 class="card-title text-primary"><i class="bi bi-person-circle me-2"></i> Twoje konto</h5>
                    <p class="card-text">
                        Nazwa użytkownika: <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['user_name']), ENT_QUOTES, 'UTF-8');?>
</strong><br>
                        Email: <strong><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('session')['email']), ENT_QUOTES, 'UTF-8');?>
</strong><br>
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null)))) {?>
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
                    <a href="index.php?action=userPanel" class="btn btn-primary w-100 fw-semibold mt-3">Panel użytkownika</a>
                </div>
            </div>

            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null))) && $_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                        <h5 class="card-title text-primary"><i class="bi bi-people-fill me-2"></i> Członkowie rodziny</h5>
                        <p class="card-text">Dodawaj, edytuj lub usuwaj członków swojej rodziny.</p>
                        <a href="index.php?action=usersFamily" class="btn btn-outline-primary w-100 fw-semibold mt-3">Zarządzaj</a>
                    </div>
                </div>
            <?php }?>

            <?php if (!$_smarty_tpl->getValue('session')['family_id']) {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                        <h5 class="card-title text-primary"><i class="bi bi-house-add me-2"></i> Załóż rodzinę</h5>
                        <p class="card-text">Nie należysz jeszcze do rodziny. Możesz założyć własną.</p>
                        <a href="index.php?action=createFamily" class="btn btn-primary w-100 fw-semibold mt-3">Załóż rodzinę</a>
                    </div>
                </div>
            <?php }?>

            <div class="col-md-6 col-lg-4">
                <div class="card bg-dark text-light shadow-lg border-0 rounded-4 p-4 hover-zoom transition">
                    <h5 class="card-title text-success"><i class="bi bi-card-list me-2"></i> Twoje transakcje</h5>
                    <p class="card-text">Przeglądaj i zarządzaj transakcjami finansowymi.</p>
                    <a href="index.php?action=manageTransactions" class="btn btn-success w-100 fw-semibold mt-3">Transakcje</a>
                </div>
            </div>
        <?php }?>
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

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
