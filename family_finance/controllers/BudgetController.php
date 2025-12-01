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
            // dump($_POST);
            $currency = $_POST['currency'];

            $error = null;
            if (empty($name) || empty($start_date) || empty($end_date)) {
                $error = 'Uzupełnij wszystkie wymagane pola.';
            }

            if (!$error) {
                if (!strtotime($start_date) || !strtotime($end_date)) {
                    $error = 'Nieprawidłowy format daty.';
                } elseif ($end_date < $start_date) {
                    $error = 'Data końcowa nie może być wcześniejsza niż data początkowa.';
                }
            }
            if ($error) {
                $this->smarty->assign([
                    'session' => $_SESSION,
                    'categories' => $categories,
                    'success' => $success,
                    'error' => $error
                ]);
                $this->smarty->display('add_budget.tpl');
                return;
            } else {
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
                        $total_limit,
                        $currency
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

        $budgets = $this->budgetModel->getBudgets($family_id, $user_id,);
        $success = $_SESSION['budget_success'] ?? null;
        $error = $_SESSION['budget_error'] ?? null;
        // dump($budgets);
        // dump($_SESSION);
        $this->smarty->assign([
            'session' => $_SESSION,
            'budgets' => $budgets,
            'success' => $success,
            'error' => $error
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
        // dump($_SESSION);
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

    public function edit()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin' || $_SESSION['family_role'] === 'family_member') {
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

        $categoriesModel = new Categories();
        $categories = $categoriesModel->getAllCategories();

        $budgetItems = [];
        foreach ($budgetDetails as $item) {
            $budgetItems[] = [
                'category_id' => $item['category_id'],
                'limit_amount' => $item['limit_amount']
            ];
        }
        // dump($budgetDetails);
        $success = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $period_type = $_POST['period_type'] ?? 'custom';
            $start_date = $_POST['start_date'] ?? null;
            $end_date = $_POST['end_date'] ?? null;
            $currency = $_POST['currency'] ?? 'PLN';

            if (empty($name) || empty($start_date) || empty($end_date)) {
                $error = 'Uzupełnij wszystkie wymagane pola.';
            }

            if (!$error) {
                if (!strtotime($start_date) || !strtotime($end_date)) {
                    $error = 'Nieprawidłowy format daty.';
                } elseif ($end_date < $start_date) {
                    $error = 'Data końcowa nie może być wcześniejsza niż data początkowa.';
                }
            }

            if ($error) {
                $this->smarty->assign([
                    'session' => $_SESSION,
                    'budget_id' => $budget_id,
                    'budget' => $budgetInfo,
                    'budgetItems' => $budgetItems,
                    'categories' => $categories,
                    'success' => $success,
                    'error' => $error
                ]);
                $this->smarty->display('edit_budget.tpl');
                return;
            } else {
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

                if (empty($items)) {
                    $error = 'Musisz dodać przynajmniej jedną kategorię z limitem.';
                } else {
                    $updated = $this->budgetModel->updateBudget(
                        $budget_id,
                        $family_id,
                        $user_id,
                        $name,
                        $period_type,
                        $start_date,
                        $end_date,
                        $items,
                        $total_limit,
                        $currency
                    );

                    if ($updated) {
                        $success = "Budżet <strong>{$name}</strong> został zaktualizowany!";
                        $budgetDetails = $this->budgetModel->getBudgetDetails($budget_id, $family_id, $user_id);
                        $budgetInfo = $budgetDetails[0];

                        $budgetItems = [];
                        foreach ($budgetDetails as $item) {
                            $budgetItems[] = [
                                'category_id' => $item['category_id'],
                                'limit_amount' => $item['limit_amount']
                            ];
                        }
                    } else {
                        $error = 'Nie udało się zaktualizować budżetu. Spróbuj ponownie.';
                    }
                }
            }
        }

        $this->smarty->assign([
            'session' => $_SESSION,
            'budget_id' => $budget_id,
            'budget' => $budgetInfo,
            'budgetItems' => $budgetItems,
            'categories' => $categories,
            'success' => $success,
            'error' => $error
        ]);

        $this->smarty->display('edit_budget.tpl');
    }

    public function delete()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin' || $_SESSION['family_role'] === 'family_member') {
            header('Location: index.php?action=login');
            exit;
        }

        $budget_id = $_GET['id'] ?? null;
        if (!$budget_id) {
            header('Location: index.php?action=viewBudgets');
            exit;
        }

        $deleted = $this->budgetModel->deleteBudget($budget_id, $_SESSION['family_id'], $_SESSION['user_id']);

        if ($deleted) {
            $_SESSION['budget_success'] = "Budżet został usunięty.";
        } else {
            $_SESSION['budget_error'] = "Nie udało się usunąć budżetu.";
        }

        header('Location: index.php?action=viewBudgets');
        exit;
    }
}
