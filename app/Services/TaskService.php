<?php

namespace App\Services;

use App\Models\BoardColumn;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskService
{
    /**
     * List all Task { UnArchived } 
     */
    public function list()
    {
        return Task::active()
            ->with(['column', 'creator', 'assignees'])
            ->paginate(15);
    }



    /**
     * Show Task
     */
    public function show(Task $task)
    {
        return $task->load(['column', 'creator', 'assignees']);
    }



    /**
     * Creation
     */
    public function create(array $data)
    {
        $data['created_by'] = Auth::id();

        return DB::transaction(function () use ($data) {
            // 0- Determine the position
            $max_position = Task::where('column_id', $data['column_id'])->max('position');
            $data['position'] = $max_position ? $max_position + 1 : 1;

            // 1- Create Task
            $task = Task::create($data);

            // 2- Assign users
            if ($data['assignee_ids'] && !empty($data['assignee_ids'])) {
                $task->assignees()->sync($data['assignee_ids']);
            }

            // Save Activity Log
            activity()
                ->performedOn($task)
                ->causedBy($data['created_by'])
                ->log('task.created');

            return $task;
        });
    }



    /**
     * Updating
     */
    public function update(array $data, Task $task)
    {
        $data['created_by'] = Auth::id();

        return DB::transaction(function () use ($data, $task) {
            // 1- Create Task
            $task->update($data);

            // 2- Assign users
            if ($data['assignee_ids'] && !empty($data['assignee_ids'])) {
                $task->assignees()->sync($data['assignee_ids']);
            }

            // Save Activity Log
            activity()
                ->performedOn($task)
                ->causedBy($data['created_by'])
                ->log('task.updated');

            return $task;
        });
    }



    /**
     * Deleting
     */
    public function delete(Task $task)
    {
        $creator = Auth::id();

        return DB::transaction(function () use ($task, $creator) {

            $task->delete();

            activity()
                ->performedOn($task)
                ->causedBy($creator)
                ->log('task.deleted');

            return true;
        });
    }



    /**
     * Move task to another column / reorder
     */
    public function move(array $data, Task $task)
    {
        return DB::transaction(function () use ($task, $data) {
            $oldColumnId = $task->column_id;
            $oldPosition = $task->position;

            $newColumnId = $data['column_id'];
            $newPosition = $data['position'] ?? 1;
            // $newPosition = $data['position']  ??
            //     (Task::where('column_id', $newColumnId)->max('position') + 1);

            // if ($oldColumnId == $newColumnId) {
            //     // Moving **within same column**
            //     if ($newPosition < $oldPosition) {
            //         Task::where('column_id', $newColumnId)
            //             ->whereBetween('position', [$newPosition, $oldPosition - 1])
            //             ->increment('position');
            //     } elseif ($newPosition > $oldPosition) {
            //         Task::where('column_id', $newColumnId)
            //             ->whereBetween('position', [$oldPosition + 1, $newPosition])
            //             ->decrement('position');
            //     }
            // } else {
            //     // Moving **to a new column**
            //     Task::where('column_id', $newColumnId)
            //         ->where('position', '>=', $newPosition)
            //         ->increment('position');

            //     // Fix old column positions
            //     Task::where('column_id', $oldColumnId)
            //         ->where('position', '>', $oldPosition)
            //         ->decrement('position');
            // }

            if ($oldColumnId == $newColumnId) {
                // Moving **within the same column**
                if ($newPosition < $oldPosition) {
                    // Moving up: shift tasks down
                    Task::where('column_id', $newColumnId)
                        ->whereBetween('position', [$newPosition, $oldPosition - 1])
                        ->increment('position');
                } elseif ($newPosition > $oldPosition) {
                    // Moving down: shift tasks up
                    Task::where('column_id', $newColumnId)
                        ->whereBetween('position', [$oldPosition + 1, $newPosition])
                        ->decrement('position');
                }
            } else {
                // Moving **to a new column**
                $newColumnTasks = Task::where('column_id', $newColumnId)
                    ->orderBy('position')
                    ->get();

                // Shift tasks in new column after insert position
                foreach ($newColumnTasks as $i => $t) {
                    if ($i >= $newPosition - 1) {
                        $t->update(['position' => $i + 2]);
                    } else {
                        $t->update(['position' => $i + 1]);
                    }
                }

                // Fix old column positions
                Task::where('column_id', $oldColumnId)
                    ->where('position', '>', $oldPosition)
                    ->decrement('position');
            }

            // $newColumn = BoardColumn::where('id', $newColumnId)->first();
            // if ($newColumn->isWIPExceeded()) {            // Check WIP Limit
            //     throw new \Exception("Cannot move task: WIP limit reached for column '{$newColumn->name}'");
            // }

            // Update
            $task->update([
                'column_id' => $newColumnId,
                'position'  => $newPosition,
            ]);

            // Log
            activity()
                ->performedOn($task)
                ->causedBy(Auth::id())
                ->withProperties([
                    'from_column'   => $oldColumnId,
                    'to_column'     => $newColumnId,
                    'old_position'  => $oldPosition,
                    'new_position'  => $newPosition,
                ])
                ->log('task.moved');

            // return $task;
            return [
                'task' => $task,
                'column_tasks' => Task::where('column_id', $newColumnId)
                    // ->orderBy('position')
                    // ->orderBy('updated_at')
                    ->get(['id', 'position']),
            ];
        });
    }



    /**
     * Aiign users to task
     */
    public function assignUsers(Task $task, array $userIds)
    {
        return DB::transaction(function () use ($task, $userIds) {
            $oldAssignees = $task->assignees()
                ->pluck('users.id')
                ->toArray();

            // Sync IDs
            $task->assignees()->sync($userIds);

            $added = array_diff($userIds, $oldAssignees);
            $removed = array_diff($oldAssignees, $userIds);

            activity()
                ->performedOn($task)
                ->causedBy(Auth::id())
                ->withProperties([
                    'added'     => $added,
                    'removed'   => $removed,
                ])
                ->log('task.assigned');

            return $task->load('assignees');
        });
    }



    /**
     * Archive Task
     */
    public function archiveTask(Task $task, bool $archive)
    {
        return DB::transaction(function () use ($task, $archive) {
            $task->update([
                'is_archived'   => $archive,
            ]);

            activity()
                ->performedOn($task)
                ->causedBy(Auth::id())
                ->log($archive ? 'task.archived' : 'task.restored');

            return $task;
        });
    }
    // 
}
