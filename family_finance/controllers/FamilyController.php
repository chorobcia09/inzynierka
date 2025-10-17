<?php
require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../models/Family.php';
require_once __DIR__ . '/../models/User.php';

class FamilyController
{
    private $familyModel;
    private $userModel;
    private $smarty;

    private $voivodeships = [
        "dolnośląskie", "kujawsko-pomorskie", "lubelskie", "lubuskie", 
        "łódzkie", "małopolskie", "mazowieckie", "opolskie", 
        "podkarpackie", "podlaskie", "pomorskie", "śląskie", 
        "świętokrzyskie", "warmińsko-mazurskie", "wielkopolskie", "zachodniopomorskie"
    ];

    public function __construct($smarty)
    {
        $this->familyModel = new Family();
        $this->userModel = new User(new Database());
        $this->smarty = $smarty;
    }

    /**
     * Wyświetla formularz tworzenia rodziny
     */
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $this->smarty->assign('session', $_SESSION);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $familyName = $_POST['family_name'] ?? '';
            $region = $_POST['region'] ?? '';

            if (!$familyName || !$region) {
                $this->smarty->assign('error', 'Wypełnij wszystkie pola.');
                $this->smarty->assign('voivodeships', $this->voivodeships);
                $this->smarty->display('create_family.tpl');
                return;
            }

            // Tworzymy rodzinę
            $familyId = $this->familyModel->createFamily($familyName, $region);

            // Przypisujemy użytkownika do rodziny
            $this->userModel->updateUserFamily($_SESSION['user_id'], $familyId);

            $this->smarty->assign('success', 'Rodzina została utworzona pomyślnie!');
        }

        $this->smarty->assign('voivodeships', $this->voivodeships);
        $this->smarty->display('create_family.tpl');
    }
}
