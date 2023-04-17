<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->getKey(),
            'creator' => UserResource::make($this->whenLoaded('user')),
            // 'creator-belonsto' => $this->user->name,
            'name'    => $this->name,
            'author'  => $this->author,
        ];
    }
}
