<?php

namespace App\Http\Controllers;

use App\Board;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Task::class);

        $data = $request->validate([
            'title' => 'required|max:60',
            'status_id' => 'required|numeric',
            'board_id' => 'required|numeric',
        ]);

        return Task::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task =Task::findOrFail($id);
        $this->authorize('view',$task);

        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $this->authorize('update',$task);

        $task->update($request->all());
        return  response(['message'=>'updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',Task::findOrFail($id));

        Board::destroy($id);
        return  response(['message'=>'deleted']);
    }
}
