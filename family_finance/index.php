<?php
require_once "./config/database.php";
require_once "./models/User.php";

// Tworzymy obiekt bazy danych
$database = new Database();

// Tworzymy model użytkownika
$userModel = new User($database);

// Pobieramy wszystkich użytkowników
$allUsers = $userModel->getAllUsers();
$usersById = $userModel->getUsersById(2);
$usersByFamilyId = $userModel->getUsersByFamily(2);
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie finansami rodzinnymi</title>
</head>
<body>
    <h1>Lista użytkowników</h1>

    <?php if (!empty($usersById)): ?>
        <ul>
        <?php foreach ($usersById as $user): ?>
            <li>
                <?php 
                    // Zakładam, że tabela users ma kolumny: id, name, email
                    echo "ID: " . htmlspecialchars($user['id']) . " | ";
                    echo "Imię: " . htmlspecialchars($user['username']) . " | ";
                    echo "RodzinaID: " . htmlspecialchars($user['family_id']) . " | ";
                    echo "Email: " . htmlspecialchars($user['email']); 
                ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Brak użytkowników w bazie danych.</p>
    <?php endif; ?>
</body>
</html>
