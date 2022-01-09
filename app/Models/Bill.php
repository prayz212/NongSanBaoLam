<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bill';
    protected $fillable = ['id', 'fullname', 'phone', 'email', 'address', 'notes', 'totalPrice', 'totalDiscount', 'shippingCost', 'totalPay', 'method', 'delivery_at'];
}
