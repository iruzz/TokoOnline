<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\FeaturedGroup;

class DashboardController extends Controller
{
   public function index(Request $request) {
     $categorys = Category::withCount([
      'product' => function($query) {
         $query->active();
       }])->get();

     $items = Product::active()->get();
        
     $newArrivals = Product::active()->newArrival()->get();

     $featureds = FeaturedGroup::active()->withCount(['product' => function($q) {
         $q->active();
     }])->get();

     $trendings = Product::active()->isTrending()->get();
     return view('welcome', compact('categorys', 'items', 'featureds', 'newArrivals', 'trendings'));
   }


}
