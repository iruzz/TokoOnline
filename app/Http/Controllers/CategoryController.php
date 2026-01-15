<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('product');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status);
        }

        // Sort by order
        $categories = $query->orderBy('order', 'asc')->paginate(10)->withQueryString();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        // Set default is_active if not provided
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Auto-generate order (last order + 1)
        $lastOrder = Category::max('order') ?? -1;
        $validated['order'] = $lastOrder + 1;

        Category::create($validated);

        return redirect()->route('admin.category.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::withCount('product')->findOrFail($id);
        
        // Get products in this category
        $products = Product::where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.category.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return redirect()->route('admin.category.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has products
        $productCount = $category->product()->count();
        
        if ($productCount > 0) {
            return redirect()->route('admin.category.index')
                ->with('error', "Cannot delete category with {$productCount} products. Please remove or reassign the products first.");
        }

        $category->delete();

        return redirect()->route('admin.category.index')
            ->with('success', 'Category deleted successfully!');
    }
}   