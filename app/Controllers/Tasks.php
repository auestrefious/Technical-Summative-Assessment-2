<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use DateTimeImmutable;
use DateTimeZone;

class Tasks extends BaseController
{
    private const RULES = [
        'title' => 'required|max_length[150]',
        'task_date' => 'required|valid_date[Y-m-d]',
        'status' => 'required|in_list[pending,completed]',
    ];

    public function new()
    {
        return view('tasks/form', ['task' => null, 'action' => 'tasks']);
    }

    public function create()
    {
        $data = $this->taskData();

        if (! $this->validateData($data, self::RULES)) {
            return redirect()->to(site_url('tasks/new'))
                ->withInput()->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = (new DateTimeImmutable('now', new DateTimeZone('Asia/Manila')))
            ->format('Y-m-d H:i:s');

        (new TaskModel())->insert($data);

        return redirect()->to(site_url('tasks'))->with('success', 'Task created.');
    }

    public function edit(int $id)
    {
        return view('tasks/form', [
            'task' => $this->activeTask($id),
            'action' => "tasks/{$id}/update",
        ]);
    }

    public function update(int $id)
    {
        $this->activeTask($id);
        $data = $this->taskData();

        if (! $this->validateData($data, self::RULES)) {
            return redirect()->to(site_url("tasks/{$id}/edit"))
                ->withInput()->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->update($id, $data);

        return redirect()->to(site_url('tasks'))->with('success', 'Task updated.');
    }

    public function archive(int $id)
    {
        $this->activeTask($id);

        (new TaskModel())->update($id, ['is_archived' => 1]);

        return redirect()->to(site_url('tasks'))->with('success', 'Task archived.');
    }

    private function activeTask(int $id): array
    {
        $task = (new TaskModel())->find($id);

        if ($task === null || (int) $task['is_archived'] !== 0) {
            throw PageNotFoundException::forPageNotFound('Task not found.');
        }

        return $task;
    }

    private function taskData(): array
    {
        $title = $this->request->getPost('title');
        $taskDate = $this->request->getPost('task_date');
        $status = $this->request->getPost('status');

        return [
            'title' => is_string($title) ? trim($title) : '',
            'task_date' => is_string($taskDate) ? trim($taskDate) : '',
            'status' => is_string($status) ? $status : '',
        ];
    }
}
