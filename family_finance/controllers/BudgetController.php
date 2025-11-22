<?php
require_once 'models/Budgets.php';
require_once 'models/Categories.php';

class BudgetController
{
    private $smarty;
    private $budgetModel;

    public function __construct($smarty)
    {
        global $db;
        $this->smarty = $smarty;
        $this->budgetModel = new Budgets($db);
    }

    public function add()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $categoriesModel = new Categories();
        $categories = $categoriesModel->getAllCategories();

        $success = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name'] ?? '');
            $period_type = $_POST['period_type'] ?? 'monthly';
            $start_date = $_POST['start_date'] ?? null;
            $end_date = $_POST['end_date'] ?? null;
            $family_id = $_SESSION['family_id'] ?? null;
            $user_id = $_SESSION['user_id'];

            // Walidacja
            if (empty($name) || empty($start_date) || empty($end_date)) {
                $error = 'Uzupełnij wszystkie wymagane pola.';
            } else {
                // Pobranie kategorii i limitów
                $items = [];
                $total_limit = 0;

                if (!empty($_POST['categories'])) {
                    foreach ($_POST['categories'] as $cat) {
                        if (empty($cat['category_id']) || empty($cat['limit_amount'])) {
                            continue;
                        }

                        $limit = (float)$cat['limit_amount'];
                        $items[] = [
                            'category_id' => (int)$cat['category_id'],
                            'limit_amount' => $limit
                        ];
                        $total_limit += $limit;
                    }
                }
                // dump($_SESSION);
                if (empty($items)) {
                    $error = 'Musisz dodać przynajmniej jedną kategorię z limitem.';
                } else {
                    $budget_id = $this->budgetModel->addBudget(
                        $family_id,
                        $user_id,
                        $name,
                        $period_type,
                        $start_date,
                        $end_date,
                        $items,
                        $total_limit
                    );

                    if ($budget_id) {
                        $success = "Budżet <strong>{$name}</strong> został pomyślnie dodany!";
                    } else {
                        $error = 'Nie udało się dodać budżetu. Spróbuj ponownie.';
                    }
                }
            }
        }

        $this->smarty->assign([
            'session' => $_SESSION,
            'categories' => $categories,
            'success' => $success,
            'error' => $error
        ]);

        $this->smarty->display('add_budget.tpl');
    }

    public function viewBudgets()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $family_id = $_SESSION['family_id'] ?? null;
        $user_id = $_SESSION['user_id'];

        $budgets = $this->budgetModel->getBudgets($family_id, $user_id);
        // dump($budgets);

        $this->smarty->assign([
            'session' => $_SESSION,
            'budgets' => $budgets
        ]);
        $this->smarty->display('view_budgets.tpl');
    }

    public function view()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $budget_id = $_GET['id'] ?? null;
        if (!$budget_id) {
            header('Location: index.php?action=viewBudgets');
            exit;
        }

        $family_id = $_SESSION['family_id'] ?? null;
        $user_id = $_SESSION['user_id'];

        $budgetDetails = $this->budgetModel->getBudgetDetails($budget_id, $family_id, $user_id);

        if (empty($budgetDetails)) {
            $this->smarty->assign('error', 'Nie znaleziono budżetu.');
            $this->smarty->display('error.tpl');
            return;
        }

        $budgetInfo = $budgetDetails[0];

        $this->smarty->assign([
            'session' => $_SESSION,
            'budget' => $budgetInfo,
            'categories' => $budgetDetails
        ]);

        $this->smarty->display('budget_details.tpl');
    }
}
