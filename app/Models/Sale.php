<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_date',
        'subtotal',
        'tax_amount',
        'total_price',
        'paid_amount',
        'change_amount',
        'customer_id',
        'user_id',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
