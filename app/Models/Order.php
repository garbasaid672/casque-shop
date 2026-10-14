<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'email',
        'phone',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total',
        'currency',
        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_postal_code',
        'billing_country',
        'billing_phone',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'shipping_phone',
        'notes',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFullBillingAddressAttribute(): string
    {
        return "{$this->billing_address}, {$this->billing_postal_code} {$this->billing_city}, {$this->billing_country}";
    }

    public function getFullShippingAddressAttribute(): string
    {
        if (!$this->shipping_address) {
            return $this->full_billing_address;
        }
        return "{$this->shipping_address}, {$this->shipping_postal_code} {$this->shipping_city}, {$this->shipping_country}";
    }
}