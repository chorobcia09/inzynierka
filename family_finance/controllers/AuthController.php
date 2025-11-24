<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Auth.php';

/**
 * Klasa do obsługi logowania/rejestracji
 */
class AuthController
{
    private $authModel;
    private $smarty;

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
            header('Location: index.php?action=dashboard');
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
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['account_type'] = $user['account_type'];
            $_SESSION['family_role'] = $user['family_role'];


            header('Location: index.php?action=dashboard');
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
        session_unset();
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

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->showRegisterForm("Nieprawidłowy adres email.");
            return;
        }

        if ($password !== $passwordConfirm) {
            $this->showRegisterForm("Hasła nie są zgodne.");
            return;
        }

        if (preg_match('/\s/', $password)) {
            $this->showRegisterForm("Hasło nie może zawierać spacji ani na początku, ani w środku ani na końcu.");
            return;
        }

        if (strlen($password) < 8) {
            $this->showRegisterForm("Hasło musi mieć minimum 8 znaków.");
            return;
        }

        if (!preg_match('/[0-9]/', $password)) {
            $this->showRegisterForm("Hasło musi zawierać co najmniej jedną cyfrę.");
            return;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $this->showRegisterForm("Hasło musi zawierać co najmniej jedną dużą literę.");
            return;
        }

        if (!preg_match('/[a-z]/', $password)) {
            $this->showRegisterForm("Hasło musi zawierać co najmniej jedną małą literę.");
            return;
        }

        if (!preg_match('/[\!\@\#\$\%\^\&\*\(\)\-\_\=\+]/', $password)) {
            $this->showRegisterForm("Hasło musi zawierać co najmniej jeden znak specjalny (!@#$%^&*()-_=+).");
            return;
        }

        try {
            $result = $this->authModel->register($username, $email, $password);
            if ($result) {
                $user = $this->authModel->login($email, $password);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['role'] = $user['role'] ?? 'użytkownik';
                $_SESSION['email'] = $user['email'];
                $_SESSION['family_id'] = $user['family_id'] ?? null;
                $_SESSION['family_role'] = $user['family_role'] ?? null;
                $_SESSION['account_type'] = $user['account_type'] ?? null;

                header('Location: index.php?action=dashboard');
                exit;
            } else {
                $this->showRegisterForm("Użytkownik o tym emailu już istnieje.");
            }
        } catch (Exception $e) {
            $this->showRegisterForm($e->getMessage());
        }
    }
}
