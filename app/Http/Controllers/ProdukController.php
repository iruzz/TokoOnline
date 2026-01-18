<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'productImages'])
            ->latest()
            ->paginate(10);
        
        // Stats untuk cards
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $lowStockProducts = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();

        return view('admin.product.index', compact(
            'products',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'is_trending' => 'nullable|boolean',
            'badge' => 'nullable|string',
            'status' => 'required|in:active,inactive,out_of_stock',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle is_trending checkbox
        $validated['is_trending'] = $request->has('is_trending') ? 1 : 0;

        // Remove images from validated array (not part of products table)
        unset($validated['images']);

        // Create product first
        $product = Product::create($validated);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                
                // Create ProductImage with explicit product_id
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => $index === 0 ? 1 : 0, // First image is primary
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'productImages'])->findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $id,
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'is_trending' => 'nullable|boolean',
            'badge' => 'nullable|string',
            'status' => 'required|in:active,inactive,out_of_stock',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_order' => 'nullable|array',
        ]);

        // Update slug if name changed
        if ($request->name !== $product->name && empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle is_trending checkbox
        $validated['is_trending'] = $request->has('is_trending') ? 1 : 0;

        // Remove fields not in products table
        unset($validated['images'], $validated['image_order']);

        // Update product first
        $product->update($validated);

        // Update existing images order
        if ($request->has('image_order')) {
            foreach ($request->image_order as $imageId => $order) {
                \App\Models\ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id)
                    ->update([
                        'order' => $order,
                        'is_primary' => $order == 1 ? 1 : 0  // Order #1 = Primary
                    ]);
            }
        }

        // Upload new images
        if ($request->hasFile('images')) {
            $currentMaxOrder = \App\Models\ProductImage::where('product_id', $product->id)
                ->max('order') ?? 0;
            
            $existingImagesCount = \App\Models\ProductImage::where('product_id', $product->id)->count();
            
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                $newOrder = $currentMaxOrder + $index + 1;
                
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => $existingImagesCount === 0 && $index === 0 ? 1 : 0,
                    'order' => $newOrder,
                ]);
            }
        }

        // Final check: ensure first image (order=1) is primary
        $firstImage = \App\Models\ProductImage::where('product_id', $product->id)
            ->orderBy('order')
            ->first();
        
        if ($firstImage && !$firstImage->is_primary) {
            // Set all to non-primary first
            \App\Models\ProductImage::where('product_id', $product->id)
                ->update(['is_primary' => 0]);
            
            // Set first as primary
            $firstImage->update(['is_primary' => 1]);
        }

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Delete main image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete product images if exists
        foreach ($product->productImages as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully!');
    }
    
    /**
     * Delete a single product image (AJAX)
     */
    public function deleteImage(string $imageId)
    {
        $image = \App\Models\ProductImage::findOrFail($imageId);
        
        // Security check: ensure image belongs to a product
        $product = Product::findOrFail($image->product_id);
        
        // Prevent deleting if it's the last image
        $imageCount = \App\Models\ProductImage::where('product_id', $product->id)->count();
        if ($imageCount <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete the last image'
            ], 400);
        }
        
        // Delete file from storage
        Storage::disk('public')->delete($image->image_path);
        
        // Delete record
        $image->delete();
        
        // Reorder remaining images and set first as primary
        $remainingImages = \App\Models\ProductImage::where('product_id', $product->id)
            ->orderBy('order')
            ->get();
        
        foreach ($remainingImages as $index => $img) {
            $img->update([
                'order' => $index + 1,
                'is_primary' => $index === 0 ? 1 : 0
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}