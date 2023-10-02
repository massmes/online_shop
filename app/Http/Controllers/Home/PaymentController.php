<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Alert;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
            'address_id' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('ابتدا محصولی را به لیست مقایسه محصول اضافه کنید', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();
        }


        $checkCart = $this->checkCart();
        if (array_key_exists('error', $checkCart)) {
            toastr()->error($checkCart['error'], 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->route('home.index');
        }


        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            toastr()->error($amounts['error'], 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->route('home.index');
        }

        $api = 'test';
        $amount = $amounts['paying_amount'];
        $redirect = route('home.payment_verify');
        $result = $this->send($api, $amount, $redirect);
        $result = json_decode($result);
        if ($result->status) {

            $createOrder = $this->createOrder($request->address_id, $amounts, $result->token, 'pay');
            if (array_key_exists('error', $createOrder)) {
                toastr()->error($createOrder['error'], 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
                return redirect()->back();
            }

            $go = "https://pay.ir/pg/$result->token";
            return redirect()->to($go);
        } else {
            toastr()->error($result->errorMessage, 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();
        }
    }


    public function paymentVerify(Request $request)
    {
        $api = 'test';
        $token = $request->token;
        $result = json_decode($this->verify($api, $token));
        if (isset($result->status)) {
            if ($result->status == 1) {
                $updateOrder = $this->updateOrder($token, $result->transId);
                if (array_key_exists('error', $updateOrder)) {
                    toastr()->error($updateOrder['error'], 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
                    return redirect()->back();
                }
                \Cart::clear();
                toastr()->success(' شماره تراکنش : ' . $result->transId, 'عملیات پرداخت موفقیت آمیز بود', ['timeOut' => 5000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center',]);
                return redirect()->route('home.index');
            } else {
                toastr()->error('کاربر گرامی', 'عملیات پرداخت با خطا مواجه گردید', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
                return redirect()->route('home.index');
            }
        } else {
            if ($request->status == 0) {
                toastr()->error('کاربر گرامی', 'عملیات پرداخت با خطا مواجه گردید', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
                return redirect()->route('home.index');
            }
        }
    }


    public function send($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api' => $api,
            'amount' => $amount,
            'redirect' => $redirect,
            'mobile' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
        ]);
    }


    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function verify($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }


    public function checkCart()
    {
        if (\Cart::isEmpty()) {
            return ['error' => 'متاسفانه سبد خرید شما خالی می باشد'];
        }

        foreach (\Cart::getContent() as $item) {

            $variation = ProductVariation::findOrFail($item->attributes->id);

            $price = $variation->is_sale ? $variation->sale_price : $variation->price;

            if ($item->price != $price) {
                \Cart::clear();
                return ['error' => 'قیمت اولیه محصول ' . $item->name . ' تغییر یافته است'];
            }

            if ($item->quantity > $variation->quantity) {
                \Cart::clear();
                return ['error' => 'تعداد موجودی محصول ' . $item->name . ' تغییر یافته است'];
            }

            return ['success' => 'عملیات موفقیت آمیز بود'];
        }
    }


    public function getAmounts()
    {
        if (session()->has('coupon')) {
            $checkCoupon = checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error', $checkCoupon)) {
                return $checkCoupon;
            }
        }


        return [
            'total_amount' => (\Cart::getTotal() + cartTotalSaleAmount()),
            'delivery_amount' => cartTotalDeliveryAmount(),
            'coupon_amount' => session()->has('coupon') ? session()->get('coupon.amount') : 0,
            'paying_amount' => cartTotalAmount(),

        ];
    }


    public function createOrder($addressId, $amounts, $token, $gateway_name)
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $addressId,
                'coupon_id' => session()->has('coupon') ? session()->get('coupon.id') : null,
                'total_amount' => $amounts['total_amount'],
                'delivery_amount' => $amounts['delivery_amount'],
                'coupon_amount' => $amounts['coupon_amount'],
                'paying_amount' => $amounts['paying_amount'],
                'payment_type' => 'online',

            ]);

            foreach (\Cart::getContent() as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->associatedModel->id,
                    'product_variation_id' => $item->attributes->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => ($item->quantity * $item->price),
                ]);

                Transaction::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'amount' => $amounts['paying_amount'],
                    'token' => $token,
                    'gateway_name' => $gateway_name,
                ]);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            toastr()->error('متاسفانه مشکلی پیش آمده مجددا تلاش کنید', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();

        }

        return ['success' => 'عملیات موفقیت آمیز بود'];
    }


    public function updateOrder($token, $refId)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::where('token', $token)->firstOrFail();
            $transaction->update([
                'status' => 1,
                'ref_id' => $refId,

            ]);

            $order = Order::findOrFail($transaction->order_id);
            $order->update([
                'payment_status' => 1,
                'status' => 1,
            ]);

            foreach (\Cart::getContent() as $item) {
                $variation = ProductVariation::find($item->attributes->id);
                $variation->update([
                    'quantity' => $variation->quantity - $item->quantity,
                ]);
            };

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            toastr()->error('متاسفانه مشکلی پیش آمده مجددا تلاش کنید', 'کاربر گرامی', ['timeOut' => 5000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();

        }

        return ['success' => 'عملیات موفقیت آمیز بود'];
    }
}
