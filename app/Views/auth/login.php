<?= view('partials/header', ['pageTitle' => 'Log in']) ?>

<h1>Log in</h1>

<?php if (session()->getFlashdata('error')): ?>
    <p class="notice notice-error" role="alert"><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>

<form action="<?= site_url('login') ?>" method="post" class="form-card">
    <?= csrf_field() ?>
    <label for="username">Username</label>
    <input id="username" name="username" type="text" autocomplete="username" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" autocomplete="current-password" required>

    <button type="submit" class="button">Log in</button>
</form>

<?= view('partials/footer') ?>
