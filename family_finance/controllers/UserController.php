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
     * Metoda wyświetlająca panel użytkownika
     */
    public function panel()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $user = $this->userModel->getInfoAboutFamiliesWithUserByUserId($_SESSION['user_id']);
        $this->smarty->assign('user', $user[0]);
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display('panel.tpl');
    }
}
