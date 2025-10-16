<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Auth.php';

class AuthController
{
    private $authModel;
    private $smarty;

    // Konstruktor przyjmuje obiekt Smarty jako parametr
    public function __construct($smarty)
    {
        $database = new Database();
        $this->authModel = new Auth($database);
        $this->smarty = $smarty;
    }

    // Wyświetla formularz logowania
    public function showLoginForm($error = '')
    {
        $this->smarty->assign('error', $error);
        $this->smarty->assign('session', $_SESSION ?? []);
        $this->smarty->display('login.tpl');
    }

    // Obsługa logowania
    public function login(array $postData)
    {
        $email = trim($postData['email'] ?? '');
        $password = $postData['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->showLoginForm("Uzupełnij wszystkie pola.");
            return;
        }

        $user = $this->authModel->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['role'] = $user['role'] ?? 'użytkownik';

            header('Location: index.php?action=users');
            exit;
        } else {
            $this->showLoginForm("Nieprawidłowy email lub hasło.");
        }
    }

    // Wylogowanie użytkownika
    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
