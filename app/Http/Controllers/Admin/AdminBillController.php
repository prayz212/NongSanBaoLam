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
        $bills = Bill::all();

        return view('admin.bill-page')
                ->with('bills', $bills);
    }

    public function billDetail($id) {
        $bill = Bill::with([
                'bill_detail',
                'bill_detail.item.category',
                'voucher',
                'card'])
                ->find($id);

        return view('admin.bill-detail')
                ->with('bill', $bill);
    }

    public function billUpdateStatus(Request $request) {
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
}
