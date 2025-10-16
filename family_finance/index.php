<?php
session_start();

require_once __DIR__ . '/config/smarty.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';

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

    case 'logout':
        (new AuthController($smarty))->logout();
        break;

    case 'users':
        (new UserController($smarty))->index();
        break;

    default:
        (new AuthController($smarty))->showLoginForm();
        break;
}
