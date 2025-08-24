<?php

namespace App\Http\Controllers;

use App\Models\FeedBackModel;
use App\Models\ProductGroupModel;
use App\Models\ProductsModel;

class LandingController extends Controller
{
    public function index(){
          $products = ProductsModel::with([
                'ProductGroupCode:id,code,value'
                ])
                ->select('id', 'product_name','product_code', 'price', 'product_description', 'product_image', 'product_group_code')
                ->orderBy('product_group_code', 'DESC')
                ->get();
//          dd($products->toArray());
          $feedBack = FeedBackModel::where('message', '!=', null)->orderBy('created_at', 'DESC')->get();
            return view('home', compact('products', 'feedBack'));
    }
}
