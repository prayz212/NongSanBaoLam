<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $ITEMS_PER_PAGE = 9;
    public function detail($id) {
        $product = Product::with(['image', 'comment', 'avgRating'])
            ->get()
            ->where('isDelete', '=', false)
            ->find($id);

        $relative = Product::with(['main_pic', 'avgRating'])
            ->where('category_id', $product->category_id)
            ->where('isDelete', '=', false)
            ->where('product.id','!=',$id)
            ->limit(4)
            ->get();

        return view('client.product-detail')
            ->with('detail', $product)
            ->with('relative', $relative);
    }

    public function index(Request $request) {
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

    public function search(Request $request) {
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

    public function topSales() {
        $bestSaler = Product::orderBy('sold', 'DESC')
            ->with(['main_pic', 'avgRating'])
            ->where('isDelete', '=', false)
            ->paginate($this->ITEMS_PER_PAGE);

        return view('client.special-product-page')
            ->with('products', $bestSaler)
            ->with('title', 'Sản phẩm bán chạy')
            ->with('queryString', '?page=');
    }

    public function newProducts() {
        $newProducts = Product::orderBy('created_at', 'DESC')
            ->with(['main_pic', 'avgRating'])
            ->where('isDelete', '=', false)
            ->paginate($this->ITEMS_PER_PAGE);

        return view('client.special-product-page')
            ->with('products', $newProducts)
            ->with('title', 'Sản phẩm mới')
            ->with('queryString', '?page=');
    }

    public function flashSales() {
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

    public function category(Request $request, $type) {
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

    private function getFilterProducts($filter, $type = false) {
        switch ($filter) {
            case 'gia-giam-dan':
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->when($type, function ($query, $type) {
                        return $query->where('category_id', $type);
                    })
                    ->select(DB::raw('id, name, price, discount, sold, price - (price * IFNULL(CAST(discount as FLOAT), 0)/100) as finalPrice'))
                    ->orderBy('finalPrice', 'DESC')
                    ->paginate($this->ITEMS_PER_PAGE);
                break;
            case 'gia-tang-dan':
                $products = Product::with(['main_pic', 'avgRating'])
                    ->where('isDelete', '=', false)
                    ->when($type, function ($query, $type) {
                        return $query->where('category_id', $type);
                    })
                    ->select(DB::raw('id, name, price, discount, sold, price - (price * IFNULL(CAST(discount as FLOAT), 0)/100) as finalPrice'))
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
