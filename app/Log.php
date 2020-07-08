<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;


class Log extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action', 'user_id','changes'
    ];


}
