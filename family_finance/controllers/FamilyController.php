<?php
require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../models/Family.php';
require_once __DIR__ . '/../models/User.php';

class FamilyController
{
    private $familyModel;
    private $userModel;
    private $smarty;

    // tablica z wojewodztwami
    private $voivodeships = [
        "dolnośląskie",
        "kujawsko-pomorskie",
        "lubelskie",
        "lubuskie",
        "łódzkie",
        "małopolskie",
        "mazowieckie",
        "opolskie",
        "podkarpackie",
        "podlaskie",
        "pomorskie",
        "śląskie",
        "świętokrzyskie",
        "warmińsko-mazurskie",
        "wielkopolskie",
        "zachodniopomorskie"
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

    // Sprawdzenie czy użytkownik już ma rodzinę
    if (!empty($_SESSION['family_id'])) {
        header('Location: index.php?action=dashboard');
        exit;
    }

    $this->smarty->assign('session', $_SESSION);
    $this->smarty->assign('voivodeships', $this->voivodeships);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $familyName = trim($_POST['family_name'] ?? '');
        $region = trim($_POST['region'] ?? '');

        if (!$familyName || !$region) {
            $this->smarty->assign('error', 'Wypełnij wszystkie pola.');
            $this->smarty->display('create_family.tpl');
            return;
        }

        // Tworzenie rodziny
        $familyId = $this->familyModel->createFamily($familyName, $region);

        // Przypisanie użytkownika jako administratora rodziny
        $this->familyModel->updateUserFamilyAndRole($_SESSION['user_id'], $familyId, 'family_admin');

        // Aktualizacja sesji
        $_SESSION['family_id'] = $familyId;
        $_SESSION['family_role'] = 'family_admin';

        // Przeładowanie strony
        header('Location: index.php?action=dashboard');
        exit;
    }

    $this->smarty->display('create_family.tpl');
}

}
