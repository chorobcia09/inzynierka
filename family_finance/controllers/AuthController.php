<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Auth.php';

/**
 * Kontroller odpowiedzialny za obsługę logowania i wylogowania użytkowników.
 */

class AuthController
{
    private $authModel;

    public function __construct()
    {
        $database = new Database();
        $this->authModel = new Auth($database);
    }

    /**
     * Metoda wyświetlająca formularz logowania.
     */
    public function showLoginForm($error = '')
    {
        require __DIR__ . '/../views/login.php';
    }

    /**
     * Metoda do obsługi logowania.
     */
    public function login(array $postData)
    {
        $email = $postData['email'] ?? '';
        $password = $postData['password'] ?? '';

        $user = $this->authModel->login($email, $password);

        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];

            header('Location: index.php?action=users');
            exit;
        } else {
            $error = "Nieprawidłowy email lub hasło.";
            $this->showLoginForm($error);
        }
    }

    /**
     * Metoda do obsługi wylogowania.
     */
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
