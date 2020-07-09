<?php

namespace App\Http\Controllers;

use App\Board;
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('view', $task);

        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $this->authorize('update', $task);

        $task->update($request->all());
        return response(['message' => 'updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Task::findOrFail($id));

        Board::destroy($id);
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
