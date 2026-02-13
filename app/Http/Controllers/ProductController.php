<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        if ($request->has('create_another')) {
            return redirect()->route('products.create')->with('success', 'Product created successfully.');
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete(); // Soft delete

        return redirect()->route('products.index')->with('success', 'Product moved to trash.');
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->with('category')->latest()->paginate(10);
        return view('products.trashed', compact('products'));
    }

    public function restore($id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Product restored successfully.');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->forceDelete();
        return back()->with('success', 'Product permanently deleted.');
    }
}
