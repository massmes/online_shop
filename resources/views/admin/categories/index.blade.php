@extends('admin.layouts.admin')

@section('title')
    لیست دسته بندی ها
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-5 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-4">لیست دسته بندی ها ({{ $categories->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.create') }}"
                       title="ایجاد دسته بندی">
                        <i class="fa fa-plus"></i>
                        ایجاد دسته بندی
                    </a>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام</th>
                    <th>نام انگلیسی</th>
                    <th>والد</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $key => $category)
                    <tr>
                        <td>
                            {{$categories->firstItem() + $key}}
                        </td>
                        <td>
                            {{$category->name}}
                        </td>
                        <td>
                            {{$category->slug}}
                        </td>
                        <td>
                            @if($category->parent_id == 0)
{{--                                {{$category->name}}--}}
                                بدون والد
                            @else
                                {{$category->parent->name}}

                            @endif
                        </td>
                        <td>
                            <span class="{{ $category->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{$category->is_active}}
                            </span>
                        </td>
                        <td class="">
                            <a href="{{route('admin.categories.show',['category'=>$category->id])}}"
                               class="btn btn-sm btn-outline-info mx-auto"
                               title=" نمایش دسته بندی">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.categories.edit',['category'=>$category->id])}}"
                               class="btn btn-sm btn-outline-info mx-auto"
                               title="ویرایش دسته بندی">
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
        {{$categories->links()}}
    </div>
@endsection
