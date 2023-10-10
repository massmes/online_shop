<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\User;
use App\Models\UserAddress;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Alert;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qtybutton' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);
        $productVariation = ProductVariation::findOrFail(json_decode($request->variation)->id);


        if ($request->qtybutton > $productVariation->quantity) {
            toastr()->error('تعداد محصول وارد شده از حد مجاز فراتر است', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();
        }


        $rowId = $product->id . '-' . $productVariation->id;

        if (\Cart::get($rowId) == null) {
            \Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
                'quantity' => $request->qtybutton,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product
            ));
        } else {
            toastr()->warning('محصول مورد نظر از قبل به سبد خرید اضافه گردید است', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();
        }


        toastr()->success('محصول مورد نظر به سبد خرید اضافه گردید', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);
        return redirect()->back();
    }

    public function index()
    {
        return view('home.cart.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'qtybutton' => 'required',
        ]);

        foreach ($request->qtybutton as $rowId => $quantity) {
            $item = \Cart::get($rowId);
            if ($quantity > $item->attributes->quantity) {
                toastr()->error('تعداد محصول وارد شده از حد مجاز فراتر است', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
                return redirect()->back();
            }

            \Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity,
                ),
            ));
        }

        toastr()->success('سبد خرید شما ویرایش شد', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);
        return redirect()->back();
    }

    public function remove($rowId)
    {
        \Cart::remove($rowId);
        toastr()->success('محصول مورد نظر از سبد خرید شما حذف شد', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);
        return redirect()->back();
    }

    public function clear()
    {
        \Cart::clear();
        toastr()->warning('سبد خرید شما خالی از محصول شد', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
        return redirect()->back();
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        if (!auth()->check()) {
            toastr()->error('برای استفاده از کد تخفیف نیاز به ورود و یا ثبت نام در سایت است', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();
        }

        $result = checkCoupon($request->code);

        if (array_key_exists('error', $result)) {
            toastr()->error($result['error'], 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
        } else {
            toastr()->success($result['success'], 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);

        }
        return redirect()->back();
    }

    function checkout()
    {
        if (!auth()->check()) {
            toastr()->warning('برای ادامه فرایند خرید باید لاگین باشید', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);

            return redirect()->route('login');
        } else {

            if (\Cart::isEmpty()) {
                toastr()->warning('متاسفانه سبد خرید شما خالی میباشد', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
                return redirect()->route('home.index');
            }

            $addresses = UserAddress::where('user_id', auth()->id())->get();
            $provinces = Province::all();
            return view('home.cart.checkout', compact('provinces', 'addresses'));
        }
    }

    public function usersProfileIndex()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('home.users_profile.orders', compact('orders'));
    }

}
