<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use Carbon\Carbon;

class AdminHomeController extends Controller
{
    private $HEADER = array(
        'Content-Type' => 'application/json; charset=UTF-8',
        'charset' => 'utf-8'
    );

    public function index() {
        return view('admin.dashboard');
    }

    public function orderAnalysis(Request $request) {
        try {
            if ($request->type) {
                switch($request->type) {
                    case 'week':
                        $start = Carbon::now()->startOfWeek();
                        $end = Carbon::now()->endOfWeek();
                        break;
                    case 'month':
                        $start = Carbon::now()->startOfMonth();
                        $end = Carbon::now()->endOfMonth();
                        break;
                    case 'quarter':
                        $start = Carbon::now()->firstOfQuarter();
                        $end = Carbon::now()->lastOfQuarter();
                        break;
                }
                
                $bills = Bill::whereBetween('created_at', [$start, $end])
                    ->selectRaw('COUNT(id) as total, date(created_at) as dates')
                    ->groupBy('dates')
                    ->get();
                
                return response()->json([
                    'status' => 200, 
                    'data' => $bills, 
                    'mode' => $request->type
                ]);
            }
            else {
                return response()->json(['status' => 400, 'errorMessages' => 'Missing required fields']);
            }        
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function productAnalysis(Request $request) {
        try {
            $products = BillDetail::with(['item' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->selectRaw('product_id, sum(quantity) as total')
                ->groupBy('product_id')
                ->get();

            return response()->json([
                'status' => 200, 
                'data' => $products
            ], 200, $this->HEADER, JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function billStatusAnalysis(Request $request) {
        try {
            $bills = Bill::selectRaw('status, count(id) as total')
                ->groupBy('status')
                ->get();

            return response()->json([
                'status' => 200, 
                'data' => $bills
            ], 200, $this->HEADER, JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }
}
