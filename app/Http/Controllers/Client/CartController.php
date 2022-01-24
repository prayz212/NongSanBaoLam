<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Voucher;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Card;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\PaymentRequest;
use App\Notifications\PaymentInvoiceNotification;

class CartController extends Controller
{
    private $SHIPPING_COST = 25000;
    private $BILL_STATUS = ['IN_PROCESS' => 'Đang xử lý', 'IN_DELIVERY' => 'Đang giao hàng', 'DELIVERED' => 'Đã giao', 'CANCELED' => 'Đã huỷ'];

    public function addToCart(Request $request) {
        try {
            $product = Product::with(['main_pic', 'category'])->find($request->id);
            $oldCart = $request->session()->get('cart', null);
            $cart = new Cart($oldCart);
            $cart->add($product, $request->quantity);
            $request->session()->put('cart', $cart);

            return response()->json([
                'status' => 200
            ]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function updateToCart(Request $request) {
        try {
            $oldCart = $request->session()->get('cart', null);
            $cart = new Cart($oldCart);
            $cart->updateQuantity($request->id, $request->quantity);
            $request->session()->put('cart', $cart);

            return response()->json([
                'status' => 200
            ]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function deleteFormCart(Request $request) {
        try {
            $oldCart = $request->session()->get('cart', null);
            $cart = new Cart($oldCart);
            $cart->deleteItem($request->id);
            $request->session()->put('cart', $cart);

            return response()->json([
                'status' => 200
            ]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function index(Request $request) {
        try {
            $carts = $request->session()->get('cart', null);

            return view('client.shopping-cart')
                ->with('carts', $carts);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function checkVoucher(Request $request) {
        try {
            $voucherCode = $request->voucher;
            $isExist = Voucher::where('code', $voucherCode)
                ->where('start_at', '<=', Carbon::now()->toDateString())
                ->where('end_at', '>=', Carbon::now()->toDateString())
                ->where('is_used', false)
                ->where('isDelete', false)
                ->first();

            return $isExist == NULL 
                ? response()->json(['status' => 404])
                : response()->json(['status' => 200, 'voucher' => $isExist]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function payment(Request $request) {
        try {
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
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function paymentProcess(PaymentRequest $request) {
        try {
            $checkResult = $this->checkQuantity();
            if ($checkResult['status'] == 0) {
                return redirect()
                    ->route('shoppingCart')
                    ->with(
                        'cart-error', 
                        $checkResult['availableQty'] == '0' 
                            ? $checkResult['product'] .  ' hiện tại đã hết hàng'
                            : $checkResult['product'] .  ' chỉ còn ' . $checkResult['availableQty'] . ' ' . $checkResult['unit']);
            }

            if ($request->paymentType == 'CreditCard') {
                $card = Card::where('number', $request->cardNumber)
                            ->where('cvc', $request->secretNumber)
                            ->first();
                if ($card == null) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('payment-error', 'Thẻ tín dụng không hợp lệ, vui lòng kiểm tra lại.');
                }
            }

            $carts = Session::get('cart')->items;
            $totalAmount = $this->paymentCalculation($carts);

            if ($request->voucher != NULL) {
                $voucher = Voucher::where('code', $request->voucher)
                    ->where('start_at', '<=', Carbon::now()->toDateString())
                    ->where('end_at', '>=', Carbon::now()->toDateString())
                    ->where('is_used', false)
                    ->where('isDelete', false)
                    ->first();
                if ($voucher != NULL) {
                    $totalAmount['totalPay'] -= $voucher->discount;   
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('payment-voucher-error', 'Voucher không hợp lệ hoặc đã hết hạn');
                }
            }

            $bill = Bill::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'notes' => $request->notes ?? '',
                'status' => $this->BILL_STATUS['IN_PROCESS'],
                'totalPrice' => $totalAmount['totalPrice'],
                'totalDiscount' => $totalAmount['totalDiscount'],
                'shippingCost' => $totalAmount['totalShippingCost'],
                'totalPay' => $totalAmount['totalPay'],
                'voucher_id' => $voucher->id ?? null,
                'method' => $request->paymentType,
                'card_id' => $card->id ?? null,
                'customer_id' => Auth::user()->id,
            ]);

            if (isset($voucher)) {
                $voucher->is_used = true;
                $voucher->save();
            }

            foreach($carts as $key => $value)
            {
                $bill_detail = BillDetail::create([
                    'bill_id' => $bill->id,
                    'product_id' => $key,
                    'quantity' => $value['qty'],
                    'unit_price' => $value['item']->price,
                ]);

                $product = Product::find($key);
                $product->sold += $value['qty'];
                $product->save();
            }
            
            // send invoice to customer email
            $customer = Customer::where('id', Auth::user()->id)->firstOrFail();
            $customer->notify(new PaymentInvoiceNotification($carts, $bill, isset($voucher) ? $voucher : NULL));
            
            Session::forget('cart');
            return redirect()->route('billDetail', $bill->id);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function checkProductQuantity() {
        try {
            $checkResult = $this->checkQuantity();
            return $checkResult['status'] == 1 
                ? response()->json(['isEnough' => true])
                : response()->json([
                    'isEnough' => false, 
                    'product' => $checkResult['product'], 
                    'unit' => $checkResult['unit'],
                    'remaining' => $checkResult['availableQty'],
                    'missing' => $checkResult['missingQty'],
                ]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    private function checkQuantity() {
        $carts = Session::get('cart')->items;
        foreach($carts as $key => $value)
        {
            $product = Product::find($key);
            $reQuantity = $product->quantity - $product->sold;

            if ($reQuantity < $value['qty']) {
                //1 mean enough quantity for all selected products - 0 mean have at least one product is not enough quantity
                return [
                    'status' => 0,
                    'product' => $product->name,
                    'unit' => $product->category_id == 6 ? 'Combo' : 'Kg',
                    'availableQty' => $reQuantity,
                    'missingQty' => $value['qty'] - $reQuantity,
                ];
            }
        }

        return [
            'status' => 1,
        ];
    }


    private function paymentCalculation($carts) {
        $totalPrice = 0;
        $totalDiscount = 0;
        $shippingCost = $this->SHIPPING_COST;

        foreach($carts as $c) {
            $qty = $c['qty'];
            $price = $c['item']->price;
            $discount = $c['item']->discount;

            $totalPrice += ($qty * $price);
            if ($discount != NULL) {
                $finalPrice = $price - ($price * (float)$discount/100);
                $totalDiscount += ($price - $finalPrice) * $qty;
            }
        }

        return [
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'totalShippingCost' => $shippingCost,
            'totalPay' => $totalPrice + $shippingCost - $totalDiscount
        ];
    }
}
