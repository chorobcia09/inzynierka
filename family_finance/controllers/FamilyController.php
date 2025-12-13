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
     * Metoda wyświetlająca użytkowników rodziny.
     */
    public function index()
    {
        // Blokada dla niezalogowanych użytkowników
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin' || !isset($_SESSION['family_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $users = $this->userModel->getUsersByFamilyId($_SESSION['family_id'] ?? null);


        $this->smarty->assign([
            'users' => $users,
            'session' => $_SESSION
        ]);



        $this->smarty->display('users_family.tpl');
    }

    /**
     * Wyświetla formularz tworzenia rodziny
     */
    public function create()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

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

            $familyId = $this->familyModel->createFamily($familyName, $region);
            $this->familyModel->updateUserFamilyAndRole($_SESSION['user_id'], $familyId, 'family_admin');

            $_SESSION['family_id'] = $familyId;
            $_SESSION['family_role'] = 'family_admin';

            header('Location: index.php?action=dashboard');
            exit;
        }

        $this->smarty->display('create_family.tpl');
    }

    public function delete()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['family_role'] ?? '') !== 'family_admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $familyId = $_SESSION['family_id'] ?? null;

        if (!$familyId) {
            header('Location: index.php?action=dashboard');
            exit;
        }

        try {
            $this->familyModel->deleteFamily($familyId);

            $_SESSION['family_id'] = null;
            $_SESSION['family_role'] = null;
            unset($_SESSION['family_name']);
            header('Location: index.php?action=dashboard');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Wystąpił błąd: ' . $e->getMessage();
            header('Location: index.php?action=dashboard');
            exit;
        }
    }


    public function addUser()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin' || $_SESSION['family_role'] == 'family_member') {
            header('Location: index.php?action=login');
            exit;
        }

        if (empty($_SESSION['family_id'])) {
            $this->smarty->assign('error', 'Nie jesteś przypisany do żadnej rodziny.');
            $this->smarty->display('error.tpl');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $UID = trim($_POST['UID'] ?? '');

            if (empty($UID)) {
                $this->smarty->assign('error', 'Wprowadź kod UID użytkownika.');

                $this->smarty->display('add_user_to_family.tpl');
                return;
            }

            try {
                $this->familyModel->addUserToFamily($_SESSION['family_id'], $UID);

                $this->smarty->assign('success', 'Użytkownik został pomyślnie dodany do rodziny!');
                $this->smarty->assign([
                    'session' => $_SESSION
                ]);
                $this->smarty->display('add_user_to_family.tpl');
            } catch (Exception $e) {
                $this->smarty->assign('error', $e->getMessage());
                $this->smarty->assign([
                    'session' => $_SESSION
                ]);
                $this->smarty->display('add_user_to_family.tpl');
            }
        } else {
            $this->smarty->assign([
                'session' => $_SESSION
            ]);
            $this->smarty->display('add_user_to_family.tpl');
        }
    }

    public function deleteUser($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['family_role'] !== 'family_admin') {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SESSION['user_id'] == $id) {
            $_SESSION['error'] = 'Administrator rodziny nie może usunąć samego siebie.';
            header('Location: index.php?action=usersFamily');
            exit;
        }

        $this->familyModel->deleteUserFromFamily($id);
        header('Location: index.php?action=usersFamily');
        exit;
    }
}
