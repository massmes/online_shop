@extends('admin.layouts.admin')

@section('title')
    لیست تراکنش ها
@endsection

@section('script')
    <script>
        function confirmDelete() {
            if (confirm('آیا از حذف مطمئن هستید؟')) {
                document.getElementById('delete-form').submit();
            } else {
                return false;
            }
        }
    </script>
@endsection


@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-5 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-4">لیست تراکنش ها ({{ $transactions->total() }})</h5>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام کاربر</th>
                        <th>شماره سفارش</th>
                        <th>مبلغ</th>
                        <th>شناسه تراکنش</th>
                        <th>نام درگاه پرداخت</th>
                        <th>وضعیت</th>
                        <th>تاریخ تراکنش</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $key => $transaction)
                        <tr>
                            <td>
                                {{$transactions->firstItem() + $key}}
                            </td>
                            <td>
                                {{$transaction->user->name == null ? 'کاربر' : $transaction->user->name}}
                            </td>
                            <td>
                                {{$transaction->order_id}}
                            </td>
                            <td>
                                {{number_format($transaction->amount)}}
                            </td>
                            <td>
                                {{$transaction->ref_id}}
                            </td>

                            <td>
                                {{$transaction->gateway_name == 'pay' ? 'پی' : 'نامشخص'}}
                            </td>

                            <td>
                                {{$transaction->status}}
                            </td>

                            <td>
                                {{verta($transaction->created_at)->format('Y/m/d H:i:s')}}
                            </td>

                            <td class="d-flex justify-content-center">
                                <form class="mx-1"
                                      action="{{ route('admin.transactions.destroy', ['transaction' => $transaction->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirmDelete()" id="popup" type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="حذف تراکنش">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="my-5">
        {{$transactions->links()}}
    </div>
@endsection
