@extends('admin.layouts.admin')

@section('title')
    ویرایش دسته بندی محصول
@endsection

@section('script')
    <script>

        $('#categorySelect').selectpicker({
            'title': 'انتخاب دسته بندی'
        });

        $('#attributesContainer').hide();

        $('#categorySelect').change(function () {
            let categoryId = $(this).val();

            $.get(`{{ url('admin-panel/management/category-attributes/${categoryId}') }}`, function (response, status) {
                if (status == 'success') {


                    $('#attributesContainer').fadeIn(1000);
                    //Empty Attribute Container
                    $('#attributes').find('div').remove();


                    //Create and Append Attributes Input
                    response.attributes.forEach(attributeItem => {
                        let attributeFormGroup = $('<div/>', {
                            class: 'form-group col-md-3',
                        });
                        $('#variationName').text(response.variation.name)

                        attributeFormGroup.append($('<label/>', {
                            for: attributeItem.name,
                            text: attributeItem.name,
                        }));
                        attributeFormGroup.append($('<input/>', {
                            type: "text",
                            class: "form-control",
                            id: attributeItem.name,
                            name: `attribute_ids[${attributeItem.id}]`,
                        }));

                        $('#attributes').append(attributeFormGroup)
                    });

                } else {
                    alert('مشکل در دریافت لیست ویژگی ها');
                }
            }).fail(function () {
                alert('مشکل در دریافت لیست ویژگی ها');
            });
        });
        $('#czContainer').czMore();
    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold"> ویرایش دسته بندی محصول : {{$product->name}} </h5>
            </div>
            <hr>

            @include('admin.sections.errors')

            <form action="{{ route('admin.products.category.update',['product'=>$product->id]) }}" method="POST">
                @csrf
                @method('put')

                <div class="form-row">

                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="form-group col-md-3">
                                <label for="category_id">دسته بندی</label>
                                <select id="categorySelect" name="category_id" class="form-control"
                                        data-live-search="true">
                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}" {{$category->id == $product->category->id ? 'selected' : ''}}>{{ $category->name }}
                                            - {{ $category->parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="attributesContainer" class="col-md-12">
                        <div id="attributes" class="row"></div>
                        <div class="col-md-12">
                            <hr>
                            <p>
                                افزودن قیمت و موجودی برای متغیر
                                <span class="font-weight-bold" id="variationName"></span>
                                :
                            </p>
                        </div>

                        <div id="czContainer">
                            <div id="first">
                                <div class="recordset">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="value">نام</label>
                                            <input class="form-control" id="value" name="variation_values[value][]"
                                                   type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="price">قیمت</label>
                                            <input class="form-control" id="price" name="variation_values[price][]"
                                                   type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="quantity">تعداد</label>
                                            <input class="form-control" id="quantity"
                                                   name="variation_values[quantity][]" type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="sku">شناسه انبار</label>
                                            <input class="form-control" id="sku" name="variation_values[sku][]"
                                                   type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
