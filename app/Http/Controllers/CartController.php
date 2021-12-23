<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request) {
        $product = Product::with(['main_pic', 'category'])->find($request->id);
        $oldCart = $request->session()->get('cart', null);
        $cart = new Cart($oldCart);
        $cart->add($product, $request->quantity);
        $request->session()->put('cart', $cart);

        return response()->json([
            'status' => 200
        ]);
    }

    public function updateToCart(Request $request) {
        $oldCart = $request->session()->get('cart', null);
        $cart = new Cart($oldCart);
        $cart->updateQuantity($request->id, $request->quantity);
        $request->session()->put('cart', $cart);

        return response()->json([
            'status' => 200
        ]);
    }

    public function deleteFormCart(Request $request) {
        $oldCart = $request->session()->get('cart', null);
        $cart = new Cart($oldCart);
        $cart->deleteItem($request->id);
        $request->session()->put('cart', $cart);

        return response()->json([
            'status' => 200
        ]);
    }

    public function index(Request $request) {
        $carts = $request->session()->get('cart', null);

        // dd($carts);
        return view('client.shopping-cart')
        ->with('carts', $carts);
    }
}
