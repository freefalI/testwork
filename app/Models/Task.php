<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'board_id', 'status_id'];
    protected $casts = [
        'board_id' => 'int',
        'status_id' => 'int'
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
