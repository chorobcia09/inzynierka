<?php
require_once __DIR__ . '/../config/database.php';

class Feedback
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Dodanie feedbacku.
     */
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

    /**
     * Zwrócenie wszystkich feedbackow
     */
    public function getAllFeedback(?string $status = null)
    {
        if ($status) {
            $sql = "SELECT *
            FROM feedbacks
            WHERE status = :status 
            ORDER BY created_at DESC
            ";
            return $this->db->select($sql, [
                ':status' => $status
            ]);
        } else {
            $sql = "SELECT * FROM feedbacks ORDER BY created_at DESC";
            return $this->db->select($sql);
        }
    }

    /**
     * Aktualizacja feedbacku.
     */
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
