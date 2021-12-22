<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail($id) {
        $product = Product::with(['image', 'comment'])
            ->get()
            ->where('isDelete', '=', false)
            ->find($id);

        $relative = Product::with(['main_pic'])
            ->where('category_id', $product->category_id)
            ->where('isDelete', '=', false)
            ->where('product.id','!=',$id)
            ->limit(4)
            ->get();

        return view('client.product_detail')
            ->with('detail', $product)
            ->with('relative', $relative);
    }
}
