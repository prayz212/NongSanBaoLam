<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AdminProductController extends Controller
{
    public function index() {
        $products = Product::with(['category', 'avgRating'])
            ->where('isDelete', false)->get();
        
        return view('admin.product-page')
            ->with('products', $products);
    }

    public function detail($id) {
        $product = Product::with('main_pic', 'category', 'avgRating', 'image')
            ->where('isDelete', false)
            ->find($id);

        return view('admin.product-info')
            ->with('product', $product);
    }

    public function delete($id) {
        $product = Product::where('isDelete', false)
            ->find($id);
        
        $product->isDelete = true;
        $product->save();

        return redirect()->route('productManagement');
    }

    public function update($id) {
        $product = Product::with('main_pic', 'category', 'avgRating', 'image')
            ->where('isDelete', false)
            ->find($id);

        return view('admin.product-edit')
            ->with('product', $product);
    }

    public function stockIn() {
        $categories = Category::get();
        
        return view('admin.product-stock-in')
            ->with('categories', $categories);
    }

    public function productsByCategory(Request $request) {
        if ($request->has('category')) {
            $products = Product::where('category_id', $request->query('category'))
                ->where('isDelete', false)
                ->select('id', 'name')
                ->get();
            
            $response =  response()->json([
                'status' => 200,
                'products' => $products
            ]);
        } else {
            $response = response()->json([
                'status' => 400
            ]);
        }

        return $response;
    }

    public function stockInProcess(Request $request) {
        if ($request->has('category') && $request->has('product') && $request->has('quantity')) {
            $product = Product::where('category_id', $request->category)
                ->where('isDelete', false)
                ->find($request->product);
            
            $product->quantity += $request->quantity;
            $product->save();
            
            $response =  response()->json([
                'status' => 200
            ]);
        } else {
            $response = response()->json([
                'status' => 400
            ]);
        }

        return $response;
    }

    public function create() {
        $categories = Category::get();
        return view('admin.product-create')
            ->with('categories', $categories);
    }

    public function createProcess() {
        die('ok');
    }
}
