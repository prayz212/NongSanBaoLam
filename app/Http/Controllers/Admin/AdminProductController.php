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
use JD\Cloudder\Facades\Cloudder;
use DB;

class AdminProductController extends Controller
{
    public function index() {
        try {
            $products = Product::with(['category', 'avgRating'])
                ->where('isDelete', false)->get();
            
            return view('admin.product-page')
                ->with('products', $products);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function detail($id) {
        try {
            $product = Product::with('main_pic', 'category', 'avgRating', 'image')
                ->where('isDelete', false)
                ->find($id);

            if (!$product) {
                return redirect()->route('productManagement');
            }

            return view('admin.product-info')
                ->with('product', $product);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function delete($id) {
        try {
            $product = Product::where('isDelete', false)
                ->find($id);

            $images = Image::where('product_id', $id)
                ->pluck('public_id')
                ->toArray();

            Cloudder::destroyImages($images);

            DB::table('image')
                ->where('product_id', $id)
                ->delete();

            $product->isDelete = true;
            $product->save();

            return redirect()->route('productManagement');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function update($id) {
        try {
            $product = Product::with('category', 'avgRating', 'image')
                ->where('isDelete', false)
                ->find($id);

            $categories = Category::get();

            return view('admin.product-edit')
                ->with('product', $product)
                ->with('categories', $categories);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function stockIn() {
        try {
            $categories = Category::get();
            
            return view('admin.product-stock-in')
                ->with('categories', $categories);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function productsByCategory(Request $request) {
        try {
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
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function stockInProcess(Request $request) {
        try {
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
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function create() {
        try {
            $categories = Category::get();
            return view('admin.product-create')
                ->with('categories', $categories);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function createProcess(CreateProductRequest $request) {
        try {
            //check limit size of uploaded images
            $isAllValid = $this->checkLimitSize($request->file('images'));
            if ($isAllValid == false) {
                return redirect()->back()->withInput()->with('upload-image-error', 'Ảnh sản phẩm có dung lượng tối đa là 2Mb');
            }
            
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->type,
                'price' => $request->price,
                'quantity' => 0,
                'discount' => $request->discount != null ? $request->discount : null,
            ]);

            //upload to Cloudinary
            $product_id = $product->id;
            $uploadedImages = $this->uploadImages($request->file('images'), $product_id);
            $images = Image::insert($uploadedImages);

            return redirect()->route('productInfo', $product_id);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function updateProcess(UpdateProductRequest $request) {
        try {
            //check limit size of uploaded images
            if($request->file('images')) {
                $isAllValid = $this->checkLimitSize($request->file('images'));
                if ($isAllValid == false) {
                    return redirect()->back()->withInput()->with('upload-image-error', 'Ảnh sản phẩm có dung lượng tối đa là 2Mb');
                }
            }

            $product = Product::find($request->id);
            $product->name = $request->name;
            $product->category_id = $request->type;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->description = $request->description;
            $product->save();

            //remove from Cloudinary
            if ($request->removed) {
                $removedImages = array_filter(explode("|", $request->removed));
                $images = Image::whereIn('url', $removedImages)
                    ->pluck('public_id')
                    ->toArray();
                
                Cloudder::destroyImages($images);

                DB::table('image')
                    ->whereIn('url', $removedImages)
                    ->delete();
            }

            //upload new images to Cloudinary
            if($request->file('images')) {
                $product_id = $product->id;
                $uploadedImages = $this->uploadImages($request->file('images'), $product_id);
                $images = Image::insert($uploadedImages);
            }
          
            return redirect()->route('productInfo', $product->id);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    private function checkLimitSize($images) { 
        //Reture true if all image valid
        //Otherwise return false
        foreach($images as $image)
        {
            $size = $image->getSize();
            if ($size > 2097152) {
                return false;
            }
        }

        return true;
    }

    private function uploadImages($images, $product_id) {
        $now = Carbon::now()->timestamp;
        foreach($images as $image)
        {
            $file = $image->getClientOriginalName();
            $name = pathinfo($file, PATHINFO_FILENAME) . '_' . $now;

            Cloudder::upload($image, 'NongSanBaoLam/' . $name, array(
                'overwrite' => FALSE,
                "resource_type" => 'image',
                'use_filename' => true,
                'unique_filename' => true,
            ));

            $result = Cloudder::getResult();
            $data[] = ['name' => $name, 'url' => $result['secure_url'], 'product_id' => $product_id, 'public_id' => $result['public_id']];
        }

        return $data;
    }
}
