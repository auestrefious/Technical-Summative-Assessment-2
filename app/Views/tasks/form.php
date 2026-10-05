<?php
$editing = $task !== null;
$errors = session()->getFlashdata('errors') ?? [];
$selectedStatus = old('status', $task['status'] ?? 'pending', false);
?>
<?= view('partials/header', ['pageTitle' => $editing ? 'Edit Task' : 'New Task']) ?>

<h1><?= $editing ? 'Edit Task' : 'New Task' ?></h1>

<form action="<?= site_url($action) ?>" method="post" class="form-card">
    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input id="title" name="title" type="text" maxlength="150" required
           value="<?= esc(old('title', $task['title'] ?? '', false), 'attr') ?>">
    <?php if (isset($errors['title'])): ?>
        <p class="field-error" role="alert"><?= esc($errors['title']) ?></p>
    <?php endif; ?>

    <label for="task_date">Task date</label>
    <input id="task_date" name="task_date" type="date" required
           value="<?= esc(old('task_date', $task['task_date'] ?? '', false), 'attr') ?>">
    <?php if (isset($errors['task_date'])): ?>
        <p class="field-error" role="alert"><?= esc($errors['task_date']) ?></p>
    <?php endif; ?>

    <label for="status">Status</label>
    <select id="status" name="status" required>
        <option value="pending" <?= $selectedStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="completed" <?= $selectedStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
    </select>
    <?php if (isset($errors['status'])): ?>
        <p class="field-error" role="alert"><?= esc($errors['status']) ?></p>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="button"><?= $editing ? 'Save changes' : 'Create task' ?></button>
        <a href="<?= site_url('tasks') ?>" class="button button-secondary">Cancel</a>
    </div>
</form>

<?= view('partials/footer') ?>
