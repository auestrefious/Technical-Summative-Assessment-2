<?= view('partials/header', ['pageTitle' => "Today's Tasks"]) ?>

<h1>Today's Tasks</h1>

<?php if (empty($tasks)): ?>
    <p>No tasks scheduled for today.</p>
<?php else: ?>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li><?= esc($task['title']) ?> — <?= esc($task['status']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?= view('partials/footer') ?>
