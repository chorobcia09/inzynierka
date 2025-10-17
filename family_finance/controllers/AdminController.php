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
                $UID = !empty($_POST['UID']) ? $_POST['UID'] : $this->generateRandomCode(10);

                $this->userModel->createUser(
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['role'],
                    $_POST['family_id'] ?? null,
                    $UID
                );

                header('Location: index.php?action=adminPanel');
                exit;
            } catch (Exception $e) {
                $this->smarty->assign('error', $e->getMessage());
                $this->smarty->assign('session', $_SESSION);
                $this->smarty->display('add_user.tpl');
            }
        } else {
            $this->smarty->assign('session', $_SESSION);
            $this->smarty->display('add_user.tpl');
        }
    }

    /**
     * Metoda generująca randomowy kod do UID.
     */
    private function generateRandomCode($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()-_=+';
        $charactersLength = strlen($characters);
        $randomCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomCode;
    }


    public function deleteUser($id)
    {
        // Blokada dla niezalogowanych / niez uprawnionych
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $this->userModel->deleteUser($id);
        header('Location: index.php?action=adminPanel');
        exit;
    }

    public function editUser($id)
    {
        // Blokada dla niezalogowanych / nieuprawnionych
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $password = !empty($_POST['password']) ? $_POST['password'] : null;

                $this->userModel->updateUser(
                    $id,
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['role'],
                    $_POST['family_id'] ?? null,
                    $password
                );

                header('Location: index.php?action=adminPanel');
                exit;
            } catch (Exception $e) {
                $user = $this->userModel->getUserById($id);
                $this->smarty->assign([
                    'error' => $e->getMessage(),
                    'user' => $user,
                    'session' => $_SESSION
                ]);
                $this->smarty->display('edit_user.tpl');
            }
        } else {
            $user = $this->userModel->getUserById($id);
            if (!$user) {
                header('Location: index.php?action=adminPanel');
                exit;
            }

            $this->smarty->assign([
                'user' => $user,
                'session' => $_SESSION
            ]);
            $this->smarty->display('edit_user.tpl');
        }
    }
}
