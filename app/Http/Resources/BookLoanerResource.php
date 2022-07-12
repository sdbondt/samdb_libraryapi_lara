<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookLoanerResource extends JsonResource
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
            'name' => $this->client->name(),
            'email' => $this->client->email,
            'startDate' => $this->getStartDate(),
            'returnDate' => $this->getReturnDate(),
            'late' => $this->late
        ];
    }
}
