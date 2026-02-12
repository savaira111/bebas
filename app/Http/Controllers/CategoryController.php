<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Tampilkan semua kategori (hanya yang belum dihapus)
    public function index()
    {
        $categories = Category::latest()->get(); // exclude soft deleted
        return view('categories.index', compact('categories'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only(['name', 'slug', 'description']));

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil ditambahkan!');
    }

    // Form edit kategori
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->only(['name', 'slug', 'description']));

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil diupdate!');
    }

    // Soft delete kategori
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil dihapus (soft delete)!');
    }

    // Restore kategori
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil direstore!');
    }

    // Hapus permanen
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil dihapus permanen!');
    }
}
