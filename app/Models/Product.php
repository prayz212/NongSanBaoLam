<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = ['id', 'name', 'description', 'price', 'isDetele'];

    public function image() {
        return $this->hasMany('App\Models\Image');
    }

    public function main_pic() {
        return $this->hasOne('App\Models\Image')->oldest();
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function comment() {
        return $this->hasMany('App\Models\Comment');
    }
}
