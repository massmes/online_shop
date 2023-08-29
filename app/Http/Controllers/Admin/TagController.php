<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Wavey\Sweetalert\Sweetalert;
use Exception;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
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
            'name' => 'required|min:2',
        ]);
        try {
            $attribute = new Tag();
            $attribute->name = $request->input('name');
            $attribute->save();
            Sweetalert::success('ثبت اطلاعات با موفقیت انجام شد');
            return redirect()->route('admin.tags.index');
        } catch (Exception $exception) {
            Sweetalert::error('ثبت اطلاعات با خطا روبرو شد');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2',
        ]);
        try {
            $tag->update([
                'name' => $request->name,
            ]);
            Sweetalert::success('ویرایش اطلاعات با موفقیت انجام شد');
            return redirect()->route('admin.tags.index');
        } catch (Exception $exception) {
            Sweetalert::error('ویرایش اطلاعات با خطا روبرو شد');
            return redirect()->back();
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
}
