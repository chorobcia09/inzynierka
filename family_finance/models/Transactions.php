<?php
require_once __DIR__ . '/../config/database.php';

class Transactions
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }



}