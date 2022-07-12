<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientLoanedBookResource extends JsonResource
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
            'bookId' => $this->book_id,
            'title' => $this->book->title,
            'author' => $this->book->author->name(),
            'startDate' => $this->getStartDate(),
            'returnDate' => $this->getReturnDate(),
            'late' => $this->late
        ];
    }
}
