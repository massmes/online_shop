@extends('admin.layouts.admin')

@section('title')
    لیست ویژگی ها
@endsection

@section('script')
    <script>
        function confirmDelete() {
            if (confirm('آیا از حذف مطمئن هستید؟')) {
                document.getElementById('delete-form').submit();
            } else {
                return false;
            }
        }
    </script>
@endsection


@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-5 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-4">لیست ویژگی ها ({{ $attributes->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.attributes.create') }}"
                       title="ایجاد ویژگی">
                        <i class="fa fa-plus"></i>
                        ایجاد ویژگی
                    </a>
                </div>

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
                        <td class="d-flex justify-content-center">
                            <a href="{{route('admin.attributes.show',['attribute'=>$attribute->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title=" نمایش ویژگی">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('admin.attributes.edit',['attribute'=>$attribute->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title="ویرایش ویژگی">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form class="mx-1" action="{{ route('admin.attributes.destroy', ['attribute' => $attribute->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirmDelete()" id="popup" type="submit" class="btn btn-sm btn-outline-danger"
                                        title="حذف ویژگی">
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
        {{$attributes->links()}}
    </div>
@endsection
