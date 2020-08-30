<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function view(User $user, Board $board)
    {
        return $user->id == $board->owner_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Board $board)
    {
        return $user->id == $board->owner_id;
    }

    public function delete(User $user, Board $board)
    {
        return $user->id == $board->owner_id;
    }

    public function viewTasks(User $user, Board $board)
    {
        return $user->id == $board->owner_id;
    }

}
