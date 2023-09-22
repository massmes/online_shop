@extends('admin.layouts.admin')

@section('title')
    ویرایش ویژگی
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> ویرایش ویژگی : {{$attribute->name}}</h5>
                <hr>
                @include('admin.sections.errors')
                <form action="{{route('admin.attributes.update',['attribute'=>$attribute->id])}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">نام ویژگی</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$attribute->name}}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-primary mt-5 px-4">ویرایش</button>
                    <a href="{{route('admin.attributes.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>

                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
