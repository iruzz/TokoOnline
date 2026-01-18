<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cart = Auth::user()->getOrCreateCart();
        $cart->load(['items.product.productImages']);
        
        return view('cart.index', compact('cart'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Auth::user()->getOrCreateCart();
        
        $success = $cart->addItem($request->product_id, $request->quantity);

        if (!$success) {
            return back()->with('error', 'Product is out of stock or insufficient quantity available.');
        }

        // Check if this is "Buy Now" (direct to checkout)
        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = Auth::user()->cart;
        
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart not found.');
        }

        $success = $cart->updateItemQuantity($cartItemId, $request->quantity);

        if (!$success) {
            return back()->with('error', 'Insufficient stock available.');
        }

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove($cartItemId)
    {
        $cart = Auth::user()->cart;
        
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart not found.');
        }

        $cart->removeItem($cartItemId);

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $cart = Auth::user()->cart;
        
        if ($cart) {
            $cart->clear();
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    /**
     * Get cart count (for AJAX)
     */
    public function count()
    {
        $count = Auth::check() ? Auth::user()->getCartItemCount() : 0;
        
        return response()->json(['count' => $count]);
    }
}