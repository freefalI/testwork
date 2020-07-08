<?php

namespace App\Http\Controllers;

use App\Label;
use App\Task;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Label::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Label::class);

        $data = $request->validate([
            'title' => 'required|max:60',
        ]);

        return Label::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $label =Label::findOrFail($id);
        $this->authorize('view',$label);

        return $label;
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
        $label = Label::findOrFail($id);

        $this->authorize('update',$label);

        $label->update($request->all());
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
        $this->authorize('delete',Label::findOrFail($id));

        Label::destroy($id);
        return  response(['message'=>'deleted']);
    }
}
