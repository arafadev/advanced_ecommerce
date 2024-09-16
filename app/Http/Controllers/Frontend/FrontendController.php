<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function index()
    {

        $product_categories = ProductCategory::whereStatus(1)->whereNull('parent_id')->get();
        return view('frontend.index', get_defined_vars());
    }


    public function cart()
    {
        return view('frontend.cart');
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function product()
    {
        return view('frontend.detail');
    }

    public function shop()
    {
        return view('frontend.shop');
    }
}
