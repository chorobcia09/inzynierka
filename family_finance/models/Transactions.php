<?php
require_once __DIR__ . '/../config/database.php';

class Transactions
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

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

    public function addTransactionItem(int $transaction_id, int $category_id, string $name, float $amount, int $quantity = 1)
    {
        $sql = "INSERT INTO transaction_items (transaction_id, category_id, name, amount, quantity)
            VALUES (:transaction_id, :category_id, :name, :amount, :quantity)";
        try {
            $this->db->execute($sql, [
                ':transaction_id' => $transaction_id,
                ':category_id' => $category_id,
                ':name' => $name,
                ':amount' => $amount,
                ':quantity' => $quantity
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("DB error (addTransactionItem): " . $e->getMessage());
            return false;
        }
    }
}
