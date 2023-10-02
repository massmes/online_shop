<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\city;
use App\Models\Province;
use App\Models\UserAddress;
use Carbon\Doctrine\CarbonImmutableType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Alert;
use Exception;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $addresses = UserAddress::where('user_id', auth()->id())->get();
        $provinces = Province::all();
        return view('home.users_profile.addresses', compact('provinces', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validateWithBag('addressStore', [
            'title' => 'required',
            'cellphone' => 'required|iran_mobile',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'postal_code' => 'required|iran_postal_code',

        ]);
        try {
            UserAddress::create([
                'user_id' => auth()->id(),
                'cellphone' => $request->cellphone,
                'title' => $request->title,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
            ]);

            toastr()->success('آدرس وارد شده ثبت شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();
        } catch (Exception $exception) {
            toastr()->error(' ایجاد آدرس با مشکل مواجه شد', 'خطا در انجام عملیات', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $address)
    {

        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'cellphone' => 'required|iran_mobile',
                'province_id' => 'required',
                'city_id' => 'required',
                'address' => 'required',
                'postal_code' => 'required|iran_postal_code',

            ]);

            if ($validator->fails()) {
                $validator->errors()->add('address_id', $address->id);
                return redirect()->back()->withErrors($validator, 'addressUpdate')->withInput();
            }

            $address->update([
                'cellphone' => $request->cellphone,
                'title' => $request->title,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
            ]);

            toastr()->success('آدرس ویرایش و ثبت شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->route('home.addresses.index');

        } catch (Exception $exception) {
            toastr()->error(' ویرایش با مشکل مواجه شد', 'خطا در انجام عملیات', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->route('home.addresses.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //برای ajax
    public function getProvinceCitiesList(Request $request)
    {
        $cities = city::where('province_id', $request->province_id)->get();
        return $cities;
    }
}
