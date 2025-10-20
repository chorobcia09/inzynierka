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
        int $is_recurring = 0
    ) {
        $sql = "
        INSERT INTO transactions (
            family_id, user_id, category_id, local_category_id,
            type, amount, currency, payment_method,
            description, transaction_date, is_recurring
        ) VALUES (
            :family_id, :user_id, :category_id, :local_category_id,
            :type, :amount, :currency, :payment_method,
            :description, :transaction_date, :is_recurring
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
}
