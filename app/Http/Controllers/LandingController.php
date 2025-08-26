<?php

namespace App\Http\Controllers;

use App\Models\FeedBackModel;
use App\Models\ProductGroupModel;
use App\Models\ProductsModel;

class LandingController extends Controller
{
    public function index(){
          $products = ProductsModel::join('product_groups', 'products.product_group_code', '=', 'product_groups.code')
                ->select('products.*', 'product_groups.value')
                ->orderBy('product_groups.value', 'DESC')
                ->get();
//          dd($products->toArray());
          $feedBack = FeedBackModel::where('message', '!=', null)->orderBy('created_at', 'DESC')->get();
            return view('home', compact('products', 'feedBack'));
    }
}
