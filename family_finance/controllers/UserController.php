<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $database = new Database();
        $this->userModel = new User($database);
    }

    /**
     * Metoda służąca do wyświetlenia wszystkich użytkowników
     */
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $users = $this->userModel->getAllUsers();

        // Wyświetlamy widok z listą użytkowników
        require __DIR__ . '/../views/users.php';
    }

    /**
     * Metoda służąca do wyświetlenia wszystkich użytkowników po ID
     */
    public function show(int $id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user = $this->userModel->getUsersById($id);

        require __DIR__ . '/../views/user_detail.php';
    }

    /**
     * Metoda służąca do wyświetlenia wszystkich użytkowników po ID RODZINY
     */
    public function byFamily(int $family_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $users = $this->userModel->getUsersByFamily($family_id);

        require __DIR__ . '/../views/users.php';
    }
}
