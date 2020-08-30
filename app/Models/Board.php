<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
