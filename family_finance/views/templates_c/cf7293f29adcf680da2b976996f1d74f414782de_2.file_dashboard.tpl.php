<?php
/* Smarty version 5.6.0, created on 2025-10-17 22:02:27
  from 'file:dashboard.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68f2a0d320cd97_12578363',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf7293f29adcf680da2b976996f1d74f414782de' => 
    array (
      0 => 'dashboard.tpl',
      1 => 1760731339,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f2a0d320cd97_12578363 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<div class="dashboard-container">
    <h2 class="mb-4 fw-bold text-primary">Dashboard</h2>

    <?php if ($_smarty_tpl->getValue('session')['role'] == 'admin') {?>
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

    <?php } else { ?>
        <!-- Sekcja dla zwykłego użytkownika -->
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Twoje konto</h5>
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
                                <span class="text-success fw-semibold">Administrator rodziny</span>
                            <?php } elseif ($_smarty_tpl->getValue('session')['family_role'] == 'family_member') {?>
                                <span class="text-primary fw-semibold">Członek rodziny</span>
                            <?php } else { ?>
                                <span class="text-muted">Brak roli</span>
                            <?php }?>
                        <?php } else { ?>
                            <span class="text-muted">Nie należysz do żadnej rodziny</span>
                        <?php }?>
                    </p>
                    <a href="index.php?action=userPanel" class="btn btn-primary w-100">Panel użytkownika</a>
                </div>
            </div>

            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('session')['family_id'] ?? null))) && $_smarty_tpl->getValue('session')['family_role'] == 'family_admin') {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm p-3">
                        <h5 class="card-title">Zarządzaj członkami rodziny</h5>
                        <p class="card-text">Dodawaj, edytuj lub usuwaj członków swojej rodziny.</p>
                        <a href="index.php?action=users" class="btn btn-primary w-100">Członkowie rodziny</a>
                    </div>
                </div>
            <?php }?>

            <?php if (!$_smarty_tpl->getValue('session')['family_id']) {?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm p-3">
                        <h5 class="card-title">Załóż rodzinę</h5>
                        <p class="card-text">Nie należysz jeszcze do rodziny. Możesz założyć własną.</p>
                        <a href="index.php?action=createFamily" class="btn btn-primary w-100">Załóż rodzinę</a>
                    </div>
                </div>
            <?php }?>
        </div>
    <?php }?>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
