@extends('admin.layouts.admin')

@section('title')
    جزییات تگ
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> تگ : {{$tag->name}}</h5>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input type="text" disabled class="form-control" value="{{$tag->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد</label>
                        <input type="text" disabled class="form-control"
                               value="{{verta($tag->created_at)->format('Y/m/d')}}">
                    </div>
                </div>
                <a href="{{route('admin.tags.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
