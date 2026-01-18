<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // RELATIONSHIPS
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // HELPERS
    public function getSubtotal()
    {
        return $this->price * $this->quantity;
    }

    // Check if product still available
    public function isAvailable()
    {
        return $this->product && 
               $this->product->isInStock() && 
               $this->product->stock >= $this->quantity;
    }
}