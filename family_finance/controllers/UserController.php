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

    public function changePassword()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $errors = [];
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Sprawdzenie czy pola nie są puste
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $errors[] = 'Wszystkie pola są wymagane.';
            } elseif ($newPassword !== $confirmPassword) {
                $errors[] = 'Nowe hasła nie są identyczne.';
            } elseif (strlen($newPassword) < 8) {
                $errors[] = 'Nowe hasło musi mieć co najmniej 8 znaków.';
            }

            if (empty($errors)) {
                // Pobranie aktualnego hasła z bazy
                $user = $this->userModel->getUserById($_SESSION['user_id']);
                if (!$user || !password_verify($currentPassword, $user['password'])) {
                    $errors[] = 'Nieprawidłowe aktualne hasło.';
                } else {
                    // Hashowanie i aktualizacja hasła
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $this->userModel->updatePassword($_SESSION['user_id'], $hashedPassword);
                    $success = 'Hasło zostało pomyślnie zmienione.';
                }
            }
        }

        $this->smarty->assign([
            'errors' => $errors,
            'success' => $success,
            'session' => $_SESSION
        ]);
        $this->smarty->display('change_password.tpl');
    }

    public function upgradeToPremium()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $success = null;
        $error = null;

        try {
            $this->userModel->upgradeToPremium($_SESSION['user_id']);
            $_SESSION['account_type'] = 'premium';

            $success = 'Twoje konto zostało zaktualizowane do wersji Premium!';
        } catch (Exception $e) {
            $error = 'Wystąpił błąd podczas aktualizacji konta: ' . $e->getMessage();
        }

        $user = $this->userModel->getInfoAboutFamiliesWithUserByUserId($_SESSION['user_id']);

        $this->smarty->assign([
            'user' => $user[0],
            'success' => $success,
            'error' => $error,
            'session' => $_SESSION
        ]);
        $this->smarty->display('panel.tpl');
    }
}
