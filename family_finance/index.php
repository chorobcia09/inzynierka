<?php
session_start();

require_once './controllers/AuthController.php';
require_once './controllers/UserController.php';

$action = $_GET['action'] ?? 'login';
    
switch ($action) {
    case 'login':
        $authController = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login($_POST);
        } else {
            $authController->showLoginForm();
        }
        break;

    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    case 'users':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        $userController = new UserController();
        $userController->index();
        break;

    default:
        header('Location: index.php');
        exit;
}
