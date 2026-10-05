<?= view('partials/header', ['pageTitle' => 'Profile']) ?>

<h1>User Profile</h1>

<?php if ($user): ?>
    <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
    <p><strong>Full name:</strong> <?= esc($user['full_name']) ?></p>
    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
<?php else: ?>
    <p>No user found.</p>
<?php endif; ?>

<?= view('partials/footer') ?>
