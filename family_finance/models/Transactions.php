<?php
require_once __DIR__ . '/../config/database.php';

class Transactions
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Dodanie transakcji
     */

    public function addTransaction(
        ?int $family_id,
        int $user_id,
        int $category_id = null,
        int $local_category_id = null,
        string $type,
        float $amount,
        string $currency,
        string $payment_method,
        string $description,
        string $transaction_date,
        int $is_recurring = 0,
        $receipt_blob = null
    ) {
        $sql = "
        INSERT INTO transactions (
            family_id, user_id, category_id, local_category_id,
            type, amount, currency, payment_method,
            description, transaction_date, is_recurring, receipt_blob
        ) VALUES (
            :family_id, :user_id, :category_id, :local_category_id,
            :type, :amount, :currency, :payment_method,
            :description, :transaction_date, :is_recurring, :receipt_blob
        )
    ";

        try {
            $this->db->execute($sql, [
                ':family_id' => $family_id,
                ':user_id' => $user_id,
                ':category_id' => $category_id,
                ':local_category_id' => $local_category_id,
                ':type' => $type,
                ':amount' => $amount,
                ':currency' => $currency,
                ':payment_method' => $payment_method,
                ':description' => $description,
                ':transaction_date' => $transaction_date,
                ':is_recurring' => $is_recurring,
                ':receipt_blob' => $receipt_blob
            ]);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("DB error (addTransaction): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Dodanie elementu transakcji
     */

    public function addTransactionItem(
        int $transaction_id,
        int $category_id,
        ?int $sub_category_id,
        float $amount,
        int $quantity = 1
    ) {
        $sql = "INSERT INTO transaction_items 
            (transaction_id, category_id, sub_category_id, amount, quantity)
            VALUES 
            (:transaction_id, :category_id, :sub_category_id, :amount, :quantity)";

        try {
            $this->db->execute($sql, [
                ':transaction_id' => $transaction_id,
                ':category_id' => $category_id,
                ':sub_category_id' => $sub_category_id,
                ':amount' => $amount,
                ':quantity' => $quantity
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("DB error (addTransactionItem): " . $e->getMessage());
            return false;
        }
    }


    /**
     * Zwrócenie wszystkich transakcji rodziny 
     */
    public function getAllTransactionsByFamily(?int $family_id)
    {
        $sql = "
        SELECT t.id AS transaction_id,
               t.user_id,
               t.category_id,
               t.type,
               t.amount,
               t.currency,
               t.payment_method,
               t.description,
               t.transaction_date,
               t.is_recurring,
               t.created_at,
               c.name AS category_name,
               u.username AS user_name
        FROM transactions t
        LEFT JOIN categories c ON t.category_id = c.id
        LEFT JOIN users u ON t.user_id = u.id
        WHERE t.family_id = :family_id
                ORDER by t.created_at desc
    ";

        return $this->db->select($sql, [
            ':family_id' => $family_id
        ]);
    }

    /**
     * Zwrócenie transakcji użytkownika
     */
    public function getAllTransactionsByUser(int $user_id)
    {
        $sql = "
        SELECT t.id AS transaction_id,
               t.user_id,
               t.category_id,
               t.type,
               t.amount,
               t.currency,
               t.payment_method,
               t.description,
               t.transaction_date,
               t.is_recurring,
               t.created_at,
               c.name AS category_name,
               u.username AS user_name
        FROM transactions t
        LEFT JOIN categories c ON t.category_id = c.id
        LEFT JOIN users u ON t.user_id = u.id
        WHERE t.user_id = :user_id
        ORDER by t.created_at asc
    ";

        return $this->db->select($sql, [
            ':user_id' => $user_id
        ]);
    }

    public function deleteTransaction(int $transaction_id)
    {
        $sql = "DELETE FROM transactions WHERE id = :id";
        return $this->db->execute($sql, ['id' => $transaction_id]);
    }

    public function deleteUserTransaction(int $transaction_id, int $user_id)
    {
        $sql = "
        DELETE FROM transactions
        WHERE id = :id AND user_id = :user_id
    ";
        return $this->db->execute($sql, [
            'id' => $transaction_id,
            'user_id' => $user_id
        ]);
    }

    public function getTransactionDetails(int $transaction_id)
    {
        $sql = "
       SELECT 
    ti.id AS item_id,
    ti.transaction_id,
    ti.amount,
    ti.quantity,
    c.name AS category_name,
    sc.name AS sub_category_name,
    c.type AS category_type,
    t.currency AS transaction_currency
    FROM transaction_items ti
    LEFT JOIN categories c 
        ON ti.category_id = c.id
    LEFT JOIN sub_categories sc 
        ON ti.sub_category_id = sc.id
    LEFT JOIN transactions t
        ON ti.transaction_id = t.id
	WHERE ti.transaction_id =:transaction_id
        ";

        return $this->db->select($sql, [
            ":transaction_id" => $transaction_id
        ]);
    }

    /**
     * Pobranie paragonu (blob) dla danej transakcji
     */
    public function getTransactionReceipt(int $transaction_id)
    {
        $sql = "
        SELECT receipt_blob
        FROM transactions
        WHERE id = :transaction_id
        LIMIT 1
    ";

        $result = $this->db->select($sql, [
            ':transaction_id' => $transaction_id
        ]);

        return $result[0]['receipt_blob'] ?? null;
    }


    /**
     * Pobranie szczegółów transakcji do edycji
     */
    public function getTransactionForEdit(int $transaction_id)
    {
        $sql = "
    SELECT 
        t.id,
        t.family_id,
        t.user_id,
        t.category_id,
        t.local_category_id,
        t.type,
        t.amount,
        t.currency,
        t.payment_method,
        t.description,
        t.transaction_date,
        t.is_recurring,
        c.name AS category_name
    FROM transactions t
    LEFT JOIN categories c ON t.category_id = c.id
    WHERE t.id = :transaction_id
    ";

        $result = $this->db->select($sql, [':transaction_id' => $transaction_id]);
        return $result[0] ?? null;
    }

    /**
     * Aktualizacja transakcji
     */
    public function updateTransaction(
        int $transaction_id,
        int $category_id,
        string $type,
        float $amount,
        string $currency,
        string $payment_method,
        string $description,
        string $transaction_date,
        int $is_recurring = 0
    ) {
        $sql = "
    UPDATE transactions 
    SET 
        category_id = :category_id,
        type = :type,
        amount = :amount,
        currency = :currency,
        payment_method = :payment_method,
        description = :description,
        transaction_date = :transaction_date,
        is_recurring = :is_recurring
    WHERE id = :transaction_id
    ";

        try {
            return $this->db->execute($sql, [
                ':category_id' => $category_id,
                ':type' => $type,
                ':amount' => $amount,
                ':currency' => $currency,
                ':payment_method' => $payment_method,
                ':description' => $description,
                ':transaction_date' => $transaction_date,
                ':is_recurring' => $is_recurring,
                ':transaction_id' => $transaction_id
            ]);
        } catch (PDOException $e) {
            error_log("DB error (updateTransaction): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Usunięcie wszystkich pozycji transakcji
     */
    public function deleteTransactionItems(int $transaction_id)
    {
        $sql = "DELETE FROM transaction_items WHERE transaction_id = :transaction_id";
        return $this->db->execute($sql, [':transaction_id' => $transaction_id]);
    }

    /**
     * Sprawdzenie czy użytkownik ma dostęp do transakcji
     */
    public function checkUserAccess(int $transaction_id, int $user_id, ?int $family_id)
    {
        $sql = "
    SELECT id 
    FROM transactions 
    WHERE id = :transaction_id 
    AND (user_id = :user_id OR family_id = :family_id)
    ";

        $result = $this->db->select($sql, [
            ':transaction_id' => $transaction_id,
            ':user_id' => $user_id,
            ':family_id' => $family_id
        ]);

        return !empty($result);
    }
}
