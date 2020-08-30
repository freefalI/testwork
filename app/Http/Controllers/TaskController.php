<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Http\Requests\Task\AttachImage;
use App\Http\Requests\Task\Store;
use App\Http\Requests\Task\Update;
use App\Http\Resources\Task\TaskResource;
use App\Models\ImageAttachment;
use App\Jobs\MakeImageThumb;
use App\Models\Label;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index(Request $request, Board $board)
    {
        $this->authorize('view', $board);
        $query = Task::where('board_id', $board->id)->with(['status']);

        //label id
        if ($request->has('label')) {
            $label = $request->get('label');
            $query = $query->whereHas('labels', function ($q) use ($label) {
                $q->where('label_id', $label);
            });
        }
        //status id
        if ($request->has('status')) {
            $query = $query->where('status_id', $request->get('status'));
        }

        return TaskResource::collection($query->paginate(request('per_page',10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @param Board $board
     * @return TaskResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Store $request, Board $board)
    {
        $this->authorize('create', Task::class);
        return TaskResource::make(Task::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return TaskResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return TaskResource::make($task->load(['status','board']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Update $request
     * @param Task $task
     * @return TaskResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Update $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->all());

        return TaskResource::make($task->load(['status']))
            ->additional(['meta' => [
                'message' => 'updated',
            ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return TaskResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return TaskResource::make($task)
            ->additional(['meta' => [
                'message' => 'deleted',
            ]]);
    }

    public function attachLabel(Task $task, Label $label)
    {
        $this->authorize('attachLabel', $task);
        $label->tasks()->attach($task->id);
        return TaskResource::make($task->load('labels'))
            ->additional(['meta' => [
                'message' => 'attached',
            ]]);
    }

    public function attachImage(AttachImage $request, Task $task)
    {
        $this->authorize('attachImage', $task);

        $path = $request->file('image')->store('public');
        $imageAttachment = ImageAttachment::create([
            'task_id' => $task->id,
            'image' => $path,
            'user_id' => Auth::user()->id
        ]);
        MakeImageThumb::dispatch($task, $imageAttachment);
        return TaskResource::make($task)
            ->additional(['meta' => [
                'message' => 'attached',
            ]]);
    }
}
