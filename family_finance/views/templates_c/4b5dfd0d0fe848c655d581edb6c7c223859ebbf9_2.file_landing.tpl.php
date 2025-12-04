<?php
/* Smarty version 5.6.0, created on 2025-12-04 19:19:10
  from 'file:landing.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6931d09e58ba35_72191517',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4b5dfd0d0fe848c655d581edb6c7c223859ebbf9' => 
    array (
      0 => 'landing.tpl',
      1 => 1764872345,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6931d09e58ba35_72191517 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->renderSubTemplate('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    body {
        color: #f8f9fa;
        font-family: 'Inter', sans-serif;
    }

    .hero-section {
        background: radial-gradient(circle at 30% 30%, #1f1f1f, #0c0c0c);
        padding: 6rem 1rem;
        text-align: center;
        color: #fff;
        border-radius: 1rem;
    }

    .hero-section h1 {
        font-weight: 700;
        font-size: 3rem;
    }

    .hero-section p {
        font-size: 1.2rem;
        color: #adb5bd;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: white;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(13, 110, 253, 0.5);
    }

    .feature-icon {
        font-size: 2.5rem;
        color: #0d6efd;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: rotate(10deg) scale(1.2);
    }

    .feature-card {
        background-color: #1e1e1e;
        border: none;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 20px rgba(13, 110, 253, 0.2);
    }
</style>

<section class="hero-section " data-aos="fade-up">
    <div class="container ">
        <h1 data-aos="zoom-in">Zarządzaj finansami rodziny z łatwością <i class="bi bi-cash-coin"></i></h1>
        <p data-aos="fade-up" data-aos-delay="200">
            Intuicyjny system do kontroli wydatków, wspólnego budżetu i raportów rodzinnych.
        </p>
        <div class="mt-4 d-flex flex-column flex-md-row justify-content-center" data-aos="zoom-in" data-aos-delay="400">
            <a href="index.php?action=register" class="btn btn-gradient btn-lg rounded-pill px-4 me-md-2 mb-3 mb-md-0">
                <i class="bi bi-person-plus"></i> Zarejestruj się
            </a>
            <a href="index.php?action=login" class="btn btn-outline-light btn-lg rounded-pill px-4">
                <i class="bi bi-box-arrow-in-right"></i> Zaloguj się
            </a>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold text-light">Dlaczego warto?</h2>
        <p class="text-muted">Najważniejsze funkcje, które ułatwią Ci życie</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card feature-card p-4 text-center h-100">
                <i class="bi bi-wallet2 feature-icon mb-3"></i>
                <h5 class="fw-bold">Śledź wydatki</h5>
                <p class="text-muted mb-0">Zobacz gdzie znika Twój budżet. Wszystko w jednym miejscu.</p>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card feature-card p-4 text-center h-100">
                <i class="bi bi-people feature-icon mb-3"></i>
                <h5 class="fw-bold">Zarządzaj rodziną</h5>
                <p class="text-muted mb-0">Twórz rodziny, przypisuj role i wspólnie planuj finanse.</p>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card feature-card p-4 text-center h-100">
                <i class="bi bi-graph-up-arrow feature-icon mb-3"></i>
                <h5 class="fw-bold">Analizuj dane</h5>
                <p class="text-muted mb-0">Przejrzyste raporty i wykresy pomagają podejmować lepsze decyzje.</p>
            </div>
        </div>
    </div>
</section>

<section class="text-center py-5 bg-dark" data-aos="zoom-in">
    <h3 class="fw-bold mb-3 text-light">Gotowy, by przejąć kontrolę nad budżetem?</h3>
    <a href="index.php?action=register" class="btn btn-gradient btn-lg rounded-pill px-5">
        <i class="bi bi-rocket-takeoff"></i> Zacznij teraz!
    </a>
</section>

<?php echo '<script'; ?>
 src="https://unpkg.com/aos@2.3.1/dist/aos.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
