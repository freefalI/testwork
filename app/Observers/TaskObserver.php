<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'created',
                'changes' => json_encode($task->toArray())
            ]
        );
    }

    /**
     * Handle the task "updating" event.
     *
     * @param  Task  $task
     * @return void
     */
    public function updating(Task $task)
    {
        $modelOld = Task::find($task->id);
            Log::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'updated',
                    'changes' => json_encode([
                        'before' => $modelOld->toArray(),
                        'after' => $task->toArray()
                    ])
                ]
            );
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'deleted',
                'changes' => json_encode($task->toArray())
            ]
        );
    }

}
