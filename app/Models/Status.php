<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use Translatable;

    protected $fillable = ['title'];
    public $translatedAttributes = ['title'];
}
