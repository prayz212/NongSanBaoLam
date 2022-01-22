<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function index() {
    try {
        $bestSaler = Product::orderBy('sold', 'DESC')
          ->with(['main_pic', 'avgRating'])
          ->get()
          ->where('isDelete', '=', false)
          ->take(8);

        $newProducts = Product::orderBy('created_at', 'DESC')
          ->with(['main_pic', 'avgRating'])
          ->get()
          ->where('isDelete', '=', false)
          ->take(8);

        return view('client.index')
              ->with('bestSaler', $bestSaler)
              ->with('newProducts', $newProducts);
      }
      catch(\Exception $error){
          return view('error')
              ->with('errorMessages', $error->getMessage())
              ->with('returnUrl', url()->previous());
      }
  }

  public function introduce()
  {
    return view('client.introduce');
  }
}

