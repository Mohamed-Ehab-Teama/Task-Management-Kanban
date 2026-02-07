<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}



    public function index(Request $request)
    {
        return response()->json(
            $tasks = $this->taskService->list()
        );
    }



    public function store(TaskRequest $request)
    {
        $task = $this->taskService->create(
            $request->validated()
        );

        return response()->json(
            $task,
            201
        );
    }



    public function show(Task $task)
    {
        return response()->json(
            $this->taskService->show($task)
        );
    }



    public function update(TaskRequest $request, Task $task)
    {
        $task = $this->taskService->update(
            $request->validated(),
            $task
        );

        return response()->json(
            $task,
            200
        );
    }



    public function destroy(Task $task)
    {
        $this->taskService->delete($task);
        return response()->json([
            'msg'   => 'Task Deleted Successfully'
        ]);
    }



    public function move(Request $request, Task $task)
    {
        $data = $request->validate([
            'column_id' => 'required|exists:columns,id',
            'position'  => 'required|integer|min:1',
        ]);

        $moveTask = $this->taskService->move(
            $data,
            $task
        );

        return response()->json($moveTask);
    }



    public function assignUsers(Request $request, Task $task)
    {
        $data = $request->validate([
            'user_ids'   => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task_new = $this->taskService->assignUsers(
            $task,
            $data['user_ids']
        );

        return response()->json($task_new);
    }



    public function archive(Request $request, Task $task)
    {
        $data = $request->validate([
            'archive'   => 'required|boolean',
        ]);

        $arcTask = $this->taskService->archiveTask(
            $task,
            $data['archive']
        );

        return response()->json([
            'msg'   => $data['archive']
                ? 'Task archived successfully'
                : 'Task restored successfully',
            'data'  => $arcTask,
        ]);
    }
}
