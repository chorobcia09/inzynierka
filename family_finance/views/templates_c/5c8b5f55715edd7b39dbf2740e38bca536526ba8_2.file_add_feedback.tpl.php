<?php
/* Smarty version 5.6.0, created on 2025-10-25 19:09:18
  from 'file:add_feedback.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_68fd043e029f92_65231635',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c8b5f55715edd7b39dbf2740e38bca536526ba8' => 
    array (
      0 => 'add_feedback.tpl',
      1 => 1761412156,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68fd043e029f92_65231635 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
$_smarty_tpl->renderSubTemplate("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_129021385868fd043e020c82_96437205', "content");
?>



<?php $_smarty_tpl->renderSubTemplate("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
/* {block "content"} */
class Block_129021385868fd043e020c82_96437205 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\user\\Desktop\\inzynierka\\family_finance\\views\\templates';
?>

    <div class="card shadow-sm border-0 bg-dark text-light">
        <div class="card-body p-4">
            <h2 class="mb-4 text-center text-light-emphasis">Dodaj feedback</h2>

            <?php if ($_smarty_tpl->getValue('message')) {?>
                <div class="alert alert-secondary text-center"><?php echo htmlspecialchars((string) ($_smarty_tpl->getValue('message')), ENT_QUOTES, 'UTF-8');?>
</div>
            <?php }?>

            <form method="post" action="" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="type" class="form-label">Typ feedbacku</label>
                    <select name="type" id="type" class="form-select bg-secondary text-light" required>
                        <option value="">-- Wybierz typ --</option>
                        <option value="bug">Błąd</option>
                        <option value="suggestion">Sugestia</option>
                        <option value="category_proposal">Propozycja kategorii</option>
                        <option value="support">Pomoc techniczna</option>
                    </select>
                    <div class="invalid-feedback">Wybierz typ feedbacku.</div>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Temat</label>
                    <input type="text" name="subject" id="subject" class="form-control bg-secondary text-light" required>
                    <div class="invalid-feedback">Podaj temat wiadomości.</div>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Wiadomość</label>
                    <textarea name="message" id="message" rows="5" class="form-control bg-secondary text-light"
                        required></textarea>
                    <div class="invalid-feedback">Napisz swoją wiadomość.</div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-chat-dots-fill"></i> Wyślij feedback
                    </button>
                </div>
            </form>
        </div>
        </div>


        <?php echo '<script'; ?>
>
            (() => {
                'use strict';
                const forms = document.querySelectorAll('.needs-validation');
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        <?php echo '</script'; ?>
>
    <?php
}
}
/* {/block "content"} */
}
