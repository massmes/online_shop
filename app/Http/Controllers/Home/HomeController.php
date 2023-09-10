<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Banner::where('type', 'slider')->where('is_active', 1)->orderBy('priority')->get();
        $indexTopBanners = Banner::where('type', 'index-top')->where('is_active', 1)->orderBy('priority')->get();
        $indexBottomBanners = Banner::where('type', 'index-bottom')->where('is_active', 1)->orderBy('priority')->get();

        $products = Product::where('is_active', 1)->get()->take(15);


//        $productsd = Product::where('is_active', 1)->get()->take(6);
//        $jsonenc = json_encode($productsd);
//       $jsondc= json_decode($jsonenc)[2]->price_check->price;






        return view('home.index', compact('sliders', 'indexTopBanners', 'indexBottomBanners', 'products'));
    }
}
