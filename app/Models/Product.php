<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'image',
    ];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
