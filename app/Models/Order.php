<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_province',
        'shipping_postal_code',
        'subtotal',
        'shipping_cost',
        'tax',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // HELPERS
    public static function generateOrderNumber()
    {
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', today())->latest()->first();
        $sequence = $lastOrder ? intval(substr($lastOrder->order_number, -3)) + 1 : 1;
        
        return 'ORD-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    // Create order from cart
    public static function createFromCart(Cart $cart, array $shippingData)
    {
        // Validate cart not empty
        if ($cart->items->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        // Validate all items are available
        foreach ($cart->items as $item) {
            if (!$item->isAvailable()) {
                throw new \Exception("Product {$item->product->name} is not available");
            }
        }

        // Calculate totals
        $subtotal = $cart->getSubtotal();
        $shippingCost = $shippingData['shipping_cost'] ?? 0;
        $tax = $shippingData['tax'] ?? 0;
        $total = $subtotal + $shippingCost + $tax;

        // Create order
        $order = self::create([
            'order_number' => self::generateOrderNumber(),
            'user_id' => $cart->user_id,
            'shipping_name' => $shippingData['name'],
            'shipping_phone' => $shippingData['phone'],
            'shipping_address' => $shippingData['address'],
            'shipping_city' => $shippingData['city'],
            'shipping_province' => $shippingData['province'],
            'shipping_postal_code' => $shippingData['postal_code'],
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $shippingData['payment_method'] ?? 'cod',
            'payment_status' => 'pending',
            'status' => 'pending',
            'notes' => $shippingData['notes'] ?? null,
        ]);

        // Create order items
        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'product_sku' => $cartItem->product->sku,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'subtotal' => $cartItem->getSubtotal(),
            ]);

            // Reduce product stock
            $cartItem->product->decrement('stock', $cartItem->quantity);
        }

        // Clear cart
        $cart->clear();

        return $order;
    }

    // Status badge color
    public function getStatusBadgeColor()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentStatusBadgeColor()
    {
        return match($this->payment_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}