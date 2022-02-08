<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Http\Requests\CreateVoucherRequest;

class AdminVoucherController extends Controller
{
    public function index() {
        try {
            $vouchers = Voucher::selectRaw('code, start_at, end_at, discount, COUNT(id) as quantity, COUNT(case is_used when true then 1 else null end) as used, 
                                                    (COUNT(id) - COUNT(case is_used when true then 1 else null end)) as remain')
                            ->where('isDelete', false)
                            ->groupBy('code', 'start_at', 'end_at', 'discount')
                            ->get();

            return view('admin.voucher-page')
                    ->with('vouchers', $vouchers);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function detail($code) {
        try {
            $voucher = Voucher::selectRaw('code, start_at, end_at, discount, COUNT(id) as quantity, COUNT(case is_used when true then 1 else null end) as used, 
                                                    (COUNT(id) - COUNT(case is_used when true then 1 else null end)) as remain')
                            ->where('isDelete', false)
                            ->where('code', $code)
                            ->groupBy('code', 'start_at', 'end_at', 'discount')
                            ->first();

            if (!$voucher) { return redirect()->route('voucherManagement'); }

            return view('admin.voucher-info')
                    ->with('voucher', $voucher);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function create() {
        return view('admin.voucher-create');
    }

    public function createProcess(CreateVoucherRequest $request) {
        try {
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
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function delete($code) {
        try {
            $voucher = Voucher::where('code', $code)
                        ->update(['isDelete' => true]);

            return redirect()->route('voucherManagement');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }
}
