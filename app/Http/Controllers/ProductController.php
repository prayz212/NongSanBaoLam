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

    public function index() {
        $products = Product::with(['main_pic', 'avgRating'])
            ->where('isDelete', '=', false)
            ->orderBy('created_at', 'DESC')
            ->paginate(3);

            // dd($products);
        return view('client.product-page')
            ->with('products', $products)
            ->with('queryString', '?page=');
    }

    public function search(Request $request) {
        $searchKey = $request->query('key');

        $products = Product::with(['main_pic', 'avgRating'])
            ->where('isDelete', '=', false)
            ->where('name', 'like', '%' . $searchKey . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(3);

        return view('client.product-page')
            ->with('products', $products)
            ->with('queryString', '?key=' . $searchKey . '&page=');
    }
}
