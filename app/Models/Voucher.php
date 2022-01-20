<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'voucher';
    protected $fillable = ['id', 'code', 'discount', 'isUsed', 'start_at', 'end_at', 'isDelete'];
}
