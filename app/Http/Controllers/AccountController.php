<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateInfoRequest;
use App\Models\Customer;
use App\Models\Bill;

class AccountController extends Controller
{
    public function index() {
        $customer = Auth::user();

        return view('client.info-page')
            ->with('customer', $customer);
    }

    public function updateInfo(UpdateInfoRequest $request) {
        $customer = Customer::find($request->id);

        if ($customer->email != $request->email) {
            $isExistEmail = Customer::where('email', $request->email)
                ->exists();
        
            if ($isExistEmail) {
                return redirect()->back()->withInput()->with('info-noti-error', 'Email đã tồn tại');
            }
        }

        $customer->fullname = $request->fullname;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('infopage')->with('info-noti-success', 'Cập nhật thành công');
    }

    public function billDetail($id) {
        $bill = Bill::with([
            'rating',
            'bill_detail',
            'bill_detail.item',
            'bill_detail.item.main_pic',
            'bill_detail.item.category',
            'voucher',
            'card'
        ])
        ->where('customer_id', Auth::user()->id)
        ->find($id);

        return view('client.bill-detail')
            ->with('bill', $bill);
    }

    public function bills() {
        $bills = Bill::where('customer_id', Auth::user()->id)
            ->get();
        return view('client.bill-page')
            ->with('bills', $bills);
    }
}
