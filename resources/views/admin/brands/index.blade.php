@extends('admin.layouts.admin')

@section('title')
    لیست برندها
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-5 bg-white">
            <div  class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-4">لیست برند ها ({{ $brands->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.brands.create') }}">
                        <i class="fa fa-plus"></i>
                        ایجاد برند
                    </a>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام برند</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brands as $key => $brand)
                    <tr>
                        <td>
                            {{$brands->firstItem() + $key}}
                        </td>
                        <td>
                            {{$brand->name}}
                        </td>
                        <td>
                            <span class="{{ $brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{$brand->is_active}}
                            </span>
                        </td>
                        <td class="d-flex justify-content-center">
                            <a href="{{route('admin.brands.show',['brand'=>$brand->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title=" نمایش برند">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.brands.edit',['brand'=>$brand->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title="ویرایش برند">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form class="mx-1" action="{{ route('admin.brands.destroy', ['brand' => $brand->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button id="popup" type="submit" class="btn btn-sm btn-outline-danger mx-auto"
                                        title="حذف برند">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="my-5">
        {{$brands->links()}}
    </div>
@endsection
