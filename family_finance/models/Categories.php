<?php

class Categories
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllCategories()
    {
        $sql = "
        select *
        from categories
        ";

        return $this->db->select($sql);
    }

    public function getSubcategoryNameById(int $id): string
    {
        $sql = "SELECT name FROM sub_categories WHERE id = :id";
        $result = $this->db->select($sql, [':id' => $id]);
        return $result[0]['name'] ?? '';
    }
}
