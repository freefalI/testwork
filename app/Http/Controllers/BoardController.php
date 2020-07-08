<?php

namespace App\Http\Controllers;

use App\Board;
use App\Station;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Board::where('owner_id', Auth::user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Board::class);

        $data = $request->validate([
            'name' => 'required|max:60',
        ]);
        $data['owner_id'] = auth()->id();

        return Board::create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board =Board::findOrFail($id);
        $this->authorize('view',$board);

        return $board;
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
        $board = Board::findOrFail($id);

        $this->authorize('update',$board);

        $board->update($request->all());
        return  response(['message'=>'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',Board::findOrFail($id));

        Board::destroy($id);
        return  response(['message'=>'deleted']);
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
        return $query->get();
    }

}
