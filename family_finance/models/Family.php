<?php
require_once __DIR__ . '/../config/database.php';

class Family
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Tworzy nową rodzinę i zwraca jej ID
     */
    public function createFamily(string $family_name, string $region): int
    {
        $sql = "INSERT INTO families (family_name, region) VALUES (:family_name, :region)";
        $this->db->execute($sql, [
            ':family_name' => $family_name,
            ':region' => $region
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Pobiera rodzinę po ID
     */
    public function getFamilyById(int $id)
    {
        $sql = "SELECT * FROM families WHERE id = :id";
        return $this->db->select($sql, [':id' => $id]);
    }

    /**
     * Lista wszystkich rodzin
     */
    public function getAllFamilies()
    {
        $sql = "SELECT * FROM families";
        return $this->db->select($sql);
    }
}
