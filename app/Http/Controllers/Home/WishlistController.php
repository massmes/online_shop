<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Alert;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        if (auth()->check()) {

            if ($product->checkUserWishList(auth()->id())) {
                toastr()->warning('این محصول قبلا به لیست علاقه مندی ها اضافه شده است', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
                return redirect()->back();
            } else {
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                ]);
                toastr()->success('محصول مورد نظر به لیست علاقه مندیهای شما اضافه شد', 'کاربر گرامی ', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);
                return redirect()->back();
            }

        } else {
            toastr()->error('برای افزودن به علاقه مندی ها باید وارد پنل کاربری خود شوید', 'پنل کاربری شما فعال نمیباشد', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();
        }
    }

    public function remove(Product $product)
    {
        if (auth()->check()) {
            $wishlist = Wishlist::where('product_id', $product->id)->where('user_id', auth()->id())->firstOrFail();
            if ($wishlist) {
                Wishlist::where('product_id', $product->id)->where('user_id', auth()->id())->delete();
            }

            toastr()->success(' محصول مورد نظر از لیست علاقه مندی های شما حذف گردید', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center']);
            return redirect()->back();

        } else {
            toastr()->error('برای حذف از علاقه مندی ها باید وارد پنل کاربری خود شوید', 'پنل کاربری شما فعال نمیباشد', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();
        }
    }


    public function usersProfileIndex()
    {
        $wishlist = Wishlist::where('user_id', auth()->id())->get();
        return view('home.users_profile.wishlist', compact('wishlist'));
    }

}
