<?php

class User
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    /**
     * Metoda zwracająca wszystkich użytkowników z bazy danych.
     * 
     */
    public function getAllUsers()
    {
        $sql = "SELECT * from users";

        return $this->db->select($sql);
    }

    /**
     * Metoda zwracająca wszystkich użytkowników po ID z bazy danych.
     */
    public function getUsersById(int $id)
    {
        $sql = "
        SELECT *
        FROM users
        WHERE id = " . $id . "
        ";

        return $this->db->select($sql);
    }

    /**
     * Metoda zwracająca wszystkich użytkowników po ID RODZINY z bazy danych.
     */
    public function getUsersByFamily(int $family_id)
    {
        $sql = "
        SELECT *
        FROM users
        WHERE family_id = " . $family_id . "
        ";

        return $this->db->select($sql);
    }
}
