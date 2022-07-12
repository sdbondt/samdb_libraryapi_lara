<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanedBook extends Model
{
    use HasFactory;
    protected $fillable = ['book_id', 'client_id', 'return_date'];

    public function scopeFilter($query, array $filters) {
        if($filters['q'] ?? false) {
            $query->where(fn($query) => $query
            ->whereHas('book', fn($query) => $query
                ->where('title', 'like', '%' . $filters['q'] . '%')
                ->orWhere('description', 'like', '%' . $filters['q'] . '%')
            )
            ->orWhereHas('client', fn($query) => $query
                ->where('last_name', 'like', '%' . $filters['q'] . '%')
                ->orWhere('first_name', 'like', '%' . $filters['q'] . '%')
                ->orWhere('email', 'like', '%' . $filters['q'] . '%')
        ));

        if($filters['late'] ?? false) {
            $operator = $filters['late'] === 'false' ? '>': '<=';
            $query->where(fn($query) => $query->where('return_date', $operator, now()) );
        }
        }

    }

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function getStartDate() {
        return date('d-m-Y', strtotime($this->start_date));
    }

    public function getReturnDate() {
        return date('d-m-Y', strtotime($this->return_date));
    }

    public function getLateAttribute() {
        return $this->return_date <= now();
        
    }

}
