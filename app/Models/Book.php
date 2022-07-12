<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['author_id', 'title', 'description', 'quantity', 'available'];

    public function scopeFilter($query, array $filters) {
        if($filters['q'] ?? false) {
            $query->where(fn($query) => $query
            ->where('title', 'like', '%' . $filters['q']  . '%'))
            ->orWhere('description', 'like', '%' . $filters['q'] . '%')
            ->orWhereHas('author', fn($query) => $query->where('first_name', 'like', '%' . $filters['q']  . '%')
                ->orWhere('last_name', 'like', '%' . $filters['q']  . '%')
                ->orWhere('middle_name', 'like', '%' . $filters['q']  . '%'));
        }
        
        if($filters['late'] ?? false) {
            $operator = $filters['late'] === 'false' ? '>': '<=';
            $query->whereHas('loaners' ,fn($query) => $query->where('return_date', $operator, now()));
        }
    }

    public function author() {
        return $this->belongsTo(Author::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function loaners() {
        return $this->hasMany(LoanedBook::class);
    }

    public function readers() {
        return $this->hasMany(ReadBook::class);
    }

    public function available() {
        return $this->quantity - count($this->loaners);
    }
}
