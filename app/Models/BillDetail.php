<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;
    protected $table = 'bill_detail';
    protected $primaryKey = ['bill_id', 'product_id'];
    public $incrementing = false;
    protected $fillable = ['bill_id', 'product_id', 'unit_price', 'quantity'];

    public function bill() {
        return $this->belongsTo('App\Models\Bill');
    }

    public function item() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}


