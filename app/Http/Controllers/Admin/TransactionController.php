<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
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
    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();
            toastr()->success('تراکنش مورد نظر حذف شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 10000, 'iconClass' => 'toast-success', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();

        } catch (\Exception $exception) {
            toastr()->error('خطا در انجام عملیات حذف تراکنش', 'عملیات موفقیت آمیز نبود', ['timeOut' => 10000, 'iconClass' => 'toast-error', 'positionClass' => 'toast-top-center', 'rtl' => true]);
            return redirect()->back();
        }
    }
}
