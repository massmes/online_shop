@extends('admin.layouts.admin')

@section('script')
    <script>
        $('#brandSelect').selectpicker({
            'title': 'انتخاب برند'
        });
        $('#tagSelect').selectpicker({
            'title': 'انتخاب تگ'
        });

        let variations = @json($productVariations);
        variations.forEach(variation => {
            $(`#variationDateOnSaleFrom-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleFrom-${variation.id}`,
                modalMode: `#variationInputDateOnSaleFrom-${variation.id}`,
                trigger:`#variationInputDateOnSaleFrom-${variation.id}`,
                enableTimePicker: true,
                englishNumber: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss',
                disableBeforeToday: true,
            });


            $(`#variationDateOnSaleTo-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleTo-${variation.id}`,
                modalMode: `#variationInputDateOnSaleTo-${variation.id}`,
                enableTimePicker: true,
                englishNumber: true,
                textFormat: 'yyyy-MM-dd  HH:mm:ss',
                disableBeforeToday: true,
            });
        });


    </script>
@endsection

@section('title')
    ویرایش محصول
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-5 text-center text-md-right">
                <h5 class="font-weight-bolder "> ویرایش محصول : {{$product->name}}</h5>
                <hr>
                @include('admin.sections.errors')
                <form action="{{route('admin.products.update',['product'=>$product->id])}}" method="post">
                    @csrf
                    @method('put')

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">نام</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$product->name}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="brand_id">برند</label>
                            <select id="brandSelect" name="brand_id" class="form-control" data-live-search="true">
                                @foreach ($brands as $brand)
                                    <option
                                        value="{{ $brand->id }}" {{$brand->id == $product->brand->id ? 'selected' : ''}}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="is_active">وضعیت</label>
                            <select class="form-control" id="is_active" name="is_active">
                                <option value="1" {{$product->getRawOriginal('is_active') ? 'selected':''}}>
                                    فعال
                                </option>
                                <option value="0" value="1" {{$product->getRawOriginal('is_active') ? '':'selected'}}>
                                    غیرفعال
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="tag_ids">تگ</label>
                            <select id="tagSelect" name="tag_ids[]" class="form-control" multiple
                                    data-live-search="true">

                                @php
                                    $productTagIds = $product->tags->pluck('id')->toArray();
                                @endphp
                                @foreach ($tags as $tag)
                                    <option
                                        value="{{ $tag->id }}" {{in_array($tag->id, $productTagIds) ? 'selected':''}}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control" id="description" name="description"
                                      rows="5">{{ $product->description}}</textarea>
                        </div>


                        {{-- Delivery Section --}}
                        <div class="col-md-12">
                            <hr>
                            <p>هزینه ارسال کالا : </p>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="delivery_amount">هزینه ارسال</label>
                            <input class="form-control" id="delivery_amount" name="delivery_amount"
                                   type="text" value="{{$product->delivery_amount}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی</label>
                            <input class="form-control" id="delivery_amount_per_product"
                                   name="delivery_amount_per_product"
                                   type="text" value="{{$product->delivery_amount_per_product}}">
                        </div>


                        {{-- Attributes & Variations --}}
                        <div class="col-md-12">
                            <hr>
                            <p>ویژگی ها : </p>
                        </div>
                        @foreach ($productAttributes as $productAttribute)
                            <div class="form-group col-md-3">
                                <label>{{ $productAttribute->attribute->name }}</label>
                                <input class="form-control" type="text"
                                       name="attribute_values[{{$productAttribute->id}}]"
                                       value="{{ $productAttribute->value }}">
                            </div>
                        @endforeach

                        @foreach ($productVariations as $variation)
                            <div class="col-md-12">
                                <hr>
                                <div class="d-flex">
                                    <p class="mb-0"> قیمت و موجودی برای متغیر ( {{ $variation->value }} ) : </p>
                                    <p class="mb-0 mr-3">
                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                                data-target="#collapse-{{ $variation->id }}">
                                            نمایش
                                        </button>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="collapse mt-2" id="collapse-{{ $variation->id }}">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label> قیمت </label>
                                                <input type="text" class="form-control"
                                                       name="variation_values[{{$variation->id}}][price]"
                                                       value="{{ $variation->price }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تعداد </label>
                                                <input type="text" class="form-control"
                                                       name="variation_values[{{$variation->id}}][quantity]"
                                                       value="{{ $variation->quantity }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>شناسه انبار</label>
                                                <input type="text" class="form-control"
                                                       name="variation_values[{{$variation->id}}][sku]"
                                                       value="{{ $variation->sku }}">
                                            </div>

                                            {{-- Sale Section --}}
                                            <div class="col-md-12">
                                                <p> حراج : </p>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> قیمت حراجی </label>
                                                <input type="text" value="{{ $variation->sale_price }}"
                                                       name="variation_values[{{$variation->id}}][sale_price]"
                                                       class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تاریخ شروع حراجی </label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend order-2">
                                                        <span class="input-group-text"
                                                              id="variationDateOnSaleFrom-{{$variation->id}}">
                                                            <i class="fas fa-clock"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                           id="variationInputDateOnSaleFrom-{{$variation->id}}"
                                                           value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}"
                                                           name="variation_values[{{$variation->id}}][date_on_sale_from]">
                                                </div>

                                            </div>

                                            <div class="form-group col-md-3">
                                                <label> تاریخ پایان حراجی </label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend order-2">
                                                        <span class="input-group-text"
                                                              id="variationDateOnSaleTo-{{$variation->id}}">
                                                            <i class="fas fa-clock"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                           id="variationInputDateOnSaleTo-{{$variation->id}}"
                                                           value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}"
                                                           name="variation_values[{{$variation->id}}][date_on_sale_to]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                    <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                    <a href="{{route('admin.products.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>

                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
