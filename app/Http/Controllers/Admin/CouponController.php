<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Alert;
use Exception;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'code' => 'required|unique:coupons,code,',
            'type' => 'required',
            'amount' => 'required_if:type,=,amount',
            'percentage' => 'required_if:type,=,percentage',
            'max_percentage_amount' => 'required_if:type,=,percentage',
            'expired_at' => 'required',
        ]);
        try {
            Coupon::create([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'percentage' => $request->percentage,
                'max_percentage_amount' => $request->max_percentage_amount,
                'expired_at' => convertShamsiToGregorianDate($request->expired_at),
            ]);
            toastr()->success('کوپن جدیدی ایجاد شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center', 'rtl' => true,]);
            return redirect()->route('admin.coupons.index');
        } catch (Exception $exception) {
            toastr()->error('خطا در انجام عملیات ایجاد کوپن', 'عملیات موفقیت آمیز نبود', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true,]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'amount' => 'required_if:type,=,amount',
            'percentage' => 'required_if:type,=,percentage',
            'max_percentage_amount' => 'required_if:type,=,percentage',
            'expired_at' => 'required',
        ]);
        try {
            $coupon->update([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type,
                'amount' => $request->amount,
                'percentage' => $request->percentage,
                'max_percentage_amount' => $request->max_percentage_amount,
                'expired_at' => convertShamsiToGregorianDate($request->expired_at),
                'description' => $request->description,
            ]);
            toastr()->success('کوپن مورد نظر ویرایش شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center', 'rtl' => true,]);
            return redirect()->route('admin.coupons.index');
        } catch (Exception $exception) {
            toastr()->error('خطا در انجام عملیات ویرایش کوپن', 'عملیات موفقیت آمیز نبود', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true,]);
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        try {
            $coupon->delete();
            toastr()->success('کوپن مورد نظر حذف شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();

        } catch (Exception $exception) {
            toastr()->error('خطا در انجام عملیات حذف کوپن', 'عملیات موفقیت آمیز نبود', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();
        }
    }
}
