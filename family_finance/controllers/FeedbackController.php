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

    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $feedback = $this->feedbackModel->getAllFeedback();
        $this->smarty->assign([
            'feedback' => $feedback,
            'session' => $_SESSION
        ]);

        $this->smarty->display('feedback_panel.tpl');
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

    public function changeStatus()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feedback_id = (int)$_POST['feedback_id'];
            $status = $_POST['status'];
            if (in_array($status, ['new', 'in_progress', 'resolved'])) {
                $result = $this->feedbackModel->updateStatus($feedback_id, $status);

                if ($result) {
                    $message = "Pomyślnie zmieniono status.";
                } else {
                    $message = "Wystąpił błąd podczas zmiany statusu.";
                }
            } else {
                $message = "Nieprawidlowy status.";
            }
        }

        $feedback = $this->feedbackModel->getAllFeedback();
        $this->smarty->assign([
            'message' => $message,
            'feedback' => $feedback,
            'session' => $_SESSION,
        ]);
        $this->smarty->display('feedback_panel.tpl');
    }
}
