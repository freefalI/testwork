<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Http\Requests\Board\Store;
use App\Http\Requests\Board\Update;
use App\Http\Resources\BoardResource;
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
     * @param Store $request
     * @return BoardResource
     */
    public function store(Store $request)
    {
        $this->authorize('create', Board::class);

        $data = $request->validated();
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
     * @param Update $request
     * @param Board $board
     * @return BoardResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Update $request, Board $board)
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


}
