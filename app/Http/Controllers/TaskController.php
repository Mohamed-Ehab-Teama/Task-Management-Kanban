<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}


    /**
     * Create New Task
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();

        $this->taskService->create(
            $data
        );
    }
}
