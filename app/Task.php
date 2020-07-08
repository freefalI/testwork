<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    protected $fillable = ['title', 'board_id', 'status_id'];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function labels()
    {
        return $this->belongsToMany('App\Label');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // ... code here
        });

        self::created(function ($model) {
            Log::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'created',
                    'changes' => json_encode($model->toArray())
                ]
            );
        });

        self::updating(function ($model) {
            $modelOld = Task::find($model->id);
            Log::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'updated',
                    'changes' => json_encode([
                        'before' => $modelOld->toArray(),
                        'after' => $model->toArray()
                    ])
                ]
            );
        });

        self::updated(function ($model) {

        });

        self::deleting(function ($model) {
            // ... code here
        });

        self::deleted(function ($model) {
            Log::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'deleted',
                    'changes' => json_encode($model->toArray())
                ]
            );
        });
    }
}
