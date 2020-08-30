<?php

namespace App\Http\Controllers;

use App\Http\Requests\Label\Store;
use App\Http\Requests\Label\Update;
use App\Http\Resources\LabelResource;
use App\Label;

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
     * @param  Store  $request
     * @return LabelResource
     */
    public function store(Store $request)
    {
        $this->authorize('create',Label::class);
        return LabelResource::make(Label::create($request->validated()));
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
     * @param Update $request
     * @param Label $label
     * @return LabelResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Update $request, Label $label)
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
