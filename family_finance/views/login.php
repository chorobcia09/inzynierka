<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>

<body>
    <h1>Logowanie</h1>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>

    <?php endif; ?>

    <form action="index.php?action=login" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Zaloguj się</button>
    </form>
</body>

</html>