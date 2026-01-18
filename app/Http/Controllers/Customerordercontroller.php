<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    // REMOVE __construct() - middleware di route aja!

    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Show single order detail
     */
    public function show($id)
    {
        $order = Auth::user()->orders()
            ->with(['items.product.productImages'])
            ->findOrFail($id);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Cancel order (only if still pending)
     */
    public function cancel($id)
    {
        $order = Auth::user()->orders()->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);
        
        // Restore stock
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        return back()->with('success', 'Order cancelled successfully.');
    }
}