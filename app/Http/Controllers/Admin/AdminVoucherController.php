<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Http\Requests\CreateVoucherRequest;

class AdminVoucherController extends Controller
{
    public function index() {
        // Groupby voucher code and count quantity of each code
        $vouchers_quantity = Voucher::selectRaw('*, COUNT(id) as quantity')
                        ->groupBy('code')
                        ->get();

        // Groupby voucher code and number of used
        $vouchers_numOfUsed = Voucher::selectRaw('*, COUNT(id) as used')
                        ->where('isUsed', true)
                        ->groupBy('code')
                        ->get();

        // calculation remain and used of each voucher code                
        foreach ($vouchers_quantity as $voucher1) {
            foreach ($vouchers_numOfUsed as $voucher2) {
                if ($voucher1->code == $voucher2->code) {
                    $voucher1->used = $voucher2->used;
                    $voucher1->remain = $voucher1->quantity - $voucher2->used;
                }
            }
        }

        return view('admin.voucher-page')
                ->with('vouchers', $vouchers_quantity);
    }

    public function detail($code) {
        $voucher_quantity = Voucher::selectRaw('*, COUNT(id) as quantity')
                        ->where('code', $code)
                        ->groupBy('code')
                        ->get();

        $voucher_numOfUsed = Voucher::selectRaw('*, COUNT(id) as used')
                        ->where('code', $code)
                        ->where('isUsed', true)
                        ->groupBy('code')
                        ->get();

        if (!$voucher_numOfUsed) {
            $voucher_quantity->first()->used = $voucher_numOfUsed->first()->used;
            $voucher_quantity->first()->remain = $voucher_quantity->first()->quantity - $voucher_numOfUsed->first()->used;
        } else {
            $voucher_quantity->first()->used = 0;
            $voucher_quantity->first()->remain = $voucher_quantity->first()->quantity;
        }

        return view('admin.voucher-info')
                ->with('voucher', $voucher_quantity->first());
    }

    public function create() {
        return view('admin.voucher-create');
    }

    public function createProcess(CreateVoucherRequest $request) {
        $isExistCode = Voucher::where('code', $request->code)
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
                    ->where('isUsed', false)
                    ->delete();

        return redirect()->route('voucherManagement');
    }
}
