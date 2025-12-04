<?php

class User
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
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

    /**
     * Metoda zwracająca użytkownika po ID.
     */
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $result = $this->db->select($sql, [':id' => $id]);
        return $result[0] ?? null; // Zwróć pierwszy element lub null
    }

    /**
     * Metoda dodająca użytkownika do bazy danych.
     */
    public function createUser(string $username, string $email, string $password, string $role, ?int $family_id = null, string $UID)
    {
        // sprawdzenie czy email jest w bazie 
        if ($this->emailExists($email)) {
            throw new Exception("Podany email już istnieje w systemie!");
        }
        // sprawdzenie czy username jest w bazie
        if ($this->usernameExists($username)) {
            throw new Exception("Podana nazwa użytkownika już istnieje w systemie!");
        }

        $sql = "INSERT INTO users (username, email, password, role, family_id, UID) 
            VALUES (:username, :email, :password, :role, :family_id, :UID)";

        return $this->db->execute($sql, [
            ':username' => $username,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role' => $role,
            ':family_id' => $family_id,
            ':UID' => $UID
        ]);
    }


    /**
     * Metoda aktualizująca dane użytkownika poprzez panel administratora
     */
    public function updateUser(int $id, string $username, string $email, string $role, $family_id = null, ?string $password = null)
    {
        $currentUser = $this->getUserById($id);
        if (!$currentUser) {
            throw new Exception("Użytkownik nie istnieje!");
        }

        if ($email !== $currentUser['email'] && $this->emailExists($email)) {
            throw new Exception("Podany email już istnieje w systemie!");
        }

        if ($username !== $currentUser['username'] && $this->usernameExists($username)) {
            throw new Exception("Podana nazwa użytkownika już istnieje w systemie!");
        }

        $family_id = $this->parseFamilyId($family_id);

        // buduje sql w zaleznosci czy podano nowe haslo
        if ($password) {
            $sql = "
            UPDATE users
            SET username = :username,
                email = :email,
                password = :password,
                role = :role,
                family_id = :family_id
            WHERE id = :id
        ";
            $params = [
                ':username' => $username,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':role' => $role,
                ':family_id' => $family_id,
                ':id' => $id
            ];
        } else {
            $sql = "
            UPDATE users
            SET username = :username,
                email = :email,
                role = :role,
                family_id = :family_id
            WHERE id = :id
        ";
            $params = [
                ':username' => $username,
                ':email' => $email,
                ':role' => $role,
                ':family_id' => $family_id,
                ':id' => $id
            ];
        }

        return $this->db->execute($sql, $params);
    }

    /**
     * Metoda pomocnicza do konwersji family_id
     */
    private function parseFamilyId($family_id)
    {
        if ($family_id === null || $family_id === '') {
            return null;
        }

        if (is_numeric($family_id)) {
            return (int)$family_id;
        }

        return null;
    }

    /**
     * Metoda do usuwania użytkownika 
     */
    public function deleteUser(int $id)
    {
        try {
            // Rozpoczęcie transakcji
            $this->db->beginTransaction();

            // 1. Usuń powiązane transakcje
            $sql = "DELETE FROM transactions WHERE user_id = :id";
            $this->db->execute($sql, [':id' => $id]);

            // 2. Usuń powiązane opinie (feedback)
            $sql = "DELETE FROM feedbacks WHERE user_id = :id";
            $this->db->execute($sql, [':id' => $id]);

            // 3. Usuń powiązane budżety
            $sql = "DELETE FROM budgets WHERE user_id = :id";
            $this->db->execute($sql, [':id' => $id]);

            // 4. Usuń użytkownika
            $sql = "DELETE FROM users WHERE id = :id";
            $this->db->execute($sql, [':id' => $id]);

            // Zatwierdzenie transakcji
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Wycofanie zmian w przypadku błędu
            $this->db->rollBack();
            error_log("Błąd usuwania użytkownika: " . $e->getMessage());
            return false;
        }
    }


    /**
     * Metoda sprawdzająca czy email istnieje w bazie danych.
     */
    public function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        $result = $this->db->select($sql, [':email' => $email]);
        return !empty($result) && $result[0]['count'] > 0;
    }

    /**
     * Metoda sprawdzająca czy użytkownik o konkretnym username istnieje w bazie danych.
     */
    public function usernameExists(string $username): bool
    {
        $sql = "SELECT id FROM users WHERE username = :username LIMIT 1";
        $result = $this->db->select($sql, [':username' => $username]);
        return !empty($result);
    }

    /**
     * Zwrócenie wszystkich użytkowników wraz z informacją o rodzinie.
     */
    public function getAllUsersWithFamily()
    {
        $sql = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.account_type,
            u.role,
            u.family_id,
            f.family_name,
            u.family_role
        FROM users u
        LEFT JOIN families f ON u.family_id = f.id
    ";
        return $this->db->select($sql);
    }

    /**
     * Zwrócenie wszystkich użytkowników należących do rodziny po ID.
     */
    public function getUsersByFamilyId(?int $family_id)
    {
        if ($family_id === null) {
            return [];
        }
        $sql = "
        SELECT u.*, f.family_name
        FROM users u
        LEFT JOIN families f ON u.family_id = f.id
    ";

        $params = [];
        if ($family_id !== null) {
            $sql .= " WHERE u.family_id = :family_id";
            $params[':family_id'] = $family_id;
        }

        return $this->db->select($sql, $params);
    }

    /**
     * Metoda zwracająca informacje dotyczące rodziny i użytkownika poprzez ID użytkownika
     */
    public function getInfoAboutFamiliesWithUserByUserId(int $id)
    {
        $sql = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.role,
            u.account_type,
            u.UID,
            u.family_id,
            f.family_name,
            u.family_role
        FROM users u
        LEFT JOIN families f ON u.family_id = f.id
        WHERE u.id = :id
    ";
        return $this->db->select($sql, [
            ':id' => $id
        ]);
    }

    /**
     * Aktualizacja hasła.
     */
    public function updatePassword($id, $hashedPassword)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        return $this->db->execute($sql, [
            ':password' => $hashedPassword,
            ':id' => $id
        ]);
    }
    /**
     * Przejscie na uzytkownika premium
     */
    public function upgradeToPremium(int $userId)
    {
        $sql = "UPDATE users SET account_type = 'premium' WHERE id = :id";
        return $this->db->execute($sql, [':id' => $userId]);
    }
}
