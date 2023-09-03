<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Exception;
use Alert;


class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::latest()->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.create');
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
            'name' => 'required|string|min:2',
        ]);
        try {
            $attribute = new Attribute();
            $attribute->name = $request->input('name');
            $attribute->save();
            toastr()->success('عملیات با موفقیت انجام پذیرفت', 'ویژگی جدیدی ایجاد شد');
            return redirect()->route('admin.attributes.index');
        } catch (Exception $exception) {
            toastr()->error('متاسفانه عملیات ایجاد ویژگی موفقیت آمیز نبود', 'خطایی رخ داده است', ['hideMethod' => 'fadeIn']);
            return redirect()->back();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        return view('admin.attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2',
        ]);

        try {
            $attribute->update([
                'name' => $request->name,
            ]);
            toastr()->success('عملیات با موفقیت انجام پذیرفت', 'ویژگی مورد نظر ویرایش شد');
            return redirect()->route('admin.attributes.index');
        } catch (Exception $exception) {
            toastr()->error('متاسفانه عملیات ویرایش ویژگی موفقیت آمیز نبود', 'خطایی رخ داده است', ['hideMethod' => 'fadeIn']);
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
//
        try {
            $attribute->delete();
            toastr()->error('عملیات حذف با موفقیت انجام پذیرفت', 'ویژگی مورد نظر حذف شد');
            return redirect()->route('admin.attributes.index');
        } catch (Exception $exception) {
            toastr()->error('متاسفانه عملیات حذف ویژگی موفقیت آمیز نبود', 'خطایی رخ داده است', ['hideMethod' => 'fadeIn']);
            return redirect()->back();

        }
    }
}
