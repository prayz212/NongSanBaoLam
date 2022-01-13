<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bill';
    protected $fillable = ['id', 'fullname', 'phone', 'email', 'address', 'notes', 'status', 'totalPrice', 'totalDiscount', 'shippingCost', 'totalPay', 'method', 'delivery_at', 'customer_id', 'card_id', 'voucher_id'];

    public function bill_detail()
    {
        return $this->hasMany('App\Models\BillDetail');
    }

    public function voucher() {
        return $this->hasOne('App\Models\Voucher', 'id', 'voucher_id');
    }

    public function card() {
        return $this->hasOne('App\Models\Card', 'id', 'card_id');
    }

    public function rating() {
        return $this->hasMany('App\Models\Rating');
    }
}
