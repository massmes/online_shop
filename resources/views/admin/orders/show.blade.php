@extends('admin.layouts.admin')

@section('title')
    جزییات سفارش
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> سفارش : {{$order->id}}</h5>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام کاربر</label>
                        <input type="text" disabled class="form-control"
                               value="{{$order->user->name == null ? 'کاربر' : $order->user->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>کد کوپن</label>
                        <input type="text" disabled class="form-control"
                               value="{{$order->coupon_id == null ? 'استفاده نشده' : $order->coupon->code}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input type="text" disabled class="form-control" value="{{$order->status}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>مبلغ(تومان)</label>
                        <input type="text" disabled class="form-control"
                               value="{{number_format($order->total_amount)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>هزینه ارسال(تومان)</label>
                        <input type="text" disabled class="form-control"
                               value="{{$order->delivery_amount == 0 ? 'رایگان' : number_format($order->delivery_amount) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ کد تخفیف(تومان)</label>
                        <input type="text" disabled class="form-control"
                               value="{{number_format($order->coupon_amount)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ پرداخت نهایی(تومان)</label>
                        <input type="text" disabled class="form-control"
                               value="{{number_format($order->paying_amount)}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>نوع پرداخت</label>
                        <input type="text" disabled class="form-control"
                               value="{{$order->payment_type}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت پرداخت</label>
                        <input type="text" disabled class="form-control"
                               value="{{$order->payment_status}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" disabled class="form-control"
                               value="{{verta($order->created_at)->format('Y/m/d')}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>شماره تماس</label>
                        <input type="text" disabled class="form-control"
                               value="{{$order->address->cellphone}}">
                    </div>
                    <div class="form-group col-12">
                        <label>آدرس</label>
                        <textarea disabled rows="5" class="form-control">{{$order->address->address}}</textarea>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <h5 class="my-3">محصولات</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th> تصویر محصول</th>
                                    <th> نام محصول</th>
                                    <th>فی</th>
                                    <th>تعداد</th>
                                    <th> قیمت کل</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{route('admin.products.show',['product'=>$item->product->id,'brand'=>$item->product->brand->name])}}">
                                                <img width="100" class="img-fluid"
                                                     src="{{asset(env('product_images_upload_path').$item->product->primary_image)}}"
                                                     alt="{{$item->product->slug}}">
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{route('admin.products.show',['product'=>$item->product->id,'brand'=>$item->product->brand->name])}}">
                                                {{$item->product->name}}
                                            </a>
                                        </td>
                                        <td class="product-price-cart"><span
                                                class="amount">
                                                            {{number_format($item->price)}}
                                                            تومان
                                                        </span></td>
                                        <td class="product-quantity">
                                            {{$item->quantity}}
                                        </td>
                                        <td class="product-subtotal">
                                            {{number_format($item->subtotal)}}
                                            تومان
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
                <a href="{{route('admin.orders.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
