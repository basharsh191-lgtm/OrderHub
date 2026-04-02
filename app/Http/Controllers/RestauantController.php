<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\restaurant;
use Illuminate\Http\Request;

class RestauantController extends Controller
{
   public function index()
   {
    $restaurant=restaurant::all();
    return response()->json($restaurant, 200);
   }
   public function showProduct($id)
   {
    $product=Product::findOrFail($id);
    return response()->json(['message'=>'the prodect ','data'=>$product], 200);
   }
}
