@extends('admin.layouts.admin')

@section('title')
    جزییات برند
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> برند : {{$brand->name}}</h5>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام برند</label>
                        <input type="text" disabled class="form-control" value="{{$brand->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input type="text" disabled class="form-control" value="{{$brand->is_active}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" disabled class="form-control"
                               value="{{verta($brand->created_at)->format('Y/m/d')}}">
                    </div>
                </div>
                <a href="{{route('admin.brands.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
