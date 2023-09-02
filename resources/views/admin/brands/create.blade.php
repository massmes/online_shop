@extends('admin.layouts.admin')

@section('title')
    ایجاد برند
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder">ایجاد برند</h5>
                <hr>
                @include('admin.sections.errors')
                <form action="{{route('admin.brands.store')}}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">نام برند</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="is_active">وضعیت</label>
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" selected>فعال</option>
                                <option value="0">غیر فعال</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-primary mt-5 px-4">ثبت</button>
                    <a href="{{route('admin.brands.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>

                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
