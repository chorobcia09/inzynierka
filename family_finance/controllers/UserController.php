<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;
    private $smarty;

    // Konstruktor przyjmuje obiekt Smarty jako parametr
    public function __construct($smarty)
    {
        $database = new Database();
        $this->userModel = new User($database);
        $this->smarty = $smarty;
    }

    // Wyświetla listę użytkowników
    public function index()
    {
        // Blokada dla niezalogowanych użytkowników
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $users = $this->userModel->getAllUsers();

        // $this->smarty->assign('users', $users);
        // $this->smarty->assign('session', $_SESSION);

        $this->smarty->assign([
            'users' => $users,
            'session' => $_SESSION
        ]);
        $this->smarty->display('users.tpl');
    }
}
