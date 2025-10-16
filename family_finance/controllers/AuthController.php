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

    /**
     * Metoda zabezpieczająca dostępowi do stron logowania/rejestracji dla zalogowanych użytkowników.
     */

    private function redirectIfLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?action=users');
            exit;
        }
    }

    /**
     * Metoda wyświetlająca formularz logowania.
     */
    public function showLoginForm($error = '')
    {
        $this->redirectIfLoggedIn();
        $this->smarty->assign('error', $error);
        $this->smarty->assign('session', $_SESSION ?? []);
        $this->smarty->display('login.tpl');
    }

    /**
     * Metoda do obsługi logowania.
     */
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
            $_SESSION['family_id'] = $user['family_id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['account_type'] = $user['account_type'];

            header('Location: index.php?action=users');
            exit;
        } else {
            $this->showLoginForm("Nieprawidłowy email lub hasło.");
        }
    }

    /**
     * Metoda do wylogowania.
     */
    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    /**
     * Metoda wyświetlająca formularz rejestracji.
     */
    public function showRegisterForm($error = '')
    {
        $this->redirectIfLoggedIn();
        $this->smarty->assign('error', $error);
        $this->smarty->assign('session', $_SESSION ?? []);
        $this->smarty->display('register.tpl');
    }

    /**
     * Metoda do obsługi rejestracji.
     */
    public function register(array $postData)
    {
        $username = trim($postData['username'] ?? '');
        $email = trim($postData['email'] ?? '');
        $password = $postData['password'] ?? '';
        $passwordConfirm = $postData['password_confirm'] ?? '';

        if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)) {
            $this->showRegisterForm("Wypełnij wszystkie pola.");
            return;
        }

        if ($password !== $passwordConfirm) {
            $this->showRegisterForm("Hasła nie są zgodne.");
            return;
        }

        $result = $this->authModel->register($username, $email, $password);

        if ($result) {
            $user = $this->authModel->login($email, $password);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['role'] = $user['role'] ?? 'użytkownik';
            header('Location: index.php?action=users');
            exit;
        } else {
            $this->showRegisterForm("Użytkownik o tym emailu już istnieje.");
        }
    }
}
