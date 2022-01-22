<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index() {
        try {
            $customers = Customer::with(['totalPay', 'totalBill'])
                ->where('isDelete', false)
                ->get();
      
            return view('admin.account-page')
                    ->with('customers', $customers);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function accountInfo($id) {
        try {
            $customer = Customer::with(['totalPay', 'totalBill'])
                ->where('isDelete', false)
                ->find($id);

            if ($customer == NULL) {
                return redirect()->route('accountManagement');
            }

            return view('admin.account-info')
                    ->with('customer', $customer);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function update($id) {
        try {
            $customer = Customer::with(['totalPay', 'totalBill'])
                ->where('isDelete', false)
                ->find($id);

            if ($customer == NULL) {
                return redirect()->route('accountManagement');
            }
                            
            return view('admin.account-edit')
                    ->with('customer', $customer);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function updateProcess($id, UpdateInfoRequest $request) {
        try {
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
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function create() {
        return view('admin.account-create');
    }

    public function createProcess(CreateAccountRequest $request) {
        try {
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
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function delete($id) {
        try {
            $customer = Customer::find($id);

            $customer->isDelete = true;
            $customer->save();

            return redirect()->route('accountManagement');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }
}
