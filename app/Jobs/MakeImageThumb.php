<?php

namespace App\Jobs;

use App\ImageAttachment;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class MakeImageThumb implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task, ImageAttachment $imageAttachment)
    {
        $path = storage_path() . '/app/' . $imageAttachment->image;
        $pathinfo = pathinfo($path);

        $img = Image::make($path);
        $img->crop(30, 30);
        $newName = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-mobile.' . $pathinfo['extension'];
        $img->save($newName);
        $imageAttachment->thumb_mobile = $newName;

        $img = Image::make($path);
        $img->crop(100, 100);
        $newName = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-desktop.' . $pathinfo['extension'];
        $img->save($newName);
        $imageAttachment->thumb_desktop = $newName;

        $imageAttachment->save();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
