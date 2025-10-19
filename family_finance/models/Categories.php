<?php

class Categories
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllCategories() {
        $sql = "
        select *
        from categories
        ";

        return $this->db->select($sql);

    }


}