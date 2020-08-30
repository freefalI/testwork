<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Board\BoardResource;
use App\Http\Resources\Status\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => new StatusResource($this->whenLoaded('status')),
            'board' => new BoardResource($this->whenLoaded('board')),
            'status_id' => $this->status_id,
            'board_id' => $this->board_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
