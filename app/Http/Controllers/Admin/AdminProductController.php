<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Carbon\Carbon;

class AdminProductController extends Controller
{
    public function index() {
        $products = Product::with(['category', 'avgRating'])
            ->where('isDelete', false)->get();
        
        return view('admin.product-page')
            ->with('products', $products);
    }

    public function detail($id) {
        $product = Product::with('main_pic', 'category', 'avgRating', 'image')
            ->where('isDelete', false)
            ->find($id);

        return view('admin.product-info')
            ->with('product', $product);
    }

    public function delete($id) {
        $product = Product::where('isDelete', false)
            ->find($id);
        
        $product->isDelete = true;
        $product->save();

        return redirect()->route('productManagement');
    }

    public function update($id) {
        $product = Product::with('category', 'avgRating', 'image')
            ->where('isDelete', false)
            ->find($id);

        $categories = Category::get();

        return view('admin.product-edit')
            ->with('product', $product)
            ->with('categories', $categories);
    }

    public function stockIn() {
        $categories = Category::get();
        
        return view('admin.product-stock-in')
            ->with('categories', $categories);
    }

    public function productsByCategory(Request $request) {
        if ($request->has('category')) {
            $products = Product::where('category_id', $request->query('category'))
                ->where('isDelete', false)
                ->select('id', 'name')
                ->get();
            
            $response =  response()->json([
                'status' => 200,
                'products' => $products
            ]);
        } else {
            $response = response()->json([
                'status' => 400
            ]);
        }

        return $response;
    }

    public function stockInProcess(Request $request) {
        if ($request->has('category') && $request->has('product') && $request->has('quantity')) {
            $product = Product::where('category_id', $request->category)
                ->where('isDelete', false)
                ->where('id', $request->product)
                ->first();
            
            $product->quantity += $request->quantity;
            $product->save();
            
            $response =  response()->json([
                'status' => 200
            ]);
        } else {
            $response = response()->json([
                'status' => 400
            ]);
        }

        return $response;
    }

    public function create() {
        $categories = Category::get();
        return view('admin.product-create')
            ->with('categories', $categories);
    }

    public function createProcess(CreateProductRequest $request) {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->type,
            'price' => $request->price,
            'quantity' => 0,
            'discount' => $request->discount != null ? $request->discount : null,
        ]);

        $product_id = $product->id;
        $now = Carbon::now()->timestamp;
        foreach($request->file('images') as $image)
        {
            $file = $image->getClientOriginalName();
            $name = pathinfo($file, PATHINFO_FILENAME) . '_' . $now;
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $new_name = $name . '.' . $extension;
            $url = public_path() . '/images/uploads/';

            $image->move($url, $new_name);  
            $data[] = ['name' => $new_name, 'url' => $url . $new_name, 'product_id' => $product_id];
        }

        $images = Image::insert($data);

        return redirect()->route('productInfo', $product_id);
    }

    public function updateProcess(Request $request) {
        die('ok');
        // $old_images = Image::where('product_id', $request->id)
        //     ->get();

        // dd([$old_images]);

        // foreach($request->file('images') as $image)
        // {
        //     $name = $image->getClientOriginalName(); 
        //     $data[] = $name;
        // }

        // dd([$old_images, $data]);
    }
}
