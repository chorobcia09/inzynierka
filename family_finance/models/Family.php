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

    /**
     * Aktualizacja rodziny i roli w rodzinie poprzez ID uzytkownika
     */
    public function updateUserFamilyAndRole(int $userId, int $familyId, string $role)
    {
        $sql = "UPDATE users SET family_id = :family_id, family_role = :role WHERE id = :id";
        return $this->db->execute($sql, [
            ':family_id' => $familyId,
            ':role' => $role,
            ':id' => $userId
        ]);
    }

    /**
     * Metoda sprawdzająca czy użytkownik o podanym UID istenieje i czy jest w rodzinie - POMOCNICZA
     */
    public function findUser(string $UID)
    {
        $sql = "
        select COUNT(*) as count 
        from users where UID = :UID AND (family_id IS NULL)
        ";
        $result = $this->db->select($sql, [
            ':UID' => $UID
        ]);
        return !empty($result) && $result[0]['count'] > 0;
    }

    public function addUserToFamily(int $family_id, string $UID)
    {
        $findUser = $this->findUser($UID);

        if (!$findUser) {
            throw new Exception("Użytkownik o podanym UID nie istnieje lub już należy do rodziny!");
        }

        $sql = "
        UPDATE users
        SET family_id = :family_id,
            family_role = 'family_member'
        WHERE id = (SELECT id from users WHERE UID = :UID)
        ";

        return $this->db->execute($sql, [
            ':family_id' => $family_id,
            ':UID' => $UID
        ]);
    }

    public function deleteUserFromFamily(int $id)
    {
        $sql = "
        UPDATE users
        SET family_id = NULL,
            family_role = NULL
        WHERE id = :id
        ";

        return $this->db->execute($sql, [
            ':id' => $id
        ]);
    }

    public function deleteFamily(int $id)
    {
        // najpierw ustawia uzytkownikom nulla
        $this->db->execute("
        UPDATE users
        SET family_id = NULL, family_role = NULL
        WHERE family_id = :id
    ", [':id' => $id]);

        // pozniej usuwa
        $sql = "DELETE FROM families WHERE id = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }
}
