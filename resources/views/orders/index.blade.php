<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders — VOGUE</title>
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
            <a href="{{ route('dashboard.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Shop</a>
        </div>
    </header>

    <main class="py-12 px-6 min-h-screen">
        <div class="max-w-6xl mx-auto">
            
            <div class="mb-8 pb-4 border-b-4 border-gray-900">
                <h1 class="font-display text-5xl uppercase tracking-tighter" style="font-family: 'Archivo Black';">My Orders</h1>
                <p class="text-gray-600 mt-2">Track and manage your orders</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-4 border-green-600 text-green-900 px-6 py-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="bg-white border-4 border-gray-900 p-12 text-center">
                    <svg class="w-24 h-24 mx-auto mb-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 class="font-display text-3xl uppercase mb-4" style="font-family: 'Archivo Black';">No Orders Yet</h2>
                    <p class="text-gray-600 mb-6">Start shopping to place your first order</p>
                    <a href="{{ route('dashboard.index') }}" class="inline-block bg-gray-900 text-white border-4 border-gray-900 px-8 py-3 text-sm font-semibold uppercase tracking-wider hover:bg-blue-600 hover:border-blue-600 transition-all">
                        Start Shopping
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white border-4 border-gray-900 overflow-hidden">
                            <!-- Order Header -->
                            <div class="bg-gray-100 px-6 py-4 border-b-2 border-gray-900 flex justify-between items-center">
                                <div>
                                    <div class="font-display text-xl uppercase" style="font-family: 'Archivo Black';">
                                        {{ $order->order_number }}
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <span class="px-4 py-2 text-xs font-semibold uppercase {{ $order->getStatusBadgeColor() }} rounded">
                                        {{ $order->status }}
                                    </span>
                                    <span class="px-4 py-2 text-xs font-semibold uppercase {{ $order->getPaymentStatusBadgeColor() }} rounded">
                                        {{ $order->payment_status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Order Body -->
                            <div class="p-6">
                                <div class="grid md:grid-cols-3 gap-6">
                                    <!-- Items Preview -->
                                    <div class="md:col-span-2">
                                        <h3 class="font-semibold uppercase mb-3">Items ({{ $order->items->count() }})</h3>
                                        <div class="space-y-2">
                                            @foreach($order->items->take(3) as $item)
                                                <div class="text-sm">
                                                    <span class="font-semibold">{{ $item->quantity }}x</span> {{ $item->product_name }}
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <div class="text-sm text-gray-600">
                                                    +{{ $order->items->count() - 3 }} more items
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Order Total -->
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600 mb-1">Total Amount</div>
                                        <div class="font-display text-3xl text-blue-600" style="font-family: 'Archivo Black';">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-600 mt-1">
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex justify-end gap-3 mt-6 pt-6 border-t-2 border-gray-200">
                                    <a href="{{ route('orders.show', $order->id) }}" class="px-6 py-2 border-2 border-gray-900 text-sm uppercase tracking-wider hover:bg-gray-900 hover:text-white transition-all">
                                        View Details
                                    </a>
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                            @csrf
                                            <button type="submit" class="px-6 py-2 border-2 border-red-600 text-red-600 text-sm uppercase tracking-wider hover:bg-red-600 hover:text-white transition-all">
                                                Cancel Order
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>
    </main>

</body>
</html>