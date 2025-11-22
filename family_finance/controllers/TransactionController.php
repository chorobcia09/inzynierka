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

    /** Wyświetla listę transakcji */
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

    /** Dodaje nową transakcję */
    public function addTransaction()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $family_id = $_SESSION['family_id'] ?? null;
        $user_id = $_SESSION['user_id'];
        $categories = $this->categoriesModel->getAllCategories();
        $subCategories = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'] ?? null;
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
            if (!$category_id) $errors[] = 'Wybierz kategorię';

            if (!empty($errors)) {
                $this->smarty->assign('errors', $errors);
                $this->smarty->assign('old', $_POST);
                $this->smarty->assign('session', $_SESSION);

                if ($category_id) {
                    $subCategories = $this->subCategoriesModel->getAllSubCategories($category_id, $user_id, $family_id);
                }

                $this->smarty->assign('categories', $categories);
                $this->smarty->assign('subCategories', $subCategories);
                $this->smarty->display('add_transaction.tpl');
                return;
            }

            $transaction_id = $this->transactionModel->addTransaction(
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

            $itemsAdded = false;
            if ($transaction_id && !empty($_POST['items'])) {
                foreach ($_POST['items'] as $item) {
                    if (!empty($item['subcategory_id']) && !empty($item['amount'])) {
                        $itemAdded = $this->transactionModel->addTransactionItem(
                            $transaction_id,
                            $category_id,
                            (int)$item['subcategory_id'],
                            (float)$item['amount'],
                            (int)($item['quantity'] ?? 1)
                        );
                        if ($itemAdded) {
                            $itemsAdded = true;
                        }
                    }
                }
            }

            if ($transaction_id) {
                if ($itemsAdded || empty($_POST['items'])) {
                    $this->smarty->assign('success', 'Transakcja dodana pomyślnie!');
                    $this->smarty->assign('old', []);
                    $subCategories = [];
                } else {
                    $this->smarty->assign('errors', ['Transakcja została dodana, ale nie udało się dodać pozycji.']);
                    $this->smarty->assign('old', $_POST);
                    $subCategories = $this->subCategoriesModel->getAllSubCategories($category_id, $user_id, $family_id);
                }
            } else {
                $this->smarty->assign('errors', ['Nie udało się dodać transakcji.']);
                $this->smarty->assign('old', $_POST);
                if ($category_id) {
                    $subCategories = $this->subCategoriesModel->getAllSubCategories($category_id, $user_id, $family_id);
                }
            }

            $this->smarty->assign([
                'session' => $_SESSION,
                'categories' => $categories,
                'subCategories' => $subCategories
            ]);
            $this->smarty->display('add_transaction.tpl');
            return;
        } else {
            $this->smarty->assign([
                'session' => $_SESSION,
                'categories' => $categories,
                'subCategories' => $subCategories
            ]);
            $this->smarty->display('add_transaction.tpl');
            return;
        }
    }

    /** Usuwa transakcję */
    public function deleteTransaction($transaction_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
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

    /** Wyświetla szczegóły transakcji */
    public function transactionDetails(int $transaction_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
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

    /** Zwraca kategorie wg typu (AJAX) */
    public function getCategoriesByType()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
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

        $categories = $this->categoriesModel->getCategoriesByType($type);

        if (!$categories) {
            http_response_code(500);
            echo json_encode(['error' => 'Brak kategorii w bazie dla tego typu']);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode($categories);
        exit;
    }

    /** Zwraca podkategorie wg kategorii (AJAX) */
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
        $user_id = $_SESSION['user_id'];
        $family_id = $_SESSION['family_id'] ?? null;

        $subcategories = $this->subCategoriesModel->getAllSubCategories($category_id, $user_id, $family_id);

        header('Content-Type: application/json');
        echo json_encode($subcategories ?: []);
        exit;
    }

    /** Edytuje istniejącą transakcję */
    public function editTransaction()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $family_id = $_SESSION['family_id'] ?? null;
        $user_id = $_SESSION['user_id'];
        $transaction_id = $_GET['id'] ?? null;

        if (!$transaction_id) {
            header('Location: index.php?action=manageTransactions');
            exit;
        }

        $hasAccess = $this->transactionModel->checkUserAccess($transaction_id, $user_id, $family_id);
        if (!$hasAccess) {
            header('Location: index.php?action=manageTransactions&error=no_access');
            exit;
        }

        $transaction = $this->transactionModel->getTransactionForEdit($transaction_id);
        if (!$transaction) {
            header('Location: index.php?action=manageTransactions&error=not_found');
            exit;
        }

        $transactionItems = $this->transactionModel->getTransactionDetails($transaction_id);
        $categories = $this->categoriesModel->getAllCategories();
        $subCategories = $this->subCategoriesModel->getAllSubCategories($transaction['category_id'], $user_id, $family_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'] ?? null;
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
            if (!$category_id) $errors[] = 'Wybierz kategorię';

            if (!empty($errors)) {
                $this->smarty->assign('errors', $errors);
                $subCategories = $this->subCategoriesModel->getAllSubCategories($category_id, $user_id, $family_id);
            } else {
                try {
                    $updated = $this->transactionModel->updateTransaction(
                        $transaction_id,
                        $category_id,
                        $type,
                        (float)$amount,
                        $currency,
                        $payment_method,
                        $description,
                        $transaction_date,
                        $is_recurring
                    );

                    if ($updated) {
                        $this->transactionModel->deleteTransactionItems($transaction_id);

                        if (!empty($_POST['items'])) {
                            foreach ($_POST['items'] as $item) {
                                if (!empty($item['subcategory_id']) && !empty($item['amount'])) {
                                    $this->transactionModel->addTransactionItem(
                                        $transaction_id,
                                        $category_id,
                                        (int)$item['subcategory_id'],
                                        (float)$item['amount'],
                                        (int)($item['quantity'] ?? 1)
                                    );
                                }
                            }
                        }

                        $this->smarty->assign('success', 'Transakcja została zaktualizowana!');
                        $transaction = $this->transactionModel->getTransactionForEdit($transaction_id);
                        $transactionItems = $this->transactionModel->getTransactionDetails($transaction_id);
                        $subCategories = $this->subCategoriesModel->getAllSubCategories($category_id, $user_id, $family_id);
                    } else {
                        $this->smarty->assign('errors', ['Nie udało się zaktualizować transakcji.']);
                    }
                } catch (Exception $e) {
                    $this->smarty->assign('errors', ['Wystąpił błąd podczas aktualizacji transakcji.']);
                }
            }
        }

        $this->smarty->assign([
            'session' => $_SESSION,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'transaction' => $transaction,
            'transactionItems' => $transactionItems,
            'transaction_id' => $transaction_id
        ]);

        $this->smarty->display('edit_transaction.tpl');
    }
}
