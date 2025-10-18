<?php
session_start();

require_once __DIR__ . '/config/smarty.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/FamilyController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/TransactionController.php';

$action = $_GET['action'] ?? 'login';

switch ($action) {
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

    // ------------------------------USERCONTROLLER------------------------------
    case 'userPanel':
        (new UserController($smarty))->panel();
        break;

    // ------------------------------DASHBOARDCONTROLLER------------------------------
    case 'dashboard':
        (new DashboardController($smarty))->index();
        break;

    // ------------------------------DASHBOARDCONTROLLER------------------------------
    case 'addTransaction':
        (new TransactionController($smarty))->addTransaction();
        break;

    default:
        (new AuthController($smarty))->showLoginForm();
        break;
}
