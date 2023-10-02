@extends('home.layouts.home')

@section('title')
    صفحه سفارش
@endsection


@section('script')
    <script>
        $('#address_input').val($('#address_select').val());

        $('#address_select').change(function () {
            $('#address_input').val($(this).val());
        });


        $('.province-select').change(function () {

            var provinceID = $(this).val();

            if (provinceID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-province-cities-list') }}?province_id=" + provinceID,
                    success: function (res) {
                        if (res) {
                            $(".city-select").empty();
                            console.log(res);
                            $.each(res, function (key, city) {
                                console.log(city);
                                $(".city-select").append('<option value="' + city.id + '">' +
                                    city.name + '</option>');
                            });

                        } else {
                            $(".city-select").empty();
                        }
                    }
                });
            } else {
                $(".city-select").empty();
            }
        });
    </script>
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}"> صفحه اصلی </a>
                    </li>
                    <li class="active">سفارش</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">

        <div class="container">

            @if(!session()->has('coupon'))
                <div class="customer-zone mb-20">
                    <p class="cart-page-title">
                        کد تخفیف دارید؟
                        <a class="checkout-click3" href="#"> میتوانید با کلیک در این قسمت کد خود را اعمال کنید </a>
                    </p>
                    <div class="checkout-login-info3">
                        <form action="{{route('home.coupons.check')}}" method="post">
                            @csrf
                            <input type="text" name="code" placeholder="کد تخفیف">
                            <input type="submit" value="اعمال کد تخفیف">
                        </form>
                    </div>
                </div>
            @endif

            <div class="checkout-wrap pt-30">
                <div class="row">

                    <div class="col-lg-7">
                        <div class="billing-info-wrap mr-50">
                            <h3> آدرس تحویل سفارش </h3>

                            <div class="row">
                                <p class="mb-4">
                                    کاربر گرامی
                                    ( {{auth()->user()->user_name ?? auth()->user()->name ?? auth()->user()->cellphone}}
                                    )
                                    با تشکر از انتخاب شما لطفا ادرس خود را انتخاب و یا برای ایجاد ادرس جدید اقدام
                                    نمایید
                                </p>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info tax-select mb-20">
                                        <label> انتخاب آدرس تحویل سفارش <abbr class="required"
                                                                              title="required">*</abbr>
                                        </label>
                                        <select id="address_select" class="email s-email s-wid">
                                            @foreach($addresses as $address)
                                                <option value="{{$address->id}}"> {{$address->title}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 pt-30">
                                    <button class="collapse-address-create" type="submit"> ایجاد آدرس جدید</button>
                                </div>

                                <div class="col-lg-12">
                                    <div class="collapse-address-create-content"
                                         style="{{count($errors->addressStore) > 0 ? 'display:block' : ''}}">

                                        <form action="{{route('home.addresses.store')}}" method="post">
                                            @csrf

                                            <div class="row">

                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        عنوان
                                                    </label>
                                                    <input type="text" name="title" value="{{old('title')}}">
                                                    @error('title','addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شماره تماس
                                                    </label>
                                                    <input type="text" name="cellphone"
                                                           value="{{old('cellphone')}}">
                                                    @error('cellphone','addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        استان
                                                    </label>
                                                    <select class="email s-email s-wid province-select"
                                                            name="province_id">
                                                        @foreach($provinces as $province)
                                                            <option
                                                                value="{{$province->id}}">{{$province->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('province_id','addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شهر
                                                    </label>
                                                    <select class="email s-email s-wid city-select" name="city_id">
                                                    </select>
                                                    @error('city_id','addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        آدرس
                                                    </label>
                                                    <input type="text" name="address" value="{{old('address')}}">
                                                    @error('address','addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        کد پستی
                                                    </label>
                                                    <input type="text" name="postal_code"
                                                           value="{{old('postal_code')}}">
                                                    @error('postal_code','addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{$message}}</strong>
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class=" col-lg-12 col-md-12">

                                                    <button class="cart-btn-2" type="submit"> ثبت آدرس
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-5">
                        <form action="{{route('home.payment')}}" method="post">
                            @csrf
                            <div class="your-order-area">
                                <h3> سفارش شما </h3>
                                <div class="your-order-wrap gray-bg-4">
                                    <div class="your-order-info-wrap">
                                        <div class="your-order-info">
                                            <ul>
                                                <li> محصول <span> جمع </span></li>
                                            </ul>
                                        </div>
                                        <div class="your-order-middle">
                                            <ul>
                                                @foreach(\Cart::getContent() as $item)
                                                    <li class="d-flex justify-content-between">
                                                        <div>
                                                            {{$item->name}}
                                                            -
                                                            {{$item->quantity}}
                                                            <p class="text-danger" style="font-size: 12px">
                                                                {{App\Models\Attribute::find($item->attributes->attribute_id)->name}}
                                                                :
                                                                {{$item->attributes->value}}
                                                            </p>
                                                        </div>
                                                        <span>
                                                        {{number_format($item->price)}}
                                                        تومان

                                                        @if($item->attributes->is_sale)
                                                                <p class="text-danger" style="font-size: 12px">
                                                            {{$item->attributes->percent_sale}} %
                                                            تخفیف
                                                        </p>
                                                            @endif
                                                    </span>
                                                    </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li> مبلغ
                                                    <span>
                                                     {{number_format( \Cart::getTotal() + cartTotalSaleAmount() )}}
                                                    تومان
                                                </span>
                                                </li>
                                            </ul>
                                        </div>

                                        @if(cartTotalSaleAmount() > 0)
                                            <div class="your-order-info order-subtotal">
                                                <ul>
                                                    <li>
                                                        مبلغ تخفیف :
                                                        <span style="color: #ff3535">
                                                        {{number_format( cartTotalSaleAmount() )}}
                                                        تومان
                                                    </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif

                                        @if(session()->has('coupon'))
                                            <div class="your-order-info order-subtotal">
                                                <ul>
                                                    <li>
                                                        مبلغ کد تخفیف :
                                                        <span style="color: #ff3535">
                                                        {{number_format( session()->get('coupon.amount') )}}
                                                        تومان
                                                    </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="your-order-info order-shipping">
                                            <ul>
                                                <li>
                                                    هزینه ارسال
                                                    @if(cartTotalDeliveryAmount() == 0)
                                                        <span class="text-danger">
                                                        رایگان
                                                    </span>
                                                    @else
                                                        <span>
                                                        {{number_format( cartTotalDeliveryAmount() )}}
                                                        تومان
                                                    </span>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-total">
                                            <ul>
                                                <li>
                                                    جمع کل
                                                    <span>
                                                    {{number_format( cartTotalAmount() )}}
                                                    تومان
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        <div class="pay-top sin-payment">
                                            <input id="zarinpal" class="input-radio" type="radio" value="zarinpal"
                                                   checked="checked" name="payment_method">
                                            <label for="zarinpal"> درگاه پرداخت زرین پال </label>

                                        </div>
                                        <div class="pay-top sin-payment">
                                            <input id="pay" class="input-radio" type="radio" value="pay"
                                                   name="payment_method">
                                            <label for="pay">درگاه پرداخت پی</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="Place-order mt-40">
                                    <button type="submit">ثبت سفارش</button>
                                </div>
                            </div>
                            <input type="hidden" id="address_input" name="address_id">
                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
