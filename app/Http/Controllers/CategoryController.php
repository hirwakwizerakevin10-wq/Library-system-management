<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('books')
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create', ['category' => null]);
    }

    public function store(Request $request)
    {
        Category::create($this->validated($request));

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load('books');

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request, $category->id));

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->exists()) {
            return back()->with('error', 'Move or delete books in this category first.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$id],
            'description' => ['nullable', 'string'],
        ]);
    }
}
