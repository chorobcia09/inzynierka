<?php
session_start();

require_once __DIR__ . '/config/smarty.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/FamilyController.php';
require_once __DIR__ . '/controllers/DashboardController.php';

$action = $_GET['action'] ?? 'login';

switch ($action) {
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

    case 'users':
        (new FamilyController($smarty))->index();
        break;

    case 'userPanel':
        (new UserController($smarty))->panel();
        break;

    case 'adminPanel':
        (new AdminController($smarty))->index();
        break;

    case 'addUserForm':
        (new AdminController($smarty))->addUser();
        break;

    case 'deleteUser':
        (new AdminController($smarty))->deleteUser($_GET['id'] ?? null);
        break;
    case 'deleteUserFromFamily':
        (new FamilyController($smarty))->deleteUser($_GET['id'] ?? null);
        break;
    case 'editUser':
        (new AdminController($smarty))->editUser($_GET['id'] ?? null);
        break;
    case 'createFamily':
        (new FamilyController($smarty))->create();
        break;
    case 'addUserToFamily':
        (new FamilyController($smarty))->addUser();
        break;

    case 'dashboard':
        (new DashboardController($smarty))->index();
        break;


    default:
        (new AuthController($smarty))->showLoginForm();
        break;
}
