@extends('home.layouts.home')

@section('title')
    صفحه ای فروشگاه
@endsection

@section('script')
    <script>
        $('.variation-select').on('change', function () {
            let variation = JSON.parse(this.value);
            let variationPriceDiv = $('.variation-price');
            variationPriceDiv.empty();

            if (variation.is_sale) {
                let spanSale = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.sale_price)) + ' تومان'
                });
                let spanPrice = $('<span />', {
                    class: 'old',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });

                variationPriceDiv.append(spanSale);
                variationPriceDiv.append(spanPrice);
            } else {
                let spanPrice = $('<span />', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });
                variationPriceDiv.append(spanPrice);
            }

            $('.quantity-input').attr('data-max', variation.quantity);
            $('.quantity-input').val(1);

        });
    </script>
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active">{{$product->name}}</li>
                    <li class="active">{{$product->brand->name}}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="product-details-area pt-100 pb-95">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
                    <div class="product-details-content ml-30">
                        <h2 class="text-right font-weight-bold"> {{ $product->name }} </h2>
                        <h4 class="text-right my-3"> برند : {{ $product->brand->name }} </h4>
                        <div class="product-details-price variation-price">
                            @if($product->quantity_check)
                                @if($product->sale_check)
                                    <span class="new">
                                    {{ number_format($product->sale_check->sale_price) }}
                                    تومان
                                </span>
                                    <span class="old">
                                    {{ number_format($product->sale_check->price) }}
                                    تومان
                                </span>
                                @else
                                    <span class="new">
                                    {{ number_format($product->price_check->price) }}
                                    تومان
                                </span>
                                @endif
                            @else
                                <div class="not-in-stock">
                                    <p class="text-white">ناموجود</p>
                                </div>
                            @endif
                        </div>
                        <div class="pro-details-rating-wrap">
                            <div data-rating-stars="5"
                                 data-rating-readonly="true"
                                 data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                            </div>
                            <span class="mx-3">|</span>
                            <span>{{$product->approvedComments()->count()}} دیدگاه </span>
                        </div>
                        <p class="text-right">
                            {{ $product->description }}
                        </p>
                        <div class="pro-details-list text-right">
                            <ul>
                                @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                    <li> -
                                        {{ $attribute->attribute->name }}
                                        :
                                        {{ $attribute->value }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{--                        <span class="text-right d-block">--}}
                        {{--                            تاریخ پایان فروش ویژه :--}}
                        {{--                            <?php echo ($product->sale_check->date_on_sale_to) ?--}}
                        {{--                                verta($product->sale_check->date_on_sale_to)->format('d-m-Y') : ''; ?>--}}
                        {{--                        </span>--}}
                        {{--                        <span class="text-right my-2 d-block">--}}
                        {{--                            <?php--}}
                        {{--                            $startDate = \Carbon\Carbon::instance(verta($product->sale_check->date_on_sale_from));--}}
                        {{--                            $endDate = \Carbon\Carbon::instance(verta($product->sale_check->date_on_sale_to));--}}
                        {{--                            $remainingDays = $endDate->diffInDays($startDate);--}}
                        {{--                            echo $remainingDays;--}}
                        {{--                            ?>--}}
                        {{--                            روز مانده تا پایان فروش ویژه--}}

                        {{--                        </span>--}}

                        @if($product->quantity_check)

                            @php
                                if($product->sale_check)
                                {
                                    $variationProductSelected = $product->sale_check;
                                }else{
                                    $variationProductSelected = $product->price_check;
                                }
                            @endphp
                            <div class="pro-details-size-color text-right">
                                <div class="pro-details-size w-50">
                                    <span>{{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}</span>
                                    <select class="form-control variation-select">
                                        @foreach ($product->variations()->where('quantity' , '>' , 0)->get() as $variation)
                                            <option
                                                value="{{ json_encode($variation->only(['id' , 'quantity','is_sale' , 'sale_price' , 'price'])) }}"
                                                {{ $variationProductSelected->id == $variation->id ? 'selected' : '' }}
                                            >{{ $variation->value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="pro-details-quality">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton"
                                           value="1" data-max="5"/>
                                </div>
                                <div class="pro-details-cart">
                                    <a href="#">افزودن به سبد خرید</a>
                                </div>
                                <div class="pro-details-wishlist">
                                    @auth
                                        @if($product->checkUserWishList(auth()->id()))
                                            <a href="{{route('home.wishlist.remove',['product'=>$product->id])}}"
                                               title="به لیست علاقه مندی ها اضافه شده">
                                                <i class="fas fa-heart" style="color:#ff3535"></i>

                                            </a>
                                        @else
                                            <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"
                                               title="افزودن به علاقه مندی ها">
                                                <i class="sli sli-heart"></i>
                                            </a>
                                        @endif

                                    @else
                                        <a href="{{route('home.wishlist.add',['product'=>$product->id])}}"
                                           title="افزودن به علاقه مندی ها">
                                            <i class="sli sli-heart"></i>
                                        </a>
                                    @endauth
                                </div>
                                <div class="pro-details-compare">
                                    <a title="Add To Compare"
                                       href="{{route('home.compare.add',['product'=>$product])}}">
                                        <i class="sli sli-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="not-in-stock">
                                <p class="text-white">ناموجود</p>
                            </div>
                        @endif

                        <div class="pro-details-meta">
                            <span>دسته بندی :</span>
                            <ul>
                                <li><a href="#">{{ $product->category->parent->name }}
                                        ، {{ $product->category->name }}</a></li>
                            </ul>
                        </div>
                        <div class="pro-details-meta">
                            <span>تگ ها :</span>
                            <ul>
                                @foreach ($product->tags as $tag)
                                    <li><a href="#">{{ $tag->name }}{{ $loop->last ? '' : '،' }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                    <div class="product-details-img">
                        <div class="zoompro-border zoompro-span">
                            <img class="zoompro"
                                 src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}"
                                 data-zoom-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}"
                                 alt="{{$product->slug}}"/>

                        </div>
                        <div id="gallery" class="mt-20 product-dec-slider">
                            <a data-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}"
                               data-zoom-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}">
                                <img width="90"
                                     src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}" alt="">
                            </a>
                            @foreach($product->images as $image)
                                <a data-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image)}}"
                                   data-zoom-image="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image)}}">
                                    <img width="90" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image)}}"
                                         alt="">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="description-review-area pb-95">
        <div class="container">
            <div class="row" style="direction: rtl;">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="{{ count($errors) > 0 ? '' : 'active' }}" data-toggle="tab" href="#des-details1">
                                توضیحات
                            </a>
                            <a data-toggle="tab" href="#des-details3"> اطلاعات بیشتر </a>
                            <a class="{{ count($errors) > 0 ? 'active' : '' }}" data-toggle="tab" href="#des-details2">
                                @if($product->approvedComments()->count() > 1)
                                    دیدگاه ها ({{$product->approvedComments()->count()}})
                                @else
                                    دیدگاه ({{$product->approvedComments()->count()}})
                                @endif

                            </a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane {{ count($errors) > 0 ? '' : 'active' }}">
                                <div class="product-description-wrapper text-right">
                                    {{$product->description}}
                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="product-anotherinfo-wrapper text-right">
                                    <ul>
                                        @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                            <li>
                                                <span
                                                    class="font-weight-bold"> {{ $attribute->attribute->name }} :</span>
                                                <span class="">{{ $attribute->value }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane {{ count($errors) > 0 ? 'active' : '' }}">

                                <div class="review-wrapper">
                                    @foreach($product->approvedComments as $comment)
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img
                                                    src="{{$comment->user->avatar == null ? asset('images/home/user.png') : $comment->user->avatar}}"
                                                    alt="">
                                            </div>
                                            <div class="review-content text-right w-100">
                                                <p class="text-right">
                                                    {{$comment->text}}
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4 class=""> {{$comment->user->name == null ? $comment->user->cellphone : $comment->user->name}} </h4>
                                                    </div>
                                                    <div data-rating-stars="5"
                                                         data-rating-readonly="true"
                                                         data-rating-value="{{ ceil($comment->user->rates->where('product_id',$product->id)->avg('rate')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div id="comments" class="ratting-form-wrapper text-right">
                                    <span class="font-weight-bold"> نوشتن دیدگاه </span>

                                    <div class="my-3" id="dataReadonlyReview"
                                         data-rating-stars="5"
                                         data-rating-value="0"
                                         data-rating-input="#rateInput">
                                    </div>

                                    <div class="ratting-form">
                                        <form action="{{route('home.comments.store',['product'=>$product->id])}}"
                                              method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="rating-form-style mb-20">
                                                        <label> متن دیدگاه : </label>
                                                        <textarea name="text"></textarea>
                                                    </div>
                                                </div>

                                                <input name="rate" id="rateInput" type="hidden" value="0">

                                                <div class="col-lg-12">
                                                    <div class="form-submit">
                                                        <input type="submit" value="ارسال">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @error('text')
                                    <div class="alert alert-danger mt-3">
                                        {{$message}}
                                    </div>
                                    @enderror

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="pro-dec-banner">
                        <a href="#">
                            <img class="" src="{{asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image)}}"
                                 alt="{{$product->name}}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
