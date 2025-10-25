{include file="header.tpl"}


{block name="content"}
    <div class="card shadow-sm border-0 bg-dark text-light">
        <div class="card-body p-4">
            <h2 class="mb-4 text-center text-light-emphasis">Dodaj feedback</h2>

            {if $message}
                <div class="alert alert-secondary text-center">{$message}</div>
            {/if}

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


        <script>
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
        </script>
    {/block}


{include file="footer.tpl"}