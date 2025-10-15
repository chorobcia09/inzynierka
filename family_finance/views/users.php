<?php session_start(); ?>
<?php include 'header.php'; ?>

<h2 class="mb-4">Lista użytkowników</h2>

<?php if (!empty($users)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Email</th>
                    <th>Rodzina ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['family_id']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">Brak użytkowników w bazie danych.</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
