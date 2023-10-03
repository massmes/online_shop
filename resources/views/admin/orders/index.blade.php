@extends('admin.layouts.admin')

@section('title')
    لیست سفارشات
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
                <h5 class="font-weight-bold mb-4">لیست سفارشات ({{ $orders->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.orders.create') }}"
                       title="ایجاد سفارش">
                        <i class="fa fa-plus"></i>
                        ایجاد سفارش اختصاصی
                    </a>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام کاربر</th>
                    <th>وضعیت</th>
                    <th>مبلغ</th>
                    <th>نوع پرداخت</th>
                    <th>وضعیت پرداخت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $key => $order)
                    <tr>
                        <td>
                            {{$orders->firstItem() + $key}}
                        </td>
                        <td>
                            @if ($order->user)
                                <img width="60" class="img-fluid rounded-circle" alt="{{$order->user->name}}"
                                     src="{{$order->user->avatar}}"
                                     alt="{{$order->user->name}}">
                                {{$order->user->name == null ? 'کاربر' : $order->user->name}}
                            @else
                                کاربر
                            @endif
                        </td>
                        <td>
                            {{$order->status}}
                        </td>
                        <td>
                            {{number_format($order->total_amount)}}
                        </td>

                        <td>
                            {{$order->payment_type}}
                        </td>

                        <td>
                            {{$order->payment_status}}
                        </td>
                        <td class="d-flex justify-content-center">
                            <a href="{{route('admin.orders.show',['order'=>$order->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title=" نمایش سفارش">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.orders.edit',['order'=>$order->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title="ویرایش سفارش">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form class="mx-1"
                                  action="{{ route('admin.orders.destroy', ['order' => $order->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirmDelete()" id="popup" type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="حذف سفارش">
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
        {{$orders->links()}}
    </div>
@endsection
