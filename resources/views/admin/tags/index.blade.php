@extends('admin.layouts.admin')

@section('title')
    لیست تگها
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست تگها ({{ $tags->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.tags.create') }}"
                   title="ایجاد تگ">
                    <i class="fa fa-plus"></i>
                    ایجاد تگ
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام تگ</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $key => $tag)
                    <tr>
                        <td>
                            {{$tags->firstItem() + $key}}
                        </td>
                        <td>
                            {{$tag->name}}
                        </td>
                        <td class="">
                            <a href="{{route('admin.tags.show',['tag'=>$tag->id])}}"
                               class="btn btn-sm btn-outline-info mx-auto"
                               title=" نمایش تگ">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.tags.edit',['tag'=>$tag->id])}}"
                               class="btn btn-sm btn-outline-info mx-auto"
                               title="ویرایش تگ">
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
        {{$tags->links()}}
    </div>
@endsection
