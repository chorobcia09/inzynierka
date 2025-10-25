<?php
require_once __DIR__ . '/../config/database.php';

class Feedback
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addFeedback(int $user_id, string $type, string $subject, string $message, string $status = 'new')
    {
        $sql = "INSERT INTO feedbacks (user_id, type, subject, message, status)
        VALUES (:user_id, :type, :subject, :message, :status)";

        return $this->db->execute($sql, [
            ':user_id' => $user_id,
            ':type' => $type,
            ':subject' => $subject,
            ':message' => $message,
            ':status' => $status
        ]);
    }

    public function getAllFeedback()
    {
        $sql = "SELECT * 
        FROM feedbacks
        ORDER BY created_at desc
        ";

        return $this->db->select($sql);
    }

    public function updateStatus(int $feedback_id, string $status)
    {
        $sql = "UPDATE feedbacks 
        SET status = :status 
        WHERE id = :id";

        return $this->db->execute($sql, [
            ':status' => $status,
            ':id' => $feedback_id
        ]);
    }
}
