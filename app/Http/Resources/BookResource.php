<?php

namespace App\Http\Resources;

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
            'bookId' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'available' => $this->available(),
            'author' => $this->author->name(),
            'categories' => new BookCategoryCollection($this->categories),
            'loaners' => new BookLoanerCollection($this->loaners),
            'readers' => new BookReaderCollection($this->readers)
        ];
    }
}
