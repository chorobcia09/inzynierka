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

    public function index()
    {
        $users = $this->userModel->getAllUsersWithFamily();

        $this->smarty->assign([
            'users' => $users,
            'session' => $_SESSION
        ]);

        $this->smarty->display('admin_panel.tpl');
    }

    public function addUser()
    {
        // Blokada dla niezalogowanych / niez uprawnionych
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->userModel->createUser(
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['role'],
                    $_POST['family_id'] ?? null
                );
                header('Location: index.php?action=adminPanel');

                exit;
            } catch (Exception $e) {
                // Przekaż komunikat błędu do widoku
                $this->smarty->assign('error', $e->getMessage());
                $this->smarty->assign('session', $_SESSION);
                $this->smarty->display('add_user.tpl');
            }
        } else {
            $this->smarty->assign('session', $_SESSION);
            $this->smarty->display('add_user.tpl');
        }
    }
}
