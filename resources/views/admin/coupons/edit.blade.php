@extends('admin.layouts.admin')

@section('title')
    ویرایش کوپن
@endsection

@section('script')

    <script>
        $('#expireDate').MdPersianDateTimePicker({
            targetTextSelector: '#expireInput',
            modalMode: '#expired_at',
            enableTimePicker: true,
            englishNumber: true,
            textFormat: 'yyyy-MM-dd HH:mm:ss',
            // disableBeforeToday: true,
        });
    </script>

@endsection


@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> ویرایش کوپن : {{$coupon->name}}</h5>
                <hr>
                @include('admin.sections.errors')
                <form action="{{route('admin.coupons.update',['coupon'=>$coupon->id])}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">نام کوپن</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$coupon->name}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="code">کد کوپن</label>
                            <input type="text" id="code" name="code" class="form-control" value="{{$coupon->code}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="type">نوع کوپن</label>
                            <select id="type" name="type" class="form-control">
                                <option value="amount" {{ $coupon->type == 'amount' ? 'selected' : '' }}>مبلغی</option>
                                <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>درصدی</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="amount">مبلغ کوپن</label>
                            <input type="text" id="amount" name="amount" class="form-control" value="{{$coupon->amount}}">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="percentage">درصد کوپن</label>
                            <input type="text" id="percentage" name="percentage" class="form-control"
                                   value="{{$coupon->percentage}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="max_percentage_amount">حد اکثر مبلغ برای نوع درصدی</label>
                            <input type="text" id="max_percentage_amount" name="max_percentage_amount" class="form-control"
                                   value="{{$coupon->max_percentage_amount}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label> تاریخ انقضا کوپن</label>

                            <div class="input-group">
                                <div class="input-group-prepend order-2">
                                    <span class="input-group-text" id="expireDate">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                </div>

                                <input type="text" class="form-control" id="expireInput" name="expired_at"
                                       value="{{verta($coupon->expired_at)->format('Y/m/d H:i:s')}}">
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label for="description">توضیحات</label>
                            <textarea rows="5" id="description" name="description"
                                      class="form-control">{{$coupon->description}}</textarea>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                    <a href="{{route('admin.coupons.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>

                </form>
            </div>
        </div>
    </div>
@endsection
