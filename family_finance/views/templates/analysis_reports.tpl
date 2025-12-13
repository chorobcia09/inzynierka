{include file="header.tpl"}

<div class="container-fluid py-4">
    <h2 class="mb-4 text-light-emphasis">
        <i class="bi bi-file-earmark-pdf-fill me-2"></i>Raporty finansowe PDF
    </h2>

    {if isset($date_error)}
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Błąd:</strong> {$date_error}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    {/if}

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card bg-dark text-light p-3 shadow-lg border-0">
                <div class="card-header bg-transparent border-bottom border-secondary">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-range me-2"></i>Wybierz zakres dat
                    </h5>
                </div>
                <div class="card-body">
                    <form method="get" action="index.php" id="reportForm">
                        <input type="hidden" name="action" value="analysisReports">

                        <div class="mb-3">
                            <label for="date_from" class="form-label">
                                <i class="bi bi-calendar-date me-1"></i>Data początkowa
                            </label>
                            <input type="date" name="date_from" id="date_from" value="{$date_from}"
                                class="form-control bg-dark text-light border-secondary">
                        </div>

                        <div class="mb-3">
                            <label for="date_to" class="form-label">
                                <i class="bi bi-calendar-date-fill me-1"></i>Data końcowa
                            </label>
                            <input type="date" name="date_to" id="date_to" value="{$date_to}"
                                class="form-control bg-dark text-light border-secondary">
                        </div>

                        <div class="mb-3">
                            <label for="currency" class="form-label">
                                <i class="bi bi-currency-exchange me-1"></i>Waluta
                            </label>
                            <select name="currency" id="currency"
                                class="form-select bg-dark text-light border-secondary">
                                {foreach $currencies as $curr}
                                    <option value="{$curr.currency}" {if $currency == $curr.currency}selected{/if}>
                                        {$curr.currency}
                                    </option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel-fill me-1"></i> Załaduj dane
                            </button>
                            <button type="button" onclick="resetForm()" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Resetuj
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-transparent border-top border-secondary text-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Raporty są generowane na podstawie wybranego zakresu
                    </small>
                </div>
            </div>

            {if $date_from || $date_to}
                <div class="card bg-dark text-light mt-3 p-3 shadow border-0">
                    <div class="card-header bg-transparent border-bottom border-secondary">
                        <h6 class="mb-0">
                            <i class="bi bi-info-square me-2"></i>Wybrany okres
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <i class="bi bi-calendar me-2"></i>
                            <strong>Od:</strong> {if $date_from}{$date_from}{else}Nie określono{/if}
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-calendar-fill me-2"></i>
                            <strong>Do:</strong> {if $date_to}{$date_to}{else}Nie określono{/if}
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-cash-coin me-2"></i>
                            <strong>Waluta:</strong> {$currency}
                        </p>
                    </div>
                </div>
            {/if}
        </div>

        <div class="col-lg-8">
            <div class="row g-3">
                {assign var="dateParams" value="&date_from=`$date_from`&date_to=`$date_to`&currency=`$currency`"}

                {if $isValidDateRange}
                    <!-- RAPORT PODSUMOWANIA -->
                    <div class="col-md-6">
                        <div class="card bg-dark text-light h-100 shadow-lg border-0 hover-shadow">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-speedometer2 display-4 text-primary"></i>
                                </div>
                                <h5 class="card-title">Raport podsumowania</h5>
                                <p class="card-text small text-muted">
                                    Podstawowe wskaźniki finansowe, bilans, wskaźnik oszczędności
                                </p>
                                <div class="mt-3">
                                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=summary{$dateParams}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-download me-1"></i> Pobierz PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RAPORT KATEGORII -->
                    <div class="col-md-6">
                        <div class="card bg-dark text-light h-100 shadow-lg border-0 hover-shadow">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-pie-chart-fill display-4 text-success"></i>
                                </div>
                                <h5 class="card-title">Raport kategorii</h5>
                                <p class="card-text small text-muted">
                                    Szczegółowa analiza wydatków i przychodów według kategorii
                                </p>
                                <div class="mt-3">
                                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=categories{$dateParams}"
                                        class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i> Pobierz PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RAPORT PŁATNOŚCI -->
                    <div class="col-md-6">
                        <div class="card bg-dark text-light h-100 shadow-lg border-0 hover-shadow">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-credit-card-2-front-fill display-4 text-info"></i>
                                </div>
                                <h5 class="card-title">Raport płatności</h5>
                                <p class="card-text small text-muted">
                                    Analiza metod płatności, preferencji, udziałów procentowych
                                </p>
                                <div class="mt-3">
                                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=payments{$dateParams}"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-download me-1"></i> Pobierz PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RAPORT SZCZEGÓŁOWY -->
                    <div class="col-md-6">
                        <div class="card bg-dark text-light h-100 shadow-lg border-0 hover-shadow">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-file-earmark-text-fill display-4 text-purple"></i>
                                </div>
                                <h5 class="card-title">Raport szczegółowy</h5>
                                <p class="card-text small text-muted">
                                    Kompletny raport z wszystkimi danymi i rekomendacjami
                                </p>
                                <div class="mt-3">
                                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=detailed{$dateParams}"
                                        class="btn btn-purple btn-sm">
                                        <i class="bi bi-download me-1"></i> Pobierz PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>

            <div class="card bg-dark text-light mt-4 p-3 shadow border-0">
                <div class="card-header bg-transparent border-bottom border-secondary">
                    <h6 class="mb-0">
                        <i class="bi bi-question-circle me-2"></i>Informacje o raportach
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Co zawierają raporty?</h6>
                            <ul class="small">
                                <li>Polskie znaki i formatowanie</li>
                                <li>Kolorowe tabele</li>
                                <li>Analizy i rekomendacje</li>
                                <li>Statystyki i wskaźniki</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Jak korzystać?</h6>
                            <ul class="small">
                                <li>Wybierz zakres dat</li>
                                <li>Wybierz typ raportu</li>
                                <li>Pobierz plik PDF</li>
                                <li>Wydrukuj lub zapisz</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        box-shadow: none !important;
    }

    .card.bg-dark {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        z-index: 1;
    }

    .btn-purple {
        background-color: #6f42c1;
        border-color: #6f42c1;
        color: white;
    }

    .btn-purple:hover {
        background-color: #5a32a3;
        border-color: #5a32a3;
    }

    .display-4 {
        font-size: 3rem;
    }
</style>

<script>
    function resetForm() {
        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';
        document.getElementById('reportForm').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('date_from').value) {
            const today = new Date();
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            document.getElementById('date_from').value = lastMonth.toISOString().split('T')[0];
            document.getElementById('date_to').value = today.toISOString().split('T')[0];
        }
    });
</script>

{include file="footer.tpl"}