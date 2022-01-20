<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Http\Requests\CreateVoucherRequest;

class AdminVoucherController extends Controller
{
    public function index() {
        $vouchers = Voucher::selectRaw('code, start_at, end_at, discount, COUNT(id) as quantity, COUNT(case is_used when true then 1 else null end) as used, 
                                                (COUNT(id) - COUNT(case is_used when true then 1 else null end)) as remain')
                        ->where('isDelete', false)
                        ->groupBy('code', 'start_at', 'end_at', 'discount')
                        ->get();

        return view('admin.voucher-page')
                ->with('vouchers', $vouchers);
    }

    public function detail($code) {
        $voucher = Voucher::selectRaw('code, start_at, end_at, discount, COUNT(id) as quantity, COUNT(case is_used when true then 1 else null end) as used, 
                                                (COUNT(id) - COUNT(case is_used when true then 1 else null end)) as remain')
                        ->where('isDelete', false)
                        ->where('code', $code)
                        ->groupBy('code', 'start_at', 'end_at', 'discount')
                        ->first();

        return view('admin.voucher-info')
                ->with('voucher', $voucher);
    }

    public function create() {
        return view('admin.voucher-create');
    }

    public function createProcess(CreateVoucherRequest $request) {
        $isExistCode = Voucher::where('code', $request->code)
                            ->where('isDelete', false)
                            ->first();

        if ($isExistCode) {
            return redirect()->back()->withInput()
                            ->with('voucher-noti-error', 'Mã voucher đã tồn tại');
        }

        if ($request->start_at > $request->end_at) {
            return redirect()->back()->withInput()
                            ->with('voucher-noti-error', 'Ngày bắt đầu phải trước ngày kết thúc');
        }

        for($i = 0; $i < $request->quantity; $i++) {
            $vouchers[] = [
                'code' => $request->code,
                'discount' => $request->discount,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
            ];
        }

        Voucher::insert($vouchers);

        return redirect()->route('voucherInfo', [$request->code]);
    }

    public function delete($code) {
        $voucher = Voucher::where('code', $code)
                    ->update(['isDelete' => true]);

        return redirect()->route('voucherManagement');
    }
}
