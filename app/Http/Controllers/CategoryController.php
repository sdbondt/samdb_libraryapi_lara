<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return [
            'categories' => new CategoryCollection($categories)
        ];
    }

    public function show(Category $category) {
        return [
            'category' => new CategoryResource($category)
        ];
    }

    public function update(Category $category) {
        $attr = request()->validate([
            'name' => ['required', Rule::unique('categories', 'name')->ignore($category->id)]
        ]);
        $attr['slug'] = Str::slug($attr['name']);
        $category->update($attr);
        return [
            'category' => new CategoryResource($category)
        ];
    }

    public function destroy(Category $category) {
        $category->delete();
        return [
            'msg' => 'Category got deleted'
        ];
    }

    public function store() {
        $attr = request()->validate([
            'name' => ['required', Rule::unique('categories', 'name')]
        ]);
        $attr['slug'] = Str::slug($attr['name']);
        $category = Category::create($attr);
        return [
            'category' => new CategoryResource($category)
        ];
    }
}
