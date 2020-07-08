<?php

namespace App\Policies;

use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Task $task)
    {
        return $user->id == $task->board->owner_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Task $task)
    {
        return $user->id == $task->board()->owner_id;
    }

    public function delete(User $user, Task $task)
    {
        return $user->id == $task->board()->owner_id;
    }
}
