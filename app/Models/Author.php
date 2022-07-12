<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'middle_name', 'last_name'];

    public function scopeFilter($query, ?string $filter) {
        if($filter ?? false) {
            $query->where(fn($query) => $query
            ->where('first_name', 'like', '%' . $filter . '%'))
            ->orWhere('middle_name', 'like', '%' . $filter . '%')
            ->orWhere('last_name', 'like', '%' . $filter . '%')
            ->orWhereHas('books', fn($query) => $query->where('title', 'like', '%' . $filter . '%')
                ->orWhere('description', 'like', '%' . $filter . '%'));
        }
    }

    public function books() {
        return $this->hasMany(Book::class);
    }

    public function name() {
        return $this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ': '') . $this->last_name;
    }
}
