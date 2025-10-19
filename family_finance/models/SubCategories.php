<?php

class SubCategories
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllSubCategories() {
        $sql = "
        select *
        from sub_categories
        ";

        return $this->db->select($sql);

    }


}