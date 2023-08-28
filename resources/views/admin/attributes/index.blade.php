@extends('admin.layouts.admin')

@section('title')
    لیست ویژگی ها
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست ویژگی ها ({{ $attributes->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.attributes.create') }}"
                   title="ایجاد ویژگی">
                    <i class="fa fa-plus"></i>
                    ایجاد ویژگی
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام ویژگی</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($attributes as $key => $attribute)
                    <tr>
                        <td>
                            {{$attributes->firstItem() + $key}}
                        </td>
                        <td>
                            {{$attribute->name}}
                        </td>
                        <td class="">
                            <a href="{{route('admin.attributes.show',['attribute'=>$attribute->id])}}"
                               class="btn btn-sm btn-outline-info mx-auto"
                               title=" نمایش ویژگی">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.attributes.edit',['attribute'=>$attribute->id])}}"
                               class="btn btn-sm btn-outline-info mx-auto"
                               title="ویرایش ویژگی">
                                <i class="fa fa-edit"></i>
                            </a>
                            {{--                            <form action="{{ route('admin.attributes.destroy', ['attribute' => $attribute->id]) }}"--}}
                            {{--                                  method="POST">--}}
                            {{--                                @csrf--}}
                            {{--                                @method('DELETE')--}}
                            {{--                                <button id="popup" type="submit" class="btn btn-sm btn-outline-danger mx-auto"--}}
                            {{--                                        title="حذف ویژگی">--}}
                            {{--                                    <i class="fa fa-trash"></i>--}}
                            {{--                                </button>--}}
                            {{--                            </form>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="my-5">
        {{$attributes->links()}}
    </div>
@endsection
