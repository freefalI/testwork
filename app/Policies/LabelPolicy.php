<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy
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
        return true;

    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Task $task)
    {
        return true;
    }

    public function delete(User $user, Task $task)
    {
        return true;
    }

}
