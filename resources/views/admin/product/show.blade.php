<x-admin-layout>
    <x-slot name="title">Product Details</x-slot>
    <x-slot name="header">Product Details</x-slot>
    <x-slot name="subtitle">View product information</x-slot>

    <div class="max-w-7xl">
        <!-- Back Button & Actions -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.product.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.product.edit', $product->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Product
                </a>
                
                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="inline-block" 
                      onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Images -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Images</h3>
                    
                    @if($product->productImages->count() > 0)
                        <!-- Main Image -->
                        @php
                            $primaryImage = $product->productImages->where('is_primary', true)->first() 
                                         ?? $product->productImages->sortBy('order')->first();
                        @endphp
                        
                        <div x-data="{ currentImage: '{{ asset('storage/' . $primaryImage->image_path) }}' }">
                            <!-- Large Display -->
                            <div class="mb-4 relative">
                                <img :src="currentImage" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-80 object-cover rounded-lg border-2 border-gray-200">
                            </div>
                            
                            <!-- Thumbnails -->
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->productImages->sortBy('order') as $image)
                                    <div class="relative cursor-pointer group"
                                         @click="currentImage = '{{ asset('storage/' . $image->image_path) }}'">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-20 object-cover rounded-lg border-2 transition-all"
                                             :class="currentImage === '{{ asset('storage/' . $image->image_path) }}' ? 'border-blue-500' : 'border-gray-200 hover:border-blue-300'">
                                        
                                        @if($image->is_primary)
                                            <span class="absolute top-1 left-1 bg-blue-600 text-white text-xs px-1.5 py-0.5 rounded">
                                                Primary
                                            </span>
                                        @endif
                                        
                                        <span class="absolute top-1 right-1 bg-gray-900 bg-opacity-75 text-white text-xs px-1.5 py-0.5 rounded">
                                            #{{ $image->order }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <p class="mt-3 text-xs text-gray-500 text-center">
                                {{ $product->productImages->count() }} image(s) • Click thumbnail to view
                            </p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-80 bg-gray-50 rounded-lg">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No images available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Product Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @if($product->status === 'active')
                                <span class="px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">Active</span>
                            @elseif($product->status === 'out_of_stock')
                                <span class="px-3 py-1 text-sm font-medium text-red-700 bg-red-100 rounded-full">Out of Stock</span>
                            @else
                                <span class="px-3 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-full">Inactive</span>
                            @endif
                            
                            @if($product->is_trending)
                                <span class="px-3 py-1 text-sm font-medium text-purple-700 bg-purple-100 rounded-full">Trending</span>
                            @endif
                            
                            @if($product->badge)
                                <span class="px-3 py-1 text-sm font-medium text-orange-700 bg-orange-100 rounded-full">{{ $product->badge }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    
                    <!-- Price & Stock Info -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Price</p>
                            <p class="text-lg font-bold text-gray-900">
                                ${{ number_format($product->price, 2) }}
                            </p>
                        </div>
                        
                        @if($product->discount_price)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Discount Price</p>
                                <p class="text-lg font-bold text-red-600">
                                    ${{ number_format($product->discount_price, 2) }}
                                </p>
                                <p class="text-xs text-green-600 font-medium">
                                    Save {{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%
                                </p>
                            </div>
                        @endif
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Stock</p>
                            <p class="text-lg font-bold" 
                               :class="{
                                   'text-red-600': {{ $product->stock }} === 0,
                                   'text-yellow-600': {{ $product->stock }} > 0 && {{ $product->stock }} <= 10,
                                   'text-green-600': {{ $product->stock }} > 10
                               }">
                                {{ $product->stock }} units
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Final Price</p>
                            <p class="text-lg font-bold text-blue-600">
                                ${{ number_format($product->final_price, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Product Details Card -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Category</p>
                            <p class="text-gray-900">{{ $product->category->name ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Slug</p>
                            <p class="text-gray-900 font-mono text-sm">{{ $product->slug }}</p>
                        </div>
                        
                        @if($product->size)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-1">Size</p>
                                <p class="text-gray-900">{{ $product->size }}</p>
                            </div>
                        @endif
                        
                        @if($product->color)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-1">Color</p>
                                <p class="text-gray-900">{{ $product->color }}</p>
                            </div>
                        @endif
                        
                        @if($product->featured_group_id)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-1">Featured Group</p>
                                <p class="text-gray-900">{{ $product->featuredGroup->name ?? '-' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timestamps Card -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Timestamps</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Created At</p>
                            <p class="text-gray-900">{{ $product->created_at->format('M d, Y - H:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $product->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Last Updated</p>
                            <p class="text-gray-900">{{ $product->updated_at->format('M d, Y - H:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $product->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stock Status Info -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-lg" 
                             :class="{{ $product->isInStock() ? 'bg-green-50' : 'bg-red-50' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" 
                                     :class="{{ $product->isInStock() ? 'text-green-600' : 'text-red-600' }}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($product->isInStock())
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @endif
                                </svg>
                                <span class="font-medium" 
                                      :class="{{ $product->isInStock() ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $product->isInStock() ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                            <span class="text-sm font-semibold" 
                                  :class="{{ $product->isInStock() ? 'text-green-700' : 'text-red-700' }}">
                                {{ $product->stock }} units available
                            </span>
                        </div>
                        
                        @if($product->stock > 0 && $product->stock <= 10)
                            <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span class="text-sm font-medium text-yellow-700">Low stock warning - Consider restocking soon</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>