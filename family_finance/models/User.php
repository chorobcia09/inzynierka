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
    public function getUsersByFamily(?int $family_id)
{
    if ($family_id === null) {
        // Pobiera użytkowników bez przypisanej rodziny
        $sql = "SELECT * FROM users WHERE family_id IS NULL";
        return $this->db->select($sql);
    }

    $sql = "SELECT * FROM users WHERE family_id = :family_id";
    return $this->db->select($sql, [':family_id' => $family_id]);
}


    /**
     * Metoda zwracająca wszystkich użytkowników po adresie email z bazy danych.
     */
    public function getUserByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $this->db->select($sql, [$email]);
        return $result[0] ?? null;
    }

    public function getUserById($id)
    {
        $sql = "
        SELECT *
        FROM users
        WHERE id = " . $id . "
        ";

        return $this->db->select($sql);
    }

    public function createUser(string $username, string $email, string $password, ?int $family_id = null)
    {
        $sql = "INSERT INTO users (username, email, password, family_id)
            VALUES (:username, :email, :password, :family_id)";

        return $this->db->execute($sql, [
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':family_id' => $family_id
        ]);
    }

}
