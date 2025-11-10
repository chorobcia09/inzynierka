<?php
session_start();

require_once __DIR__ . '/config/smarty.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/FamilyController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/TransactionController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/FeedbackController.php';
require_once __DIR__ . '/controllers/BudgetController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    // ------------------------------HOMECONTROLLER------------------------------
    case 'home':
        $smarty->display('landing.tpl');
        break;

    // ------------------------------AUTHCONTROLLER------------------------------
    case 'login':
        $controller = new AuthController($smarty); // przekazujemy Smarty
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login($_POST);
        } else {
            $controller->showLoginForm();
        }
        break;

    case 'register':
        $controller = new AuthController($smarty);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register($_POST);
        } else {
            $controller->showRegisterForm();
        }
        break;

    case 'logout':
        (new AuthController($smarty))->logout();
        break;

    // ------------------------------ADMINCONTROLLER------------------------------
    case 'adminPanel':
        (new AdminController($smarty))->index();
        break;

    case 'addUserForm':
        (new AdminController($smarty))->addUser();
        break;

    case 'deleteUser':
        (new AdminController($smarty))->deleteUser($_GET['id'] ?? null);
        break;

    case 'editUser':
        (new AdminController($smarty))->editUser($_GET['id'] ?? null);
        break;


    // ------------------------------FAMILYCONTROLLER------------------------------
    case 'usersFamily':
        (new FamilyController($smarty))->index();
        break;
    case 'createFamily':
        (new FamilyController($smarty))->create();
        break;
    case 'deleteFamily':
        (new FamilyController($smarty))->delete();
        break;
    case 'addUserToFamily':
        (new FamilyController($smarty))->addUser();
        break;
    case 'deleteUserFromFamily':
        (new FamilyController($smarty))->deleteUser($_GET['id'] ?? null);
        break;

    // ------------------------------USERCONTROLLER------------------------------
    case 'userPanel':
        (new UserController($smarty))->panel();
        break;
    case 'changePassword':
        (new UserController($smarty))->changePassword();
        break;


    // ------------------------------DASHBOARDCONTROLLER------------------------------
    case 'dashboard':
        (new DashboardController($smarty))->index();
        break;

    // ------------------------------TRANSACTIONSCONTROLLER------------------------------
    case 'manageTransactions':
        (new TransactionController($smarty))->index();
        break;
    case 'addTransaction':
        (new TransactionController($smarty))->addTransaction();
        break;
    case 'deleteTransaction':
        (new TransactionController($smarty))->deleteTransaction($_GET['id'] ?? null);
        break;
    case 'transactionDetails':
        (new TransactionController($smarty))->transactionDetails($_GET['id'] ?? null);
        break;

    // ------------------------------CATEGORYSCONTROLLER------------------------------
    case 'categories':
        (new CategoryController($smarty))->index();
        break;
    case 'viewCategory':
        (new CategoryController($smarty))->viewCategory($_GET['id'] ?? null);
        break;
    case 'addSubCategory':
        (new CategoryController($smarty))->addSubCategory();
        break;

    // ------------------------------FEEDBACKCONTROLLER------------------------------
    case 'addFeedback':
        (new FeedbackController($smarty))->add();
        break;
    case 'feedbackPanel':
        (new FeedbackController($smarty))->index();
        break;
    case 'changeStatus':
        (new FeedbackController($smarty))->changeStatus();
        break;
    // ------------------------------BUDGETCONTROLLER------------------------------
    case 'addBudget':
        (new BudgetController($smarty))->add();
        break;
    case 'viewBudgets':
        (new BudgetController($smarty))->viewBudgets();
        break;
    case 'viewBudget':
        require_once 'controllers/BudgetController.php';
        $controller = new BudgetController($smarty);
        $controller->view();
        break;
    default:
        (new AuthController($smarty))->showLoginForm();
        break;
}
