<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanedBookResource extends JsonResource
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
            'loanId' => $this->id,
            'client' => new LoanedBookClientResource($this->client),
            'book' => new LoanedBookBookResource($this->book),
            'returnDate' => $this->getReturnDate(),
            'startDate' => $this->getStartDate(),
            'late' => $this->late
        ];
    }
}
