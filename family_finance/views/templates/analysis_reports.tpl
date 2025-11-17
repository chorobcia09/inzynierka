{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Raporty finansowe ({$period})</h2>

<div class="row g-4">

    <!-- Wybór okresu -->
    <div class="col-md-4">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Wybierz okres raportu</h5>
            <form method="get" action="index.php">
                <input type="hidden" name="action" value="analysisReports">
                <div class="mb-3">
                    <select name="period" class="form-select bg-dark text-light">
                        <option value="monthly" {if $period=='monthly'}selected{/if}>Miesięczny</option>
                        <option value="quarterly" {if $period=='quarterly'}selected{/if}>Kwartalny</option>
                        <option value="yearly" {if $period=='yearly'}selected{/if}>Roczny</option>
                        <option value="custom" {if $period=='custom'}selected{/if}>Niestandardowy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Pokaż raport</button>
            </form>
        </div>
    </div>

    <!-- Dostępne raporty -->
    <div class="col-md-8">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Dostępne raporty</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport podsumowania
                    <a href="index.php?action=analysisPdf&period={$period}&type=summary" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg kategorii
                    <a href="index.php?action=analysisPdf&period={$period}&type=categories" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg płatności
                    <a href="index.php?action=analysisPdf&period={$period}&type=payments" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport budżet vs wydatki
                    <a href="index.php?action=analysisPdf&period={$period}&type=budget" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport top wydatków
                    <a href="index.php?action=analysisPdf&period={$period}&type=top" class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>

{include file="footer.tpl"}
