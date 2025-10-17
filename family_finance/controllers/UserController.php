<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;
    private $smarty;

    public function __construct($smarty)
    {
        $database = new Database();
        $this->userModel = new User($database);
        $this->smarty = $smarty;
    }

    /**
     * Metoda wyświetlająca użytkowników.
     */
    public function index()
    {
        // Blokada dla niezalogowanych użytkowników
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SESSION['role'] == 'admin') {
            $users = $this->userModel->getAllUsersWithFamily();
        } else {
            $users = $this->userModel->getUsersByFamilyId($_SESSION['family_id'] ?? null);
        }

        $this->smarty->assign([
            'users' => $users,
            'session' => $_SESSION
        ]);
        $this->smarty->display('users.tpl');
    }

    /**
     * Metoda wyświetlająca panel użytkownika
     */
    public function panel()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user = $this->userModel->getInfoAboutFamiliesWithUserByUserId($_SESSION['user_id']);
        $this->smarty->assign('user', $user[0]);
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display('panel.tpl');
    }
    
}
