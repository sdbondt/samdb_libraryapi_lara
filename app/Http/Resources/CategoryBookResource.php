<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryBookResource extends JsonResource
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
            'bookId' => $this->id,
            'author' => $this->author->name(),
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'available' => $this->available()
        ];;
    }
}
