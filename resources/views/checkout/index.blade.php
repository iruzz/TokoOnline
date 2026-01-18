<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — VOGUE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=IBM+Plex+Mono:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-3 max-w-7xl mx-auto">
            <a href="{{ route('dashboard.index') }}" class="font-display text-2xl tracking-tighter uppercase text-gray-900" style="font-family: 'Archivo Black';">VOGUE</a>
            <div class="text-sm text-gray-600">Secure Checkout 🔒</div>
        </div>
    </header>

    <main class="py-12 px-6 min-h-screen">
        <div class="max-w-6xl mx-auto">
            
            <!-- Page Header -->
            <div class="mb-8 pb-4 border-b-4 border-gray-900">
                <h1 class="font-display text-5xl uppercase tracking-tighter" style="font-family: 'Archivo Black';">Checkout</h1>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border-4 border-red-600 text-red-900 px-6 py-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <div class="grid lg:grid-cols-3 gap-8">
                    
                    <!-- Shipping Information -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Shipping Address -->
                        <div class="bg-white border-4 border-gray-900 p-6">
                            <h2 class="font-display text-2xl uppercase mb-6" style="font-family: 'Archivo Black';">Shipping Address</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">Full Name *</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                           class="w-full px-4 py-3 border-2 border-gray-900 focus:outline-none focus:border-blue-600 @error('name') border-red-600 @enderror">
                                    @error('name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">Phone Number *</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                                           class="w-full px-4 py-3 border-2 border-gray-900 focus:outline-none focus:border-blue-600 @error('phone') border-red-600 @enderror">
                                    @error('phone')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">Address *</label>
                                    <textarea name="address" rows="3" required
                                              class="w-full px-4 py-3 border-2 border-gray-900 focus:outline-none focus:border-blue-600 @error('address') border-red-600 @enderror">{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold mb-2 uppercase">City *</label>
                                        <input type="text" name="city" value="{{ old('city') }}" required
                                               class="w-full px-4 py-3 border-2 border-gray-900 focus:outline-none focus:border-blue-600 @error('city') border-red-600 @enderror">
                                        @error('city')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-2 uppercase">Province *</label>
                                        <input type="text" name="province" value="{{ old('province') }}" required
                                               class="w-full px-4 py-3 border-2 border-gray-900 focus:outline-none focus:border-blue-600 @error('province') border-red-600 @enderror">
                                        @error('province')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-2 uppercase">Postal Code *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                           class="w-full px-4 py-3 border-2 border-gray-900 focus:outline-none focus:border-blue-600 @error('postal_code') border-red-600 @enderror">
                                    @error('postal_code')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white border-4 border-gray-900 p-6">
                            <h2 class="font-display text-2xl uppercase mb-6" style="font-family: 'Archivo Black';">Payment Method</h2>
                            
                            <div class="space-y-3">
                                <label class="flex items-center gap-4 border-2 border-gray-900 p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5">
                                    <div>
                                        <div class="font-semibold uppercase">Cash on Delivery (COD)</div>
                                        <div class="text-sm text-gray-600">Pay when you receive your order</div>
                                    </div>
                                </label>

                                <label class="flex items-center gap-4 border-2 border-gray-900 p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5">
                                    <div>
                                        <div class="font-semibold uppercase">Bank Transfer</div>
                                        <div class="text-sm text-gray-600">Transfer to our bank account</div>
                                    </div>
                                </label>

                                <label class="flex items-center gap-4 border-2 border-gray-900 p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="e_wallet" class="w-5 h-5">
                                    <div>
                                        <div class="font-semibold uppercase">E-Wallet</div>
                                        <div class="text-sm text-gray-600">GoPay, OVO, Dana</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="bg-white border-4 border-gray-900 p-6">
                            <h2 class="font-display text-2xl uppercase mb-6" style="font-family: 'Archivo Black';">Order Notes</h2>
                            <textarea name="notes" rows="4" placeholder="Special instructions for your order..."
                                      class="w-full px-4 py-3 border-2 border-gray-900 focus:outline-none focus:border-blue-600">{{ old('notes') }}</textarea>
                        </div>

                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border-4 border-gray-900 p-6 sticky top-6">
                            <h2 class="font-display text-2xl uppercase mb-6" style="font-family: 'Archivo Black';">Order Summary</h2>
                            
                            <!-- Cart Items -->
                            <div class="space-y-4 mb-6 max-h-60 overflow-y-auto">
                                @foreach($cart->items as $item)
                                    <div class="flex gap-3 pb-4 border-b border-gray-200">
                                        <div class="w-16 h-16 bg-gray-200 border border-gray-900 flex-shrink-0">
                                            @if($item->product->productImages->first())
                                                <img src="{{ Storage::url($item->product->productImages->first()->image_path) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-semibold">{{ $item->product->name }}</div>
                                            <div class="text-xs text-gray-600">Qty: {{ $item->quantity }}</div>
                                            <div class="text-sm font-bold text-blue-600 mt-1">
                                                Rp {{ number_format($item->getSubtotal(), 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pricing -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal ({{ $cart->getTotalQuantity() }} items)</span>
                                    <span class="font-bold">Rp {{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-bold">Rp 15.000</span>
                                </div>
                                <div class="border-t-2 border-gray-900 pt-3 flex justify-between">
                                    <span class="font-display text-xl uppercase" style="font-family: 'Archivo Black';">Total</span>
                                    <span class="font-display text-2xl text-blue-600" style="font-family: 'Archivo Black';">
                                        Rp {{ number_format($cart->getSubtotal() + 15000, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-gray-900 text-white border-4 border-gray-900 py-4 text-center text-sm font-semibold uppercase tracking-wider hover:bg-blue-600 hover:border-blue-600 transition-all">
                                Place Order
                            </button>

                            <a href="{{ route('cart.index') }}" class="block w-full text-center text-sm uppercase tracking-wider py-3 text-gray-600 hover:text-gray-900 mt-3">
                                ← Back to Cart
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </main>

</body>
</html>