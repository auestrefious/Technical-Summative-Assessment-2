<?= view('partials/header', ['pageTitle' => 'All Tasks']) ?>

<h1>All Tasks</h1>

<?php if (empty($tasks)): ?>
    <p>No active tasks found.</p>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Task</th>
                    <th scope="col">Status</th>
                    <?php if (session()->get('user_id') !== null): ?>
                        <th scope="col">Manage</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= esc($task['task_date']) ?></td>
                        <td><?= esc($task['title']) ?></td>
                        <td><?= esc($task['status']) ?></td>
                        <?php if (session()->get('user_id') !== null): ?>
                            <td class="actions">
                                <a class="button" href="<?= site_url('tasks/' . $task['id'] . '/edit') ?>">Edit</a>
                                <form action="<?= site_url('tasks/' . $task['id'] . '/archive') ?>"
                                      method="post" onsubmit="return confirm('Archive this task?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="button button-danger">Archive</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= view('partials/footer') ?>
