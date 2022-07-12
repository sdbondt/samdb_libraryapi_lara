<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email'];

    public function scopeFilter($query, ?string $filter) {
        if($filter ?? false) {
            $query->where(fn($query) => $query
            ->where('first_name', 'like', '%' . $filter . '%'))
            ->orWhere('last_name', 'like', '%' . $filter . '%')
            ->orWhere('email', 'like', '%' . $filter . '%');
        }
    }

    public function loanedBooks() {
        return $this->hasMany(LoanedBook::class);
    }

    public function readBooks() {
        return $this->hasMany(ReadBook::class);
    }

    public function name() {
        return $this->first_name . ' ' . $this->last_name;
    }
}
