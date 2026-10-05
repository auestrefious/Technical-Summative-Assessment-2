<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <title><?= esc($pageTitle ?? 'Tasks for Today') ?></title>
</head>
<body>
    <nav aria-label="Main navigation">
        <a href="<?= site_url() ?>">Welcome</a>
        <a href="<?= site_url('tasks') ?>">All Tasks</a>
        <a href="<?= site_url('profile') ?>">Profile</a>
        <a href="<?= site_url('about') ?>">About</a>
        <?php if (session()->get('user_id') !== null): ?>
            <a href="<?= site_url('tasks/new') ?>">New Task</a>
            <form action="<?= site_url('logout') ?>" method="post" class="nav-form">
                <?= csrf_field() ?>
                <button type="submit" class="nav-button">Log out</button>
            </form>
        <?php else: ?>
            <a href="<?= site_url('login') ?>">Log in</a>
        <?php endif; ?>
    </nav>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="notice" role="status"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>
