<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillDetail;
use Carbon\Carbon;

class AdminBillController extends Controller
{
    public function index() {
        try {
            $bills = Bill::all();

            return view('admin.bill-page')
                    ->with('bills', $bills);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function billDetail($id) {
        try {
            $bill = Bill::with([
                    'bill_detail',
                    'bill_detail.item.category',
                    'voucher',
                    'card'])
                    ->find($id);

            return view('admin.bill-detail')
                    ->with('bill', $bill);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function billUpdateStatus(Request $request) {
        try {
            $bill = Bill::where('id', $request->id)->firstOrFail();
            $bill->status = $request->status;

            if ($request->status == 'Đã giao') {        
                $bill->delivery_at = Carbon::now()->toDateString();
                $date = Carbon::parse($request->delivery_at)->format('d/m/Y');
            } else {
                $bill->delivery_at = NULL;
            }
            $bill->save();

            return response()->json(['status' => 200, 'delivery_at' => $date ?? NULL, 'bill_status' => $bill->status]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }
}
