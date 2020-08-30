<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'board_id', 'status_id'];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
