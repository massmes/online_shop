@extends('admin.layouts.admin')

@section('title')
    جزییات ویژگی
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> دسته بندی : {{$category->name}}</h5>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input type="text" disabled class="form-control" value="{{$category->name}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>نام انگلیسی</label>
                        <input type="text" disabled class="form-control" value="{{$category->slug}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>والد</label>
                        <div class="form-control div-disabled">
                            @if($category->parent_id == 0)
                                {{$category->name}}
                            @else
                                {{$category->parent->name}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input type="text" disabled class="form-control" value="{{$category->is_active}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>آیکون</label>
                        <input type="text" disabled class="form-control" value="{{$category->icon}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" disabled class="form-control"
                               value="{{verta($category->created_at)->format('Y/m/d')}}">
                    </div>

                    <div class="form-group col-md-12">
                        <label>توضیحات</label>
                        <textarea disabled class="form-control">{{$category->description}}</textarea>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <div class="row">

                            <div class="col-md-3">
                                <label>ویژگی ها</label>
                                <div class="form-control div-disabled">
                                    @foreach($category->attributes as $attribute)
                                        {{$attribute->name}}{{$loop->last ? '':'،'}}
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>ویژگی های قابل فیلتر</label>
                                <div class="form-control div-disabled">
                                    @foreach($category->attributes()->wherePivot('is_filter',1)->get() as $attribute)
                                        {{$attribute->name}}{{$loop->last ? '':'،'}}
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>ویژگی های متغیر</label>
                                <div class="form-control div-disabled">
                                    @foreach($category->attributes()->wherePivot('is_variation',1)->get() as $attribute)
                                        {{$attribute->name}}{{$loop->last ? '':'،'}}
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <a href="{{route('admin.categories.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
