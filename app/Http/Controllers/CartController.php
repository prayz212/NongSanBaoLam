<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request) {

        // $product = Product::find($request->id);
        // $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // $cart = new Cart($oldCart);
        // $cart->add($product, $request->quantity);

        // return response()->json([
        //     'status' => 200,
        //     'qty' => Session::get('cart')->items,
        //     'price' => Session::get('cart')->totalPrice
        // ]);

        return response()->json([
            'status' => 200,
            'message' => 'test'
        ]);
    }
}
