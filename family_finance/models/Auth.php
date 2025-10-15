<?php
require_once __DIR__ . '/User.php';

/**
 * Kontroler odpowiedzialny za sprawdzanie poprawności logowania.
 */

class Auth
{
    private $userModel;

    public function __construct($database)
    {
        $this->userModel = new User($database);
    }

    /**
     * Metoda sprawdzająca poprawność logowania.
     */
    public function login(string $email, string $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
