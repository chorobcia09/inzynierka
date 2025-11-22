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
}
