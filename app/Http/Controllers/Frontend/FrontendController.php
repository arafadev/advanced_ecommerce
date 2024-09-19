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
    public function shop($slug = null)
    {
        return view('frontend.shop', compact('slug'));
    }
    public function shop_tag($slug = null)
    {
        return view('frontend.shop_tag', compact('slug'));
    }
    public function product($slug)
    {
        $product = Product::with('media', 'category', 'tags', 'reviews')->withAvg('reviews', 'rating')
        ->whereSlug($slug)
        ->Active()
        ->HasQuantity()
        ->ActiveCategory()
        ->firstOrFail();

        $relatedProducts = Product::with('firstMedia')->whereHas('category', function ($query) use ($product) {
            $query->whereId($product->product_category_id);
            $query->whereStatus(true);
        })->inRandomOrder()->Active()->HasQuantity()->take(4)->get();
        
        return view('frontend.product', get_defined_vars());
    }   



    public function cart()
    {
        return view('frontend.cart');
    }
    public function wishlist()
    {
        return view('frontend.wishlist');
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }



}
