<?php

require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../config/database.php';

class TransactionController {
    private $smarty;
    private $userModel;
    private $familyModel;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
        $this->userModel = new User(new Database());
        $this->familyModel = new Family();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        // czyszczenie cache
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display('add_transaction.tpl');
    }
}
