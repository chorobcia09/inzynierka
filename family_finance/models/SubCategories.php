<?php

class SubCategories
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Pobiera globalne podkategorie */
    public function getAllGlobalSubCategories()
    {
        $sql = "SELECT * FROM sub_categories WHERE is_global = 1";
        return $this->db->select($sql);
    }

    /** Pobiera podkategorie z uwzględnieniem użytkownika i rodziny */
    public function getAllSubCategories(int $category_id, int $user_id, ?int $family_id)
    {
        $sql = "
        SELECT *
        FROM sub_categories
        WHERE category_id = :category_id
        AND (is_global = 1 OR user_id = :user_id OR family_id = :family_id)
        ";

        return $this->db->select($sql, [
            ':category_id' => $category_id,
            ':user_id' => $user_id,
            ':family_id' => $family_id
        ]);
    }

    /** Dodaje nową podkategorię */
    public function addSubCategory(int $user_id, $family_id, int $category_id, string $name, int $is_global = 0)
    {
        $sql = "
        INSERT INTO sub_categories (user_id, family_id, category_id, name, is_global)
        VALUES (:user_id, :family_id, :category_id, :name, :is_global)
        ";

        return $this->db->execute($sql, [
            ':user_id' => $user_id,
            ':family_id' => $family_id,
            ':category_id' => $category_id,
            ':name' => $name,
            ':is_global' => $is_global
        ]);
    }

    /** Pobiera podkategorie dla kategorii */
    public function getSubCategoriesByCategory($category_id)
    {
        $sql = "SELECT * FROM sub_categories WHERE category_id = :category_id";
        return $this->db->select($sql, [':category_id' => $category_id]);
    }

    public function deleteSubCategory(int $sub_category_id, int $user_id, ?int $family_id = null, bool $isFamilyAdmin = false)
    {
        // Pobranie podkategorii
        $sql = "SELECT * FROM sub_categories WHERE id = :id";
        $subcategory = $this->db->select($sql, [':id' => $sub_category_id]);

        if (empty($subcategory)) {
            return ['success' => false, 'message' => 'Podkategoria nie istnieje.'];
        }

        $subcategory = $subcategory[0];

        // Sprawdzenie uprawnień
        if (
            !($isFamilyAdmin && $subcategory['family_id'] == $family_id) &&
            !($subcategory['user_id'] == $user_id)
        ) {
            return ['success' => false, 'message' => 'Brak uprawnień do usunięcia podkategorii.'];
        }

        // Sprawdzenie, czy podkategoria jest powiązana z transakcjami
        $sqlCheck = "SELECT COUNT(*) as cnt FROM transaction_items WHERE sub_category_id = :id";
        $result = $this->db->select($sqlCheck, [':id' => $sub_category_id]);

        if ($result[0]['cnt'] > 0) {
            // Usuń powiązane transaction_items
            $sqlDeleteItems = "DELETE FROM transaction_items WHERE sub_category_id = :id";
            $this->db->execute($sqlDeleteItems, [':id' => $sub_category_id]);

            // Tutaj możesz też usunąć całe transakcje, jeśli chcesz
            // np. jeśli transaction_items jest jedynym elementem transakcji
            // albo zależnie od logiki biznesowej
            $message = "Podkategoria i powiązane transakcje zostały usunięte.";
        } else {
            $message = "Podkategoria została usunięta.";
        }

        // Usuń podkategorię
        $sqlDelete = "DELETE FROM sub_categories WHERE id = :id";
        $this->db->execute($sqlDelete, [':id' => $sub_category_id]);

        return ['success' => true, 'message' => $message];
    }

    public function getTransactionCount(int $sub_category_id): int
    {
        $sql = "SELECT COUNT(*) as cnt FROM transaction_items WHERE sub_category_id = :id";
        $result = $this->db->select($sql, [':id' => $sub_category_id]);
        return $result[0]['cnt'] ?? 0;
    }
}
