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

    public function topSales() {
        $bestSaler = Product::orderBy('sold', 'DESC')
            ->with(['main_pic', 'avgRating'])
            ->where('isDelete', '=', false)
            ->paginate(3);

        return view('client.special-product-page')
            ->with('products', $bestSaler)
            ->with('title', 'Sản phẩm bán chạy')
            ->with('queryString', '?page=');
    }

    public function newProducts() {
        $newProducts = Product::orderBy('created_at', 'DESC')
            ->with(['main_pic', 'avgRating'])
            ->where('isDelete', '=', false)
            ->paginate(3);

        return view('client.special-product-page')
            ->with('products', $newProducts)
            ->with('title', 'Sản phẩm mới')
            ->with('queryString', '?page=');
    }

    public function flashSales() {
        $saleProducts = Product::orderBy('discount', 'DESC')
            ->with(['main_pic', 'avgRating'])
            ->where('isDelete', '=', false)
            ->where('discount', '!=', 0)
            ->paginate(3);

        return view('client.special-product-page')
            ->with('products', $saleProducts)
            ->with('title', 'Sản phẩm khuyến mãi')
            ->with('queryString', '?page=');
    }
}
