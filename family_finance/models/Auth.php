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

    /**
     * Metoda do obsługi rejestracji.
     */

    public function register(string $username, string $email, string $password, string $UID = null)
    {
        if ($this->userModel->getUserByEmail($email)) {
            return false;
        }

        if (!$UID) {
            $UID = $this->generateRandomCode(10);
        }

        return $this->userModel->createUser(
            $username,
            $email,
            $password,
            'member',
            null,
            $UID
        );
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
}
