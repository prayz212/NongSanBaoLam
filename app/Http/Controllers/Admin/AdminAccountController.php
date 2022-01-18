<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Models\Customer;
use DB;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index() {
        $customers = Customer::with(['totalPay', 'totalBill'])
            ->where('isDelete', false)
            ->get();
      
        return view('admin.account-page')
                ->with('customers', $customers);
    }

    public function accountInfo($id) {
        $customer = Customer::with(['totalPay', 'totalBill'])
            ->where('isDelete', false)
            ->find($id);

        if ($customer == NULL) {
            return redirect()->route('accountManagement');
        }

        return view('admin.account-info')
                ->with('customer', $customer);
    }

    public function update($id) {
        $customer = Customer::select('customer.*', 
                        DB::raw('SUM(bill.totalPay) As totalPay'),
                        DB::raw('COUNT(bill.id) As totalBill'))
                        ->leftJoin('bill', 'customer.id', '=', 'bill.customer_id')
                        ->groupBy('customer.id')
                        ->where('customer.id', $id)
                        ->where('isDelete', false)
                        ->first();

        if ($customer == NULL) {
            return redirect()->route('accountManagement');
        }
                        
        return view('admin.account-edit')
                ->with('customer', $customer)
                ->with('page', 'edit');
    }

    public function updateProcess($id, UpdateInfoRequest $request) {
        $customer = Customer::find($id);

        if ($customer->email != $request->email) {
            $isExistEmail = Customer::where('email', $request->email)
                ->exists();
        
            if ($isExistEmail) {
                return redirect()->back()->withInput()->with('account-noti-error', 'Email đã tồn tại');
            }
        }

        $customer->fullname = $request->fullname;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('adminAccountInfo', [$id]);
    }

    public function create() {
        return view('admin.account-edit')
                ->with('customer', NULL)
                ->with('page', 'create');
    }

    public function createProcess(CreateAccountRequest $request) {
        $isExistUsername = Customer::where('username', $request->username)
            ->exists();
    
        if ($isExistUsername) {
            return redirect()->back()->withInput()->with('account-noti-error', 'Tên tài khoản đã tồn tại');
        }

        $isExistEmail = Customer::where('email', $request->email)
            ->exists();
    
        if ($isExistEmail) {
            return redirect()->back()->withInput()->with('account-noti-error', 'Email đã tồn tại');
        }
    
        $customer = Customer::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return redirect()->route('adminAccountInfo', [$customer->id]);
    }

    public function delete($id) {
        $customer = Customer::find($id);

        $customer->isDelete = true;
        $customer->save();

        return redirect()->route('accountManagement');
    }
}
