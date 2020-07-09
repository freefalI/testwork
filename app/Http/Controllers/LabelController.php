<?php

namespace App\Http\Controllers;

use App\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Label[]|\Illuminate\Database\Eloquent\Collection
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
            'title' => [
                'required',
                'max:60'
            ]
        ]);

        return Label::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param Label $label
     * @return Label
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Label $label)
    {
        $this->authorize('view',$label);

        return $label;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Label $label
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Label $label)
    {
        $this->authorize('update',$label);

        $label->update($request->all());
        return  response(['message'=>'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Label $label)
    {
        $this->authorize('delete',$label);

        $label->delete();
        return  response(['message'=>'deleted']);
    }
}
