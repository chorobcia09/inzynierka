<?php

class Budgets
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Dodaje nowy budżet z kategoriami */
    public function addBudget($family_id, $user_id, $name, $period_type, $start_date, $end_date, $items = [], $total_limit, $currency)
    {
        try {
            $this->db->execute("START TRANSACTION");

            $sqlBudget = "
                INSERT INTO budgets (family_id, user_id, name, period_type, start_date, end_date, total_limit, currency)
                VALUES (:family_id, :user_id, :name, :period_type, :start_date, :end_date, :total_limit, :currency)
            ";

            $this->db->execute($sqlBudget, [
                ':family_id'   => $family_id ?: null,
                ':user_id'     => $user_id ?: null,
                ':name'        => $name,
                ':period_type' => $period_type,
                ':start_date'  => $start_date,
                ':end_date'    => $end_date,
                ':total_limit' => $total_limit,
                ':currency'    => $currency
            ]);

            $budget_id = $this->db->pdo->lastInsertId();

            if (!empty($items)) {
                foreach ($items as $item) {
                    $sqlItem = "INSERT INTO budget_items (budget_id, category_id, limit_amount)
                        VALUES (:budget_id, :category_id, :limit_amount)";
                    $this->db->execute($sqlItem, [
                        ':budget_id' => $budget_id,
                        ':category_id' => $item['category_id'],
                        ':limit_amount' => $item['limit_amount']
                    ]);
                }
            }

            $this->db->execute("COMMIT");
            return $budget_id;
        } catch (Exception $e) {
            $this->db->execute("ROLLBACK");
            error_log("Błąd dodawania budżetu: " . $e->getMessage());
            return false;
        }
    }

    /** Pobiera listę budżetów użytkownika/rodziny */
    public function getBudgets($family_id, $user_id)
    {
        $sql = "
        SELECT 
            b.id,
            b.name,
            b.start_date,
            b.end_date,
            b.period_type,
            b.currency,
            (SELECT SUM(bi.limit_amount)
            FROM budget_items bi
            WHERE bi.budget_id = b.id) AS total_limit,
            COALESCE((
                SELECT SUM(ti.amount * ti.quantity)
                FROM transactions t
                JOIN transaction_items ti ON ti.transaction_id = t.id
                WHERE 
                    (t.family_id = b.family_id OR t.user_id = b.user_id)
                    AND t.transaction_date BETWEEN b.start_date AND b.end_date
                    AND ti.category_id IN (
                        SELECT bi.category_id FROM budget_items bi WHERE bi.budget_id = b.id
                    )
            ), 0) AS total_spent
        FROM budgets b
        WHERE (b.family_id = :family_id OR b.user_id = :user_id)
        ORDER BY b.start_date DESC
        ";

        $budgets = $this->db->select($sql, [
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ]);

        foreach ($budgets as &$b) {
            $b['used_percent'] = $b['total_limit'] > 0
                ? round(($b['total_spent'] / $b['total_limit']) * 100, 2)
                : 0;
        }

        return $budgets;
    }

    /** Pobiera szczegóły budżetu z kategoriami */
    public function getBudgetDetails($budget_id, $family_id, $user_id)
    {
        $sql = "
        SELECT 
            b.id AS budget_id,
            b.name,
            b.start_date,
            b.end_date,
            b.period_type,
            b.currency,
            b.total_limit,
            c.id AS category_id,
            c.name AS category_name,
            bi.limit_amount,
            COALESCE(SUM(ti.amount * ti.quantity), 0) AS spent_amount,
            ROUND(
                (COALESCE(SUM(ti.amount * ti.quantity), 0) / NULLIF(bi.limit_amount, 0)) * 100,
                2
            ) AS used_percent
        FROM budgets b
        JOIN budget_items bi ON bi.budget_id = b.id
        JOIN categories c ON c.id = bi.category_id
        LEFT JOIN transactions t 
            ON (t.family_id = b.family_id OR t.user_id = b.user_id)
            AND t.transaction_date BETWEEN b.start_date AND b.end_date
        LEFT JOIN transaction_items ti 
            ON ti.transaction_id = t.id
            AND ti.category_id = bi.category_id
        WHERE b.id = :budget_id
        AND (b.family_id = :family_id OR b.user_id = :user_id)
        GROUP BY b.id, c.id, bi.limit_amount
        ORDER BY used_percent DESC
        ";

        return $this->db->select($sql, [
            ':budget_id' => $budget_id,
            ':family_id' => $family_id,
            ':user_id' => $user_id
        ]);
    }

    /** Aktualizuje budżet i kategorie */
    public function updateBudget($budget_id, $family_id, $user_id, $name, $period_type, $start_date, $end_date, $items, $total_limit, $currency)
    {
        try {
            $this->db->execute("START TRANSACTION");

            $sqlUpdate = "
            UPDATE budgets
            SET name = :name,
                period_type = :period_type,
                start_date = :start_date,
                end_date = :end_date,
                total_limit = :total_limit,
                currency = :currency
            WHERE id = :budget_id
              AND (family_id = :family_id OR user_id = :user_id)
            ";

            $this->db->execute($sqlUpdate, [
                ':name' => $name,
                ':period_type' => $period_type,
                ':start_date' => $start_date,
                ':end_date' => $end_date,
                ':total_limit' => $total_limit,
                ':currency' => $currency,
                ':budget_id' => $budget_id,
                ':family_id' => $family_id,
                ':user_id' => $user_id
            ]);

            $this->db->execute("DELETE FROM budget_items WHERE budget_id = :budget_id", [':budget_id' => $budget_id]);

            foreach ($items as $item) {
                $sqlItem = "INSERT INTO budget_items (budget_id, category_id, limit_amount)
                        VALUES (:budget_id, :category_id, :limit_amount)";
                $this->db->execute($sqlItem, [
                    ':budget_id' => $budget_id,
                    ':category_id' => $item['category_id'],
                    ':limit_amount' => $item['limit_amount']
                ]);
            }

            $this->db->execute("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db->execute("ROLLBACK");
            error_log("Błąd aktualizacji budżetu: " . $e->getMessage());
            return false;
        }
    }

    /** Usuwa budżet i powiązane kategorie */
    public function deleteBudget($budget_id, $family_id, $user_id)
    {
        try {
            $this->db->execute("START TRANSACTION");

            $this->db->execute("DELETE FROM budget_items WHERE budget_id = :budget_id", [
                ':budget_id' => $budget_id
            ]);

            $this->db->execute("
                DELETE FROM budgets
                WHERE id = :budget_id
                AND (family_id = :family_id OR user_id = :user_id)
            ", [
                ':budget_id' => $budget_id,
                ':family_id' => $family_id,
                ':user_id' => $user_id
            ]);

            $this->db->execute("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db->execute("ROLLBACK");
            error_log("Błąd usuwania budżetu: " . $e->getMessage());
            return false;
        }
    }
}
