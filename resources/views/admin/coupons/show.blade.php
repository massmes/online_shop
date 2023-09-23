@extends('admin.layouts.admin')

@section('title')
    جزییات کوپن
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> کوپن : {{$coupon->name}}</h5>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام کوپن</label>
                        <input type="text" disabled class="form-control" value="{{$coupon->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>کد کوپن</label>
                        <input type="text" disabled class="form-control" value="{{$coupon->code}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>نوع کوپن</label>
                        <input type="text" disabled class="form-control" value="{{$coupon->type}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>مبلغ کوپن</label>
                        <input type="text" disabled class="form-control"
                               value="{{$coupon->amount !=null ? $coupon->amount: '-----' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>درصد کوپن</label>
                        <input type="text" disabled class="form-control"
                               value="{{$coupon->percentage != null ? $coupon->percentage : '-----'}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>حد اکثر مبلغ برای نوع درصدی</label>
                        <input type="text" disabled class="form-control"
                               value="{{$coupon->max_percentage_amount != null ? $coupon->max_percentage_amount : '-----'}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" disabled class="form-control"
                               value="{{verta($coupon->created_at)->format('Y/m/d H:i:s')}}">
                    </div>

                    <div class="form-group col-12">
                        <label for="description">توضیحات</label>
                        <textarea rows="5" id="description" name="description" class="form-control" disabled>{{$coupon->description}}</textarea>
                    </div>

                </div>
                <a href="{{route('admin.coupons.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>
            </div>
        </div>
    </div>
@endsection
