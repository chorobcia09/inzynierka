<?php

require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Transactions.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Family.php';

class TransactionController
{
    private $smarty;
    private $transactionModel;
    private $userModel;
    private $familyModel;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
        $db = new Database();
        $this->transactionModel = new Transactions($db);
        $this->userModel = new User($db);
        $this->familyModel = new Family($db);
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public function addTransaction()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $family_id = $_SESSION['family_id'] ?? null;
            $user_id = $_SESSION['user_id'];

            $category_id = $_POST['category_id'] ?? null;
            $type = $_POST['type'] ?? null;
            $amount = $_POST['amount'] ?? null;
            $currency = $_POST['currency'] ?? 'PLN';
            $payment_method = $_POST['payment_method'] ?? 'cash';
            $description = $_POST['description'] ?? '';
            $transaction_date = $_POST['transaction_date'] ?? date('Y-m-d H:i:s');
            $is_recurring = isset($_POST['is_recurring']) ? 1 : 0;

            $errors = [];
            if (!$family_id) $errors[] = 'Brak rodziny';
            if (!$type || !in_array($type, ['expense', 'income'])) $errors[] = 'Nieprawidłowy typ';
            if (!$amount || !is_numeric($amount) || $amount <= 0) $errors[] = 'Nieprawidłowa kwota';

            if (!empty($errors)) {
                $this->smarty->assign('errors', $errors);
                $this->smarty->assign('old', $_POST);
                $this->smarty->assign('session', $_SESSION);
                $this->smarty->display('add_transaction.tpl');
                return;
            }

            $res = $this->transactionModel->addTransaction(
                $family_id,
                $user_id,
                $category_id,
                null,
                $type,
                (float)$amount,
                $currency,
                $payment_method,
                $description,
                $transaction_date,
                $is_recurring
            );



            if ($res) {
                $this->smarty->assign('success', 'Transakcja dodana pomyślnie!');
            } else {
                $this->smarty->assign('errors', ['Nie udało się dodać transakcji.']);
            }

            $this->smarty->assign('old', $_POST);
            $this->smarty->assign('session', $_SESSION);
            $this->smarty->display('add_transaction.tpl');
            return;
        } else {
            // --- obsługa GET, wyświetlenie formularza ---
            $this->smarty->assign('session', $_SESSION);
            $this->smarty->display('add_transaction.tpl');
            return;
        }
    }
}
