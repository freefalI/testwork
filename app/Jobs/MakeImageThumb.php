<?php

namespace App\Jobs;

use App\ImageAttachment;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $path = $imageAttachment->image;
        $imageAttachment->thumb_mobile = '123';
        $imageAttachment->thumb_desktop = '123';
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
