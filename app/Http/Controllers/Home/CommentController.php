<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Wavey\Sweetalert\Sweetalert;
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
        //
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
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|min:5|max:2000',
            'rate' => 'required|digits_between:0,5',
        ]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '#comments')->withErrors($validator);
        }

        if (auth()->check()) {

            try {
                DB::beginTransaction();

                Comment::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'text' => $request->text,
                ]);

                if ($product->rates()->where('user_id', auth()->id())->exists()) {

                    $productRate = $product->rates()->where('user_id', auth()->id())->first();
                    $productRate->update([
                        'rate' => $request->rate,
                    ]);

                } else {
                    ProductRate::create([
                        'user_id' => auth()->id(),
                        'product_id' => $product->id,
                        'rate' => $request->rate,
                    ]);
                }

                DB::commit();

            } catch (Exception $exception) {
                DB::rollBack();
                toastr()->error('خطا در ثبت', 'ثبت دیدگاه شما با خطا مواجه گردید', ['timeOut' => 20000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center',]);
                return redirect()->back();
            }

            toastr()->error('با تشکر', 'دیدگاه شما با موفقیت ثبت گردید', ['timeOut' => 20000, 'iconClass' => 'toast-info', 'positionClass' => 'toast-top-center',]);
            return redirect()->back();

        } else {
            toastr()->error('پنل کاربری شما فعال نمیباشد', 'برای ثبت دیدگاه باید وارد پنل کاربری خود شوید', ['timeOut' => 20000, 'iconClass' => 'toast-warning', 'positionClass' => 'toast-top-center',]);
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
    public function destroy($id)
    {
        //
    }

    public function usersProfileIndex()
    {
        $comments = Comment::where('user_id', auth()->id())->where('approved', 1)->get();
        return view('home.users_profile.comments', compact('comments'));
    }
}
