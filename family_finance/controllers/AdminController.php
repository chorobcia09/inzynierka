<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AdminController
{
    private $userModel;
    private $smarty;

    public function __construct($smarty)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }
        $database = new Database();
        $this->userModel = new User($database);
        $this->smarty = $smarty;
    }

    public function index() {
        $users = $this->userModel->getAllUsersWithFamily();

        $this->smarty->assign([
            'users' => $users,
            'session' => $_SESSION
        ]);

        $this->smarty->display('admin_panel.tpl');
    }


}
