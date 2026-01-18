<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->order_number }} — VOGUE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=IBM+Plex+Mono:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Mono', monospace; }
    </style>
</head>
<body class="bg-gray-50">
    
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-3 max-w-7xl mx-auto">
            <a href="{{ route('dashboard.index') }}" class="font-display text-2xl tracking-tighter uppercase text-gray-900" style="font-family: 'Archivo Black';">VOGUE</a>
            <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Orders</a>
        </div>
    </header>

    <main class="py-12 px-6 min-h-screen">
        <div class="max-w-5xl mx-auto">
            
            <!-- Success Message -->
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

            <!-- Order Header -->
            <div class="bg-white border-4 border-gray-900 p-8 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="font-display text-4xl uppercase tracking-tighter mb-2" style="font-family: 'Archivo Black';">
                            Order #{{ $order->order_number }}
                        </h1>
                        <p class="text-gray-600">
                            Placed on {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-4 py-2 text-sm font-semibold uppercase {{ $order->getStatusBadgeColor() }} rounded">
                            {{ ucfirst($order->status) }}
                        </span>
                        <span class="px-4 py-2 text-sm font-semibold uppercase {{ $order->getPaymentStatusBadgeColor() }} rounded">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <!-- Order Actions -->
                @if($order->status === 'pending')
                    <div class="pt-4 border-t-2 border-gray-200">
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')" class="inline-block">
                            @csrf
                            <button type="submit" class="px-6 py-2 border-2 border-red-600 text-red-600 text-sm uppercase tracking-wider hover:bg-red-600 hover:text-white transition-all">
                                Cancel Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                
                <!-- Order Items -->
                <div class="md:col-span-2 space-y-4">
                    <div class="bg-white border-4 border-gray-900 p-6">
                        <h2 class="font-display text-2xl uppercase mb-6" style="font-family: 'Archivo Black';">Order Items</h2>
                        
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 pb-4 {{ !$loop->last ? 'border-b-2 border-gray-200' : '' }}">
                                    <!-- Product Image -->
                                    <div class="w-24 h-24 bg-gray-200 border-2 border-gray-900 flex-shrink-0">
                                        @if($item->product && $item->product->productImages->first())
                                            <img src="{{ Storage::url($item->product->productImages->first()->image_path) }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                                No Image
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="font-display text-lg uppercase tracking-tight mb-1" style="font-family: 'Archivo Black';">
                                            {{ $item->product_name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">SKU: {{ $item->product_sku }}</p>
                                        <div class="flex items-center gap-4">
                                            <span class="text-sm text-gray-600">Qty: {{ $item->quantity }}</span>
                                            <span class="text-sm text-gray-600">×</span>
                                            <span class="font-bold text-blue-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- Item Subtotal -->
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                                        <p class="font-display text-xl" style="font-family: 'Archivo Black';">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Shipping -->
                <div class="md:col-span-1 space-y-4">
                    
                    <!-- Order Summary -->
                    <div class="bg-white border-4 border-gray-900 p-6">
                        <h2 class="font-display text-xl uppercase mb-4" style="font-family: 'Archivo Black';">Order Summary</h2>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            @if($order->tax > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="font-bold">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="border-t-2 border-gray-900 pt-3 flex justify-between">
                                <span class="font-display text-lg uppercase" style="font-family: 'Archivo Black';">Total</span>
                                <span class="font-display text-2xl text-blue-600" style="font-family: 'Archivo Black';">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white border-4 border-gray-900 p-6">
                        <h2 class="font-display text-xl uppercase mb-4" style="font-family: 'Archivo Black';">Shipping Address</h2>
                        
                        <div class="text-sm space-y-2">
                            <p class="font-bold">{{ $order->shipping_name }}</p>
                            <p class="text-gray-600">{{ $order->shipping_phone }}</p>
                            <p class="text-gray-600">{{ $order->shipping_address }}</p>
                            <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_province }}</p>
                            <p class="text-gray-600">{{ $order->shipping_postal_code }}</p>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="bg-white border-4 border-gray-900 p-6">
                        <h2 class="font-display text-xl uppercase mb-4" style="font-family: 'Archivo Black';">Payment Info</h2>
                        
                        <div class="text-sm space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Method:</span>
                                <span class="font-bold uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-3 py-1 text-xs font-semibold uppercase {{ $order->getPaymentStatusBadgeColor() }} rounded">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        @if($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                            <div class="mt-4 p-4 bg-blue-50 border-2 border-blue-600 rounded">
                                <p class="text-xs text-blue-900 font-semibold mb-2">Transfer to:</p>
                                <p class="text-sm font-mono">Bank BCA</p>
                                <p class="text-sm font-mono font-bold">1234567890</p>
                                <p class="text-xs text-blue-800 mt-2">A/N VOGUE Store</p>
                            </div>
                        @endif
                    </div>

                    <!-- Order Notes -->
                    @if($order->notes)
                        <div class="bg-white border-4 border-gray-900 p-6">
                            <h2 class="font-display text-xl uppercase mb-4" style="font-family: 'Archivo Black';">Order Notes</h2>
                            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                        </div>
                    @endif

                </div>

            </div>

            <!-- Order Timeline (Optional - bisa ditambahkan) -->
            <div class="bg-white border-4 border-gray-900 p-6 mt-6">
                <h2 class="font-display text-2xl uppercase mb-6" style="font-family: 'Archivo Black';">Order Timeline</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Order Placed</p>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @if($order->status === 'cancelled')
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Order Cancelled</p>
                                <p class="text-sm text-gray-600">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

</body>
</html>