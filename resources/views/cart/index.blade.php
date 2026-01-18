<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart — VOGUE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=IBM+Plex+Mono:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Header (same as index) -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-3 max-w-7xl mx-auto">
            <a href="{{ route('dashboard.index') }}" class="font-display text-2xl tracking-tighter uppercase text-gray-900" style="font-family: 'Archivo Black';">VOGUE</a>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if($cart && $cart->getTotalQuantity() > 0)
                        <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $cart->getTotalQuantity() }}</span>
                    @endif
                </a>
                
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-24 pb-16 px-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            
            <!-- Page Header -->
            <div class="mb-8 pb-4 border-b-4 border-gray-900">
                <h1 class="font-display text-5xl uppercase tracking-tighter" style="font-family: 'Archivo Black';">Shopping Cart</h1>
                <p class="text-gray-600 mt-2">{{ $cart->getTotalQuantity() }} items in your cart</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-4 border-green-600 text-green-900 px-6 py-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-4 border-red-600 text-red-900 px-6 py-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if($cart->items->isEmpty())
                <!-- Empty Cart -->
                <div class="bg-white border-4 border-gray-900 p-12 text-center">
                    <svg class="w-24 h-24 mx-auto mb-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h2 class="font-display text-3xl uppercase mb-4" style="font-family: 'Archivo Black';">Your Cart is Empty</h2>
                    <p class="text-gray-600 mb-6">Start shopping to add items to your cart</p>
                    <a href="{{ route('dashboard.index') }}" class="inline-block bg-gray-900 text-white border-4 border-gray-900 px-8 py-3 text-sm font-semibold uppercase tracking-wider hover:bg-blue-600 hover:border-blue-600 transition-all">
                        Continue Shopping
                    </a>
                </div>
            @else
                <!-- Cart Grid -->
                <div class="grid lg:grid-cols-3 gap-8">
                    
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cart->items as $item)
                            <div class="bg-white border-4 border-gray-900 p-6" x-data="{ quantity: {{ $item->quantity }} }">
                                <div class="flex gap-6">
                                    <!-- Product Image -->
                                    <div class="w-32 h-32 bg-gray-200 border-2 border-gray-900 flex-shrink-0">
                                        @if($item->product->productImages->first())
                                            <img src="{{ Storage::url($item->product->productImages->first()->image_path) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                No Image
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="font-display text-xl uppercase tracking-tight mb-2" style="font-family: 'Archivo Black';">
                                            {{ $item->product->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">SKU: {{ $item->product->sku }}</p>
                                        <p class="text-2xl font-bold text-blue-600 mb-4">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center border-2 border-gray-900">
                                                <button type="button" 
                                                        @click="quantity = Math.max(1, quantity - 1)"
                                                        class="px-4 py-2 hover:bg-gray-900 hover:text-white transition-colors">
                                                    −
                                                </button>
                                                <input type="number" 
                                                       x-model="quantity"
                                                       min="1" 
                                                       max="{{ $item->product->stock }}"
                                                       class="w-16 text-center py-2 border-x-2 border-gray-900 focus:outline-none">
                                                <button type="button"
                                                        @click="quantity = Math.min({{ $item->product->stock }}, quantity + 1)"
                                                        class="px-4 py-2 hover:bg-gray-900 hover:text-white transition-colors">
                                                    +
                                                </button>
                                            </div>

                                            <!-- Update Button -->
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="quantity" :value="quantity">
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm uppercase tracking-wider hover:bg-blue-700">
                                                    Update
                                                </button>
                                            </form>

                                            <!-- Remove Button -->
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 border-2 border-red-600 text-red-600 text-sm uppercase tracking-wider hover:bg-red-600 hover:text-white">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Stock Warning -->
                                        @if($item->product->stock < 10)
                                            <p class="text-sm text-red-600 mt-2">
                                                ⚠️ Only {{ $item->product->stock }} left in stock!
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Item Subtotal -->
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                                        <p class="text-2xl font-bold">
                                            Rp {{ number_format($item->getSubtotal(), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border-4 border-gray-900 p-6 sticky top-24">
                            <h2 class="font-display text-2xl uppercase mb-6" style="font-family: 'Archivo Black';">Order Summary</h2>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-bold">Rp {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-bold">Calculated at checkout</span>
                                </div>
                                <div class="border-t-2 border-gray-900 pt-4 flex justify-between">
                                    <span class="font-display text-xl uppercase" style="font-family: 'Archivo Black';">Total</span>
                                    <span class="font-display text-2xl text-blue-600" style="font-family: 'Archivo Black';">
                                        Rp {{ number_format($cart->getSubtotal(), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full bg-gray-900 text-white border-4 border-gray-900 py-4 text-center text-sm font-semibold uppercase tracking-wider hover:bg-blue-600 hover:border-blue-600 transition-all mb-3">
                                Proceed to Checkout
                            </a>

                            <a href="{{ route('dashboard.index') }}" class="block w-full border-4 border-gray-900 py-4 text-center text-sm font-semibold uppercase tracking-wider hover:bg-gray-900 hover:text-white transition-all">
                                Continue Shopping
                            </a>

                            <!-- Clear Cart -->
                            <form action="{{ route('cart.clear') }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-red-600 text-sm uppercase tracking-wider py-2 hover:underline">
                                    Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </main>

</body>
</html>