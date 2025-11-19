{include file="header.tpl"}

<h2 class="mb-4 text-light-emphasis">Raporty finansowe</h2>

<div class="row g-4">

    <!-- Wybór okresu -->
    <div class="col-md-4">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Wybierz zakres dat</h5>
            <form method="get" action="index.php">
                <input type="hidden" name="action" value="analysisReports">

                <div class="mb-3">
                    <label for="date_from" class="form-label">Od</label>
                    <input type="date" name="date_from" id="date_from" value="{$date_from}"
                        class="form-control bg-dark text-light">
                </div>
                <div class="mb-3">
                    <label for="date_to" class="form-label">Do</label>
                    <input type="date" name="date_to" id="date_to" value="{$date_to}"
                        class="form-control bg-dark text-light">
                </div>

                <button type="submit" class="btn btn-primary w-100">Pokaż dane</button>
            </form>
        </div>
    </div>

    <!-- Dostępne raporty -->
    <div class="col-md-8">
        <div class="card bg-dark text-light p-3 shadow">
            <h5>Dostępne raporty</h5>
            <ul class="list-group list-group-flush">
                {assign var="dateParams" value="&date_from=`$date_from`&date_to=`$date_to`"}

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport podsumowania
                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=summary{$dateParams}"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg kategorii
                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=categories{$dateParams}"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport wg płatności
                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=payments{$dateParams}"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>

                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    Raport top wydatków
                    <a href="index.php?action=analysisPdf&period={$period|default:'monthly'}&type=top{$dateParams}"
                        class="btn btn-sm btn-danger">
                        Pobierz PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>

{include file="footer.tpl"}