<?php

require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Transactions.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Family.php';
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/SubCategories.php';

class TransactionController
{
    private $smarty;
    private $transactionModel;
    private $userModel;
    private $familyModel;
    private $categoriesModel;
    private $subCategoriesModel;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
        $db = new Database();
        $this->transactionModel = new Transactions($db);
        $this->userModel = new User($db);
        $this->familyModel = new Family($db);
        $this->categoriesModel = new Categories($db);
        $this->subCategoriesModel = new SubCategories($db);
    }

    /**
     * Wyświetlanie na stronie tabeli z transakcjami
     */

    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $transactions = [];
        if (!empty($_SESSION['family_id'])) {
            $transactions = $this->transactionModel->getAllTransactionsByFamily($_SESSION['family_id']);
        }
        $transactionsUser = $this->transactionModel->getAllTransactionsByUser($_SESSION['user_id']);
        $this->smarty->assign([
            'transactions' => $transactions,
            'session' => $_SESSION,
            'transactionsUser' => $transactionsUser
        ]);
        $this->smarty->display('manage_transactions.tpl');
    }

    /**
     * Metoda dodająca transakcje
     */

    public function addTransaction()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }


        // pobranie kategorii
        $categories = $this->categoriesModel->getAllCategories();
        $subCategories = $this->subCategoriesModel->getAllGlobalSubCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $family_id = $_SESSION['family_id'] ?? null;
            $user_id = $_SESSION['user_id'];

            $category_id = $_POST['category_id'] ?? null;
            $sub_category_id = $_POST['sub_category_id'] ?? null;
            $type = $_POST['type'] ?? null;
            $amount = $_POST['amount'] ?? null;
            $currency = $_POST['currency'] ?? 'PLN';
            $payment_method = $_POST['payment_method'] ?? 'cash';
            $description = $_POST['description'] ?? '';
            $transaction_date = $_POST['transaction_date'] ?? date('Y-m-d H:i:s');
            $is_recurring = isset($_POST['is_recurring']) ? 1 : 0;

            $errors = [];

            if (!$type || !in_array($type, ['expense', 'income'])) $errors[] = 'Nieprawidłowy typ';
            if (!$amount || !is_numeric($amount) || $amount <= 0) $errors[] = 'Nieprawidłowa kwota';


            if (!empty($errors)) {
                $this->smarty->assign('errors', $errors);
                $this->smarty->assign('old', $_POST);
                $this->smarty->assign('session', $_SESSION);
                $this->smarty->display('add_transaction.tpl');
                return;
            }

            // DODANIE TRANSAKCJI GLOWNEJ
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
            // dump($_POST);
            // DODANIE ELEMENTU TRANSAKCJI
            if ($res && !empty($_POST['items'])) {
                foreach ($_POST['items'] as $item) {
                    // dump($item);
                    if (!empty($item['subcategory_id']) && !empty($item['amount'])) {
                        $this->transactionModel->addTransactionItem(
                            $res,
                            $category_id,
                            (int)$item['subcategory_id'],
                            (float)$item['amount'],
                            (int)($item['quantity'] ?? 1)
                        );
                    }
                }
            }


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
            // GET wyswietlenie formularza
            $this->smarty->assign([
                'session' => $_SESSION,
                'categories' => $categories,
                'subCategories' => $subCategories
            ]);
            $this->smarty->display('add_transaction.tpl');
            return;
        }
    }

    public function deleteTransaction($transaction_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $family_role = $_SESSION['family_role'] ?? null;

        if ($family_role === 'family_member') {
            header('Location: index.php?action=manageTransactions&error=no_permission');
            exit;
        }

        if ($family_role === 'family_admin') {
            $this->transactionModel->deleteTransaction($transaction_id);
            header('Location: index.php?action=manageTransactions&success=deleted');
            exit;
        }

        if ($family_role === null) {
            $this->transactionModel->deleteUserTransaction($transaction_id, $user_id);
            header('Location: index.php?action=manageTransactions&success=deleted');
            exit;
        }

        header('Location: index.php?action=manageTransactions&error=no_permission');
        exit;
    }

    public function transactionDetails(int $transaction_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $transaction = $this->transactionModel->getTransactionDetails($transaction_id);

        $this->smarty->assign([
            'session' => $_SESSION,
            'transaction' => $transaction
        ]);
        $this->smarty->display('transaction_details.tpl');
        return;
    }

    public function getCategoriesByType()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if (!isset($_GET['type'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Brak parametru type']);
            exit;
        }

        $type = $_GET['type'];
        if (!in_array($type, ['income', 'expense'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nieprawidłowy typ']);
            exit;
        }

        $categories = $this->categoriesModel->getCategoriesByType($type); // <- tylko tu

        if (!$categories) {
            http_response_code(500);
            echo json_encode(['error' => 'Brak kategorii w bazie dla tego typu']);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode($categories);
        exit;
    }
    
    public function getSubcategoriesByCategory()
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Brak autoryzacji']);
            exit;
        }

        if (empty($_GET['category_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Brak ID kategorii']);
            exit;
        }

        $category_id = (int) $_GET['category_id'];
        $subcategories = $this->subCategoriesModel->getSubCategoriesByCategory($category_id);

        header('Content-Type: application/json');
        echo json_encode($subcategories ?: []);
        exit;
    }
}
