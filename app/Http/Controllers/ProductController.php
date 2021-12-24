<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail($id) {
        $product = Product::with(['image', 'comment', 'avgRating'])
            ->get()
            ->where('isDelete', '=', false)
            ->find($id);

        $relative = Product::with(['main_pic', 'avgRating'])
            ->where('category_id', $product->category_id)
            ->where('isDelete', '=', false)
            ->where('product.id','!=',$id)
            ->limit(4)
            ->get();

        return view('client.product-detail')
            ->with('detail', $product)
            ->with('relative', $relative);
    }
}
