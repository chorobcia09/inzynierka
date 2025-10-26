<?php

class SubCategories
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllGlobalSubCategories()
    {
        $sql = "select *
        from sub_categories
        where is_global = 1
        ";

        return $this->db->select($sql);
    }

    public function getAllSubCategories(int $category_id, int $user_id, int $family_id)
    {
        $sql = "
        select *
        from sub_categories
        where category_id = :category_id
        and (is_global = 1 or user_id = :user_id or family_id = :family_id)
        ";

        return $this->db->select($sql, [
            ':category_id' => $category_id,
            ':user_id' => $user_id,
            ':family_id' => $family_id
        ]);
    }

    public function addSubCategory(int $user_id, $family_id, int $category_id, string $name, int $is_global = 0)
    {
        $sql = "
        INSERT INTO sub_categories (user_id, family_id, category_id, name, is_global)
        VALUES (:user_id, :family_id,:category_id, :name, :is_global)
        ";

        return $this->db->execute($sql, [
            ':user_id' => $user_id,
            ':family_id' => $family_id,
            ':category_id' => $category_id,
            ':name' => $name,
            ':is_global' => $is_global
        ]);
    }
}
