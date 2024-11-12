<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'country', 'city', 'street', 'house', 'apartment', 'postal_code',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
