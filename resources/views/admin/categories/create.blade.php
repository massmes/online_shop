@extends('admin.layouts.admin')

@section('script')
    <script>
        $('#attributeSelect').selectpicker({
            'title': 'انتخاب ویژگی',
        });


        $('#attributeSelect').on('changed.bs.select', function () {
            let attributesSelected = $(this).val();
            let attributes = @json($attributes);
            let attributeForFilter = [];
            attributes.map((attribute) => {
                $.each(attributesSelected, function (i, element) {
                    if (attribute.id == element) {
                        attributeForFilter.push(attribute);
                    }
                });
            });
            $('#attributeIsFilterSelect').find("option").remove();
            $('#variationSelect').find("option").remove();
            attributeForFilter.forEach((element) => {
                let attributeFilterOption = $("<option/>", {
                    value: element.id,
                    text: element.name,
                });
                let variationOption = $("<option/>", {
                    value: element.id,
                    text: element.name,
                });
                $('#attributeIsFilterSelect').append(attributeFilterOption);
                $('#attributeIsFilterSelect').selectpicker('refresh');

                $('#variationSelect').append(variationOption);
                $('#variationSelect').selectpicker('refresh');
            });
        });

        $('#attributeIsFilterSelect').selectpicker({
            'title': 'انتخاب ویژگی',
        });
        $('#variationSelect').selectpicker({
            'title': 'انتخاب متغیر'
        });

    </script>
@endsection

@section('title')
    ایجاد دسته بندی
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder">ایجاد دسته بندی</h5>
                <hr>
                @include('admin.sections.errors')
                <form action="{{route('admin.categories.store')}}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">نام دسته بندی</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="slug">نام انگلیسی</label>
                            <input type="text" id="slug" name="slug" class="form-control" value="{{old('slug')}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="parent_id">والد</label>
                            <select type="text" id="parent_id" name="parent_id" class="form-control">
                                <option value="0">بدون والد</option>
                                @foreach($parentCategories as $parentCategory)
                                    <option value="{{$parentCategory->id}}">{{$parentCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="is_active">وضعیت</label>
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" selected>فعال</option>
                                <option value="0">غیر فعال</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="attribute_ids">ویژگی</label>
                            <select name="attribute_ids[]" id="attributeSelect" class="form-control" multiple
                                    data-live-search="true">
                                @foreach($attributes as $attribute)
                                    <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="attribute_is_filter_ids">انتخاب ویژگی های قابل فیلتر</label>
                            <select name="attribute_is_filter_ids[]" id="attributeIsFilterSelect" class="form-control"
                                    multiple
                                    data-live-search="true">
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="variation_id">انتخاب ویژگی متغیر</label>
                            <select name="variation_id" id="variationSelect" class="form-control"
                                    data-live-search="true">
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="icon">آیکون</label>
                            <input type="text" id="icon" name="icon" class="form-control" value="{{old('icon')}}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">توضیحات</label>
                            <textarea id="description" name="description" class="form-control">{{old('description')}}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary mt-5 px-4">ثبت</button>
                    <a href="{{route('admin.categories.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>
                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
