<?php

require_once __DIR__ . '/../config/smarty.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Feedback.php';

class FeedbackController
{
    private $smarty;
    private $feedbackModel;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
        $db = new Database();
        $this->feedbackModel = new Feedback($db);
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $type = $_POST['type'];
            $subject = trim($_POST['subject']);
            $msg = trim($_POST['message']);

            if ($user_id && $type && $subject && $msg) {
                $result = $this->feedbackModel->addFeedback($user_id, $type, $subject, $msg);

                if ($result) {
                    $message = "Feedback został pomyślnie dodany.";
                } else {
                    $message = "Wystąpił błąd podczas zapisywania feedbacku.";
                }
            } else {
                $message = "Wszystkie pola są wymagane.";
            }
        }

        $this->smarty->assign([
            'message' => $message,
            'session' => $_SESSION,
        ]);
        $this->smarty->display('add_feedback.tpl');
    }
}
