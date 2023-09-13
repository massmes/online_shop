<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Alert;
use Exception;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view('admin.comments.show', compact('comment'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();
            toastr()->success('دیدگاه مورد نظر با موفقیت حذف شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center', 'rtl' => true,]);
            return redirect()->route('admin.comments.index');

        } catch (Exception $exception) {
            toastr()->error('حذف دیدگاه مورد نظر با خطا روبرو شد', 'خطا در انجام عملیات', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->route('admin.comments.index');
        }
    }

    public function changeStatus(Comment $comment)
    {
        try {
            if ($comment->getRawOriginal('approved')) {
                $comment->update([
                    'approved' => 0,
                ]);
            } else {
                $comment->update([
                    'approved' => 1,
                ]);
            }
            toastr()->error('تغییر وضعیت برای دیدگاه مورد نظر انجام گردید', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-info', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->route('admin.comments.index');
        } catch (Exception $exception) {
            toastr()->error('تغییر وضعیت برای دیدگاه مورد نظر با خطا مواجه گردید', 'خطا در انجام عملیات', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->route('admin.comments.index');
        }

    }
}
