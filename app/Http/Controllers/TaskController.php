<?php

namespace App\Http\Controllers;

use App\ImageAttachment;
use App\Jobs\MakeImageThumb;
use App\Label;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $data = $request->validate([
            'title' => [
                'required',
                'max:60'
            ],
            'status_id' => [
                'required',
                'numeric'
            ],
            'board_id' => [
                'required',
                'numeric'
            ],
        ]);

        return Task::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Task
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->all());
        return response(['message' => 'updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response(['message' => 'deleted']);
    }

    public function attachLabel(Task $task, Label $label)
    {
        $this->authorize('attachLabel', $task);
        $label->tasks()->attach($task->id);
        return response(['message' => 'attached']);
    }

    public function attachImage(Request $request, Task $task)
    {
        $this->authorize('attachImage', $task);
        $this->validate($request, [
            'image' => [
                'image',
                'mimes:jpeg,bmp,png',
                'max:2000'
            ]
        ]);
        $path = $request->file('image')->store('public');
        $imageAttachment = ImageAttachment::create([
            'task_id' => $task->id,
            'image' => $path,
            'user_id' => Auth::user()->id
        ]);
        MakeImageThumb::dispatch($task, $imageAttachment);
        return response(['message' => 'attached']);
    }
}
