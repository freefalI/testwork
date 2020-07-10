<?php

namespace App\Http\Controllers;

use App\Board;
use App\Http\Resources\BoardResource;
use App\Http\Resources\TaskResource;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BoardResource::collection(Board::where('owner_id', Auth::user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return BoardResource
     */
    public function store(Request $request)
    {
        $this->authorize('create',Board::class);

        $data = $request->validate([
            'name' => [
                'required',
                'max:60'
            ],
        ]);
        $data['owner_id'] = auth()->id();

        return new BoardResource(Board::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param Board $board
     * @return BoardResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Board $board)
    {
        $this->authorize('view',$board);

        return new BoardResource($board);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Board $board
     * @return BoardResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Board $board)
    {

        $this->authorize('update', $board);

        $board->update($request->all());
        return BoardResource::make($board)
            ->additional(['meta' => [
                'message' => 'updated',
            ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Board $board
     * @return BoardResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);

        $board->delete();
        return BoardResource::make($board)
            ->additional(['meta' => [
                'message' => 'deleted',
            ]]);
    }

    public function taskList(Request $request, Board $board)
    {
        $this->authorize('viewTasks', $board);
        $query = Task::where('board_id', $board->id);
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
        return TaskResource::collection($query->get()->paginate(10));
    }

}
