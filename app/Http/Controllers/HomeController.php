<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function index() {
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

  public function introduce()
  {
    return view('client.introduce');
  }
}

