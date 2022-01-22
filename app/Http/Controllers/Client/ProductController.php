<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RatingRequest;

class ProductController extends Controller
{
    private $ITEMS_PER_PAGE = 9;
    public function detail($id) {
        try {
            $product = Product::with(['image', 'avgRating', 'comment' => function($c) {
                $c->where('is_deleted', false);
            }])
                ->get()
                ->where('isDelete', '=', false)
                ->find($id);

            $relative = Product::with(['main_pic', 'avgRating'])
                ->where('category_id', $product->category_id)
                ->where('isDelete', '=', false)
                ->where('product.id','!=',$id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
                
            return view('client.product-detail')
                ->with('detail', $product)
                ->with('relative', $relative);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function index(Request $request) {
        try {
            if ($request->has('filter')) {
                $queryParams = $request->query('filter');
                $queryString = '?filter=' . $queryParams . '&page=';
                $products = $this->getFilterProducts($queryParams);
            }
            else {
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->orderBy('created_at', 'DESC')
                    ->paginate($this->ITEMS_PER_PAGE);

                $queryString = '?page=';
            }
            
            return view('client.product-page')
                ->with('products', $products)
                ->with('queryString', $queryString);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function search(Request $request) {
        try {
            $searchKey = $request->query('key');

            $products = Product::with(['main_pic', 'avgRating'])
                ->where('isDelete', '=', false)
                ->where('name', 'like', '%' . $searchKey . '%')
                ->orderBy('created_at', 'DESC')
                ->paginate($this->ITEMS_PER_PAGE);

            return view('client.special-product-page')
                ->with('products', $products)
                ->with('title', 'Tìm kiếm sản phẩm')
                ->with('queryString', '?key=' . $searchKey . '&page=');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function topSales() {
        try {
            $bestSaler = Product::orderBy('sold', 'DESC')
                ->with(['main_pic', 'avgRating'])
                ->where('isDelete', '=', false)
                ->paginate($this->ITEMS_PER_PAGE);

            return view('client.special-product-page')
                ->with('products', $bestSaler)
                ->with('title', 'Sản phẩm bán chạy')
                ->with('queryString', '?page=');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function newProducts() {
        try {
            $newProducts = Product::orderBy('created_at', 'DESC')
                ->with(['main_pic', 'avgRating'])
                ->where('isDelete', '=', false)
                ->paginate($this->ITEMS_PER_PAGE);

            return view('client.special-product-page')
                ->with('products', $newProducts)
                ->with('title', 'Sản phẩm mới')
                ->with('queryString', '?page=');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function flashSales() {
        try {
            $saleProducts = Product::orderBy('discount', 'DESC')
                ->with(['main_pic', 'avgRating'])
                ->where('isDelete', '=', false)
                ->where('discount', '!=', 0)
                ->paginate($this->ITEMS_PER_PAGE);

            return view('client.special-product-page')
                ->with('products', $saleProducts)
                ->with('title', 'Sản phẩm khuyến mãi')
                ->with('queryString', '?page=');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function category(Request $request, $type) {
        try {
            $categoryList = [
                'rau-cu-huu-co' => 1,
                'rau-cu-da-lat' => 2,
                'rau-cu-ngoai-nhap' => 3,
                'trai-cay-da-lat' => 4,
                'trai-cay-ngoai-nhap' => 5,
                'combo-san-pham' => 6
            ];

            if (array_key_exists($type, $categoryList)) {
                if ($request->has('filter')) {
                    $queryParams = $request->query('filter');
                    $queryString = '?filter=' . $queryParams . '&page=';
                    $products = $this->getFilterProducts($queryParams, $categoryList[$type]);
                }
                else {
                    $products = Product::with(['main_pic', 'avgRating'])
                        ->where('isDelete', '=', false)
                        ->where('category_id', $categoryList[$type])
                        ->orderBy('created_at', 'DESC')
                        ->paginate($this->ITEMS_PER_PAGE);
        
                    $queryString = '?page=';
                }
                
                return view('client.product-page')
                    ->with('products', $products)
                    ->with('queryString', $queryString);
            }
            else {
                return redirect()->route('productpage');
            }
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function rating(RatingRequest $request) {
        try {
            $rating = Rating::where('product_id', $request->productId)
                ->where('bill_id', $request->billId)
                ->first();

            if ($rating) {
                return response()->json([
                    'status' => 400
                ]);
            }

            Rating::create([
                'product_id' => $request->productId,
                'bill_id' => $request->billId,
                'star' => $request->rating,
            ]);

            return response()->json([
                'status' => 200
            ]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    private function getFilterProducts($filter, $type = false) {
        switch ($filter) {
            case 'gia-giam-dan':
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->when($type, function ($query, $type) {
                        return $query->where('category_id', $type);
                    })
                    ->select(DB::raw('id, name, price, discount, sold, price - (price * coalesce(cast(discount as FLOAT), 0)/100) as "finalPrice"'))
                    ->orderBy('finalPrice', 'DESC')
                    ->paginate($this->ITEMS_PER_PAGE);
                break;
            case 'gia-tang-dan':
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->when($type, function ($query, $type) {
                        return $query->where('category_id', $type);
                    })
                    ->select(DB::raw('id, name, price, discount, sold, price - (price * coalesce(cast(discount as FLOAT), 0)/100) as "finalPrice"'))
                    ->orderBy('finalPrice', 'ASC')
                    ->paginate($this->ITEMS_PER_PAGE);
                break;
            case 'a-z':
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->when($type, function ($query, $type) {
                        return $query->where('category_id', $type);
                    })
                    ->orderBy('name', 'ASC')
                    ->paginate($this->ITEMS_PER_PAGE);
                break;
            case 'z-a':
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->when($type, function ($query, $type) {
                        return $query->where('category_id', $type);
                    })
                    ->orderBy('name', 'DESC')
                    ->paginate($this->ITEMS_PER_PAGE);
                break;
            default: 
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->when($type, function ($query, $type) {
                        return $query->where('category_id', $type);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate($this->ITEMS_PER_PAGE);
        }

        return $products;
    }
}
