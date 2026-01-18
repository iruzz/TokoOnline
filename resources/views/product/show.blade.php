<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} — VOGUE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=IBM+Plex+Mono:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>
<body class="bg-gray-50" x-data="productPage()">
    
    <!-- Header (Simple) -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-3 max-w-7xl mx-auto">
            <a href="{{ route('dashboard.index') }}" class="font-display text-2xl tracking-tighter uppercase text-gray-900" style="font-family: 'Archivo Black';">VOGUE</a>
            
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 relative transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @php
                            $cartCount = auth()->user()->getCartItemCount();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endauth
                <a href="{{ route('dashboard.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Shop</a>
            </div>
        </div>
    </header>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed top-20 right-6 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-slideDown">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-6 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-slideDown">
            {{ session('error') }}
        </div>
    @endif

    <main class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            
            <!-- Product Detail -->
            <div class="grid md:grid-cols-2 gap-12 mb-16">
                
                <!-- Image Gallery -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="bg-white border-4 border-gray-900 aspect-square overflow-hidden">
                        @if($product->productImages->isNotEmpty())
                            <img :src="selectedImage" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span class="text-xl">No Image</span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($product->productImages->count() > 1)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($product->productImages as $image)
                                <div @click="selectImage('{{ Storage::url($image->image_path) }}')"
                                     :class="selectedImage === '{{ Storage::url($image->image_path) }}' ? 'border-blue-600' : 'border-gray-900'"
                                     class="border-4 aspect-square cursor-pointer hover:border-blue-600 transition-colors overflow-hidden">
                                    <img src="{{ Storage::url($image->image_path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    
                    <!-- Badge -->
                    @if($product->badge)
                        <div>
                            <span class="bg-blue-600 text-white text-xs font-bold px-4 py-2 uppercase tracking-wider">{{ $product->badge }}</span>
                        </div>
                    @endif

                    <!-- Title & Category -->
                    <div>
                        <div class="text-sm text-blue-600 uppercase tracking-wider font-semibold mb-2">
                            {{ $product->category->name }}
                        </div>
                        <h1 class="font-display text-5xl uppercase tracking-tighter mb-4" style="font-family: 'Archivo Black';">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <!-- Price -->
                    <div class="flex items-baseline gap-4">
                        @if($product->discount_price)
                            <span class="font-display text-4xl text-blue-600" style="font-family: 'Archivo Black';">
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            </span>
                            <span class="text-2xl text-gray-400 line-through">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="bg-red-100 text-red-600 px-3 py-1 text-sm font-bold rounded">
                                {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                            </span>
                        @else
                            <span class="font-display text-4xl text-blue-600" style="font-family: 'Archivo Black';">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Product Details -->
                    <div class="border-t-2 border-gray-200 pt-6 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 font-semibold">SKU:</span>
                            <span class="font-mono">{{ $product->sku }}</span>
                        </div>
                        
                        @if($product->size)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-semibold">Size:</span>
                                <span>{{ $product->size }}</span>
                            </div>
                        @endif

                        @if($product->color)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 font-semibold">Color:</span>
                                <span>{{ $product->color }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 font-semibold">Availability:</span>
                            @if($product->stock > 0)
                                <span class="text-green-600 font-bold">In Stock ({{ $product->stock }} available)</span>
                            @else
                                <span class="text-red-600 font-bold">Out of Stock</span>
                            @endif
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    @if($product->stock > 0)
                        <div class="border-t-2 border-gray-200 pt-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Quantity:</label>
                            <div class="flex items-center border-4 border-gray-900 w-40">
                                <button type="button" 
                                        @click="quantity = Math.max(1, quantity - 1)"
                                        class="px-6 py-3 hover:bg-gray-900 hover:text-white transition-colors text-xl font-bold">
                                    −
                                </button>
                                <input type="number" 
                                       x-model="quantity"
                                       min="1" 
                                       :max="{{ $product->stock }}"
                                       class="w-20 text-center py-3 border-x-4 border-gray-900 focus:outline-none text-xl font-bold">
                                <button type="button"
                                        @click="quantity = Math.min({{ $product->stock }}, quantity + 1)"
                                        class="px-6 py-3 hover:bg-gray-900 hover:text-white transition-colors text-xl font-bold">
                                    +
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t-2 border-gray-200 pt-6 space-y-4">
                            @auth
                                <!-- Add to Cart -->
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" x-model="quantity">
                                    <button type="submit" 
                                            class="w-full bg-gray-900 text-white border-4 border-gray-900 py-4 text-center text-sm font-semibold uppercase tracking-wider hover:bg-blue-600 hover:border-blue-600 transition-all">
                                        🛒 Add to Cart
                                    </button>
                                </form>

                                <!-- Buy Now (Direct to Checkout) -->
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" x-model="quantity">
                                    <input type="hidden" name="buy_now" value="1">
                                    <button type="submit" 
                                            class="w-full bg-blue-600 text-white border-4 border-blue-600 py-4 text-center text-sm font-semibold uppercase tracking-wider hover:bg-blue-700 hover:border-blue-700 transition-all">
                                        ⚡ Buy Now
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full bg-gray-900 text-white border-4 border-gray-900 py-4 text-center text-sm font-semibold uppercase tracking-wider hover:bg-blue-600 hover:border-blue-600 transition-all">
                                    Login to Purchase
                                </a>
                            @endauth
                        </div>
                    @else
                        <div class="border-t-2 border-gray-200 pt-6">
                            <div class="bg-red-100 border-4 border-red-600 text-red-900 px-6 py-4 text-center font-bold uppercase">
                                Out of Stock
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->isNotEmpty())
                <div class="border-t-4 border-gray-900 pt-16">
                    <h2 class="font-display text-4xl uppercase tracking-tighter mb-8" style="font-family: 'Archivo Black';">
                        You May Also Like
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <div class="bg-white border-4 border-gray-900 hover:shadow-[8px_8px_0_#0a0a0a] transition-all">
                                <a href="{{ route('product.show', $related->slug) }}">
                                    <div class="aspect-square bg-gray-200 overflow-hidden">
                                        @if($related->productImages->first())
                                            <img src="{{ Storage::url($related->productImages->first()->image_path) }}" 
                                                 alt="{{ $related->name }}" 
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-display text-lg uppercase tracking-tight mb-2">{{ $related->name }}</h3>
                                        <div class="font-bold text-xl text-blue-600">
                                            Rp {{ number_format($related->final_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </main>

    <script>
        function productPage() {
            return {
                quantity: 1,
                selectedImage: '{{ $product->productImages->first() ? Storage::url($product->productImages->first()->image_path) : "" }}',
                
                selectImage(imageUrl) {
                    this.selectedImage = imageUrl;
                }
            }
        }

        // Auto-hide notifications
        setTimeout(() => {
            const notifications = document.querySelectorAll('.animate-slideDown');
            notifications.forEach(n => n.style.display = 'none');
        }, 3000);
    </script>

</body>
</html>