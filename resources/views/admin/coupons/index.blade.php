@extends('admin.layouts.admin')

@section('title')
    لیست کوپن ها
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
                <h5 class="font-weight-bold mb-4">لیست کوپن ها ({{ $coupons->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.coupons.create') }}"
                       title="ایجاد کوپن">
                        <i class="fa fa-plus"></i>
                        ایجاد کوپن
                    </a>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام کوپن</th>
                    <th>کد کوپن</th>
                    <th>نوع کوپن</th>
                    <th>تاریخ انقضا کوپن</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($coupons as $key => $coupon)
                    <tr>
                        <td>
                            {{$coupons->firstItem() + $key}}
                        </td>
                        <td>
                            {{$coupon->name}}
                        </td>

                        <td>
                            {{$coupon->code}}
                        </td>

                        <td>
                            @if($coupon->type == 'amount')
                                مبلغی
                            @elseif($coupon->type == 'percentage')
                                درصدی
                            @endif
                        </td>

                        <td>
                            {{verta($coupon->expired_at)->format('Y/m/d H-i-s')}}
                        </td>

                        <td class="d-flex justify-content-center">
                            <a href="{{route('admin.coupons.show',['coupon'=>$coupon->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title=" نمایش کوپن">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.coupons.edit',['coupon'=>$coupon->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title="ویرایش کوپن">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form class="mx-1" action="{{ route('admin.coupons.destroy', ['coupon' => $coupon->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirmDelete()" id="popup" type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="حذف کوپن">
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
        {{$coupons->links()}}
    </div>
@endsection
