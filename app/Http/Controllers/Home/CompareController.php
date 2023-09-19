<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class CompareController extends Controller
{
    public function add(Product $product)
    {
        if (session()->has('compareProducts')) {

            if (in_array($product->id, session()->get('compareProducts'))) {

                toastr()->warning('محصول مورد نظر از قبل به لیست مقایسه کالاها اضافه گردیده', 'کاربر گرامی', ['timeOut' => 20000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
                return redirect()->back();
            }

            session()->push('compareProducts', $product->id);

        } else {
            session()->put('compareProducts', [$product->id]);
        }

        toastr()->success('محصول مورد نظر به لیست مقایسه کالاهااضافه گردید', 'کاربر گرامی', ['timeOut' => 20000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);
        return redirect()->back();
    }

    public function index()
    {

        if (session()->has('compareProducts')) {

            $products = Product::findOrFail(session()->get('compareProducts'));

            return view('home.compare.index', compact('products'));

        }

        toastr()->warning('ابتدا محصولی را به لیست مقایسه محصول اضافه کنید', 'کاربر گرامی', ['timeOut' => 20000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
        return redirect()->back();

    }

//    public function remove($id)
//    {
//        if (session()->has('compareProducts')) {
//
//            foreach (session()->get('compareProducts') as $key => $item) {
//                if ($item == $id) {
//                    session()->pull('compareProducts.' . $key);
//                }
//            }
//
//            if (session()->get('compareProducts') == []) {
//                session()->forget('compareProducts');
//                return redirect()->route('home.index');
//
//            }
//            return redirect()->route('home.compare.index');
//        }
//        toastr()->warning('ابتدا محصولی را به لیست مقایسه محصول اضافه کنید', 'کاربر گرامی', ['timeOut' => 20000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
//        return redirect()->back();
//    }


    public function remove($id)
    {
        if (session()->has('compareProducts')) {
            $key = array_search($id, session()->get('compareProducts'));

            if ($key !== false) {
                session()->forget('compareProducts.' . $key);
            }

            if (session()->get('compareProducts') == []) {
                session()->forget('compareProducts');
                return redirect()->route('home.index');
            }

            return redirect()->route('home.compare.index');
        }

        toastr()->warning('ابتدا محصولی را به لیست مقایسه محصول اضافه کنید', 'کاربر گرامی', ['timeOut' => 20000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
        return redirect()->back();
    }


}
