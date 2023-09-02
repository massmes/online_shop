<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Wavey\Sweetalert\Sweetalert;
use Alert;
use Exception;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|mimes:jpg,jpeg,svg,png,gif,webp',
            'priority' => 'required|integer',
            'is_active' => 'required|in:0,1',
            'type' => 'required',
        ]);


        try {

            $fileNameImageBaner = generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PATH')), $fileNameImageBaner);

            $banners = new Banner();
            $banners->image = $fileNameImageBaner;
            $banners->title = $request->input('title');
            $banners->text = $request->input('text');
            $banners->priority = $request->input('priority');
            $banners->is_active = $request->input('is_active');
            $banners->type = $request->input('type');
            $banners->button_text = $request->input('button_text');
            $banners->button_link = $request->input('button_link');
            $banners->button_icon = $request->input('button_icon');
            $banners->save();
            toastr()->success('عملیات با موفقیت انجام پذیرفت', 'بنر جدیدی ایجاد شد');
            return redirect()->route('admin.banners.index');
        } catch (Exception $exception) {
            toastr()->error('متاسفانه عملیات ایجاد بنر موفقیت آمیز نبود', 'خطایی رخ داده است' . $exception->getCode(), ['hideMethod' => 'fadeIn']);
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
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'image' => 'nullable|mimes:jpg,jpeg,svg,png,gif,webp',
            'priority' => 'required|integer',
            'is_active' => 'required|in:0,1',
            'type' => 'required',
        ]);

        try {
            if ($request->hasFile('image')) {
                $fileNameImageBaner = generateFileName($request->image->getClientOriginalName());
                $request->image->move(public_path(env('BANNER_IMAGES_UPLOAD_PATH')), $fileNameImageBaner);
                $banner->image = $fileNameImageBaner;
            }
            $banner->image = $request->has('image') ? $fileNameImageBaner : $banner->image;
            $banner->title = $request->input('title');
            $banner->text = $request->input('text');
            $banner->priority = $request->input('priority');
            $banner->is_active = $request->input('is_active');
            $banner->type = $request->input('type');
            $banner->button_text = $request->input('button_text');
            $banner->button_link = $request->input('button_link');
            $banner->button_icon = $request->input('button_icon');
            $banner->save();
            toastr()->success('عملیات با موفقیت انجام پذیرفت', 'بنر با موفقیت به روز رسانی شد');
            return redirect()->route('admin.banners.index');
        } catch (Exception $exception) {
            toastr()->error('متاسفانه عملیات به‌روزرسانی بنر با خطا مواجه شد', 'خطایی رخ داده است' . $exception->getCode(), ['hideMethod' => 'fadeIn']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {

        try {
            $banner->delete();
            toastr()->success('عملیات با موفقیت انجام پذیرفت', 'بنر با موفقیت حذف شد');
            return redirect()->route('admin.banners.index');

        } catch (Exception $exception) {
            toastr()->error('متاسفانه حذف بنر با خطا مواجه شد', 'خطایی رخ داده است' . $exception->getCode(), ['hideMethod' => 'fadeIn']);
            return redirect()->route('admin.banners.index');
        }
    }
}
