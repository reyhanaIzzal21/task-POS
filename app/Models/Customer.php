<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_name',
        'address',
        'phone_number',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
