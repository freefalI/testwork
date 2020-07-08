<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageAttachment extends Model
{
    protected $fillable = ['task_id', 'image', 'thumb_mobile', 'thumb_desktop', 'user_id'];
}
