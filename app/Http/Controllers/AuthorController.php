<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;

class AuthorController extends Controller
{
    public function store() {
        $attr = request()->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'middle_name' => ['sometimes', 'min:2', 'max:255'],
            'last_name' => ['required', 'min:2', 'max:255']
        ]);
        $author = Author::create($attr);
        return [
            'author' => new AuthorResource($author)
        ];
    }

    public function show(Author $author) {
        return [
            'author' => new AuthorResource($author)
        ];
    }

    public function index() {
        $authors = Author::latest()->filter(request('q'))->paginate(10);
        return [
            'authors' => new AuthorCollection($authors)
        ];
    }

    public function update(Author $author) {
        $attr = request()->validate([
            'first_name' => ['sometimes', 'min:2', 'max:255'],
            'middle_name' => ['sometimes', 'min:2', 'max:255'],
            'last_name' => ['sometimes', 'min:2', 'max:255']
        ]);
        $author->update($attr);
        return [
            'author' => new AuthorResource($author)
        ];
    }

    public function delete(Author $author) {
        $author->delete();
        return [
            'msg' => 'Author got deleted'
        ];
    }
}
