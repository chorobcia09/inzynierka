<?php

class Categories
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Pobiera wszystkie kategorie */
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        return $this->db->select($sql);
    }

    /** Pobiera kategorię po ID */
    public function getAllCategoriesById(int $id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        return $this->db->select($sql, [':id' => $id]);
    }

    /** Pobiera podkategorie dla kategorii */
    public function getAllSubCategoriesByCategory(int $id)
    {
        $sql = "SELECT * FROM sub_categories WHERE category_id = :id";
        return $this->db->select($sql, [':id' => $id]);
    }

    /** Pobiera nazwę podkategorii po ID */
    public function getSubcategoryNameById(int $id): string
    {
        $sql = "SELECT name FROM sub_categories WHERE id = :id";
        $result = $this->db->select($sql, [':id' => $id]);
        return $result[0]['name'] ?? '';
    }

    /** Pobiera kategorie według typu */
    public function getCategoriesByType(string $type)
    {
        $sql = "SELECT * FROM categories WHERE type = :type";
        // dump($sql);
        return $this->db->select($sql, [':type' => $type]);
    }
}
