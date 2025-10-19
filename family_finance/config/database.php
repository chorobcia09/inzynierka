<?php

/**
 * Klasa odpowiedzialna za zarządzanie połączeniem z bazą danych
 * za pomocą PDO. Implementuje wzorzec Singleton, aby zapewnić
 * tylko jedną instancję połączenia w całej aplikacji.
 */

class Database
{
    private $host = 'localhost';
    private $db   = 'family_finance_database';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';
    public $pdo;

    public function __construct()
    {
        date_default_timezone_set('Europe/Warsaw');
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

        // Opcje PDO
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            echo "Błąd połączenia: " . $e->getMessage();
        }
    }

    /**
     * Wykonuje zapytanie SELECT w bazie danych i zwraca wszystkie wyniki.
     */
    public function select($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Wykonuje dowolne zapytanie SQL (INSERT, UPDATE, DELETE lub inne) w bazie danych.
     */
    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /** 
     * Zwrócenie ostatniego dodanego id z bazy danych 
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
