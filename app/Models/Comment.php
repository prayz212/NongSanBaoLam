<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment';
    protected $fillable = ['id', 'name', 'content', 'reply_to', 'product_id'];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
