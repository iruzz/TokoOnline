<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // HELPERS
    public function getTotalQuantity()
    {
        return $this->items->sum('quantity');
    }

    public function getSubtotal()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getTotal()
    {
        $subtotal = $this->getSubtotal();
        $shippingCost = 0; // Bisa ditambahkan logic shipping cost
        $tax = 0; // Bisa ditambahkan logic tax
        
        return $subtotal + $shippingCost + $tax;
    }

    // Add item to cart
    public function addItem($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        
        // Check stock
        if (!$product->isInStock() || $product->stock < $quantity) {
            return false;
        }

        // Check if item already exists
        $cartItem = $this->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            
            // Check stock limit
            if ($newQuantity > $product->stock) {
                return false;
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->final_price,
            ]);
        }

        return true;
    }

    // Update item quantity
    public function updateItemQuantity($cartItemId, $quantity)
    {
        $cartItem = $this->items()->findOrFail($cartItemId);
        
        if ($quantity <= 0) {
            $cartItem->delete();
            return true;
        }

        // Check stock
        if ($quantity > $cartItem->product->stock) {
            return false;
        }

        $cartItem->update(['quantity' => $quantity]);
        return true;
    }

    // Remove item
    public function removeItem($cartItemId)
    {
        $this->items()->where('id', $cartItemId)->delete();
    }

    // Clear cart
    public function clear()
    {
        $this->items()->delete();
    }
}