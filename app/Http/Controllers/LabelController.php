<?php

namespace App\Http\Controllers;

use App\Http\Resources\LabelResource;
use App\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return  LabelResource::collection(Label::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return LabelResource
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

        return LabelResource::make(Label::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param Label $label
     * @return LabelResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Label $label)
    {
        $this->authorize('view',$label);

        return  LabelResource::make($label);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Label $label
     * @return LabelResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Label $label)
    {
        $this->authorize('update',$label);

        $label->update($request->all());
        return LabelResource::make($label)
            ->additional(['meta' => [
                'message' => 'updated',
            ]]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return LabelResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Label $label)
    {
        $this->authorize('delete',$label);

        $label->delete();
        return LabelResource::make($label)
            ->additional(['meta' => [
                'message' => 'deleted',
            ]]);

    }
}
