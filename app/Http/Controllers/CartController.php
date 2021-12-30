<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $SHIPPING_COST = 25000;
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

        return view('client.shopping-cart')
            ->with('carts', $carts);
    }

    public function payment(Request $request) {
        if ($request->session()->has('cart') && count($request->session()->get('cart')->items)) {
            $customer = Customer::find(Auth::id());
            $totalPrice = 0;
            $totalDiscount = 0;
            $shippingCost = $this->SHIPPING_COST;
            $carts = Session::get('cart')->items;

            foreach($carts as $c) {
                $qty = $c['qty'];
                $price = $c['item']->price;
                $discount = $c['item']->discount;

                if ($discount == NULL) {
                    $totalPrice += ($qty * $price);
                }
                else if ($discount != NULL) {
                    $finalPrice = $price - ($price * (float)$discount/100);
                    $totalDiscount += ($price - $finalPrice) * $qty;
                    $totalPrice += ($qty * $finalPrice);
                }
            }

            return view('client.payment')
                ->with('customer', $customer)
                ->with('totalPrice', $totalPrice)
                ->with('totalDiscount', $totalDiscount)
                ->with('shippingCost', $shippingCost);
        }
        else {
            return redirect()->route('shoppingCart');
        }
    }
}
