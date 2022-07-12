<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCategoryCollection;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function store(Author $author) {
        $attr = request()->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'categories' => ['sometimes'],
            'categories.*' => ['sometimes', Rule::exists('categories', 'id')],
            'quantity' => ['required', 'numeric', 'min:1', 'max:100']
        ]);
        
        $bookExists = Book::where([
            'author_id' => $author->id,
            'title' => $attr['title']
        ])->exists();

        if($bookExists) {
            return [
                'msg' => 'Book already exists'
            ];
        } else {
            $attr['author_id'] = $author->id;
            $book = Book::create($attr);
            $book->categories()->attach($attr['categories']);
            return [
                'book' => new BookResource($book)
            ];
        }

    }

    public function update(Author $author, Book $book) {
        $attr = request()->validate([
            'title' => ['sometimes', 'max:255'],
            'description' => ['sometimes'],
            'quantity' => ['sometimes', 'numeric']
        ]);
        
        $bookExists = Book::where([
            'author_id' => $author->id,
            'title' => $attr['title']
        ])->exists();

        if($bookExists) {
            return [
                'msg' => 'Book already exists'
            ];
        } else {
            $book->update($attr);
            return [
                'book' => new BookResource($book)
            ];
        }
    }

    public function destroy(Book $book) {
        $book->delete();
        return [
            'msg' => 'Book has been deleted.'
        ];
    }

    public function index() {
        $books = Book::latest()->filter(request(['q', 'late']))->paginate();
        return [
            'books' => new BookCollection($books)
        ];

    }

    public function show(Book $book) {
        return [
            'book' => new BookResource($book)
        ];
    }

    public function toggleCategory(Book $book, Category $category) {
        $book->categories()->toggle($category->id);
        return [
            'categories' => new BookCategoryCollection($book->categories)
        ];
    }
}
