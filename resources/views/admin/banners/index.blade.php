@extends('admin.layouts.admin')

@section('title')
    لیست بنرها
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
                <h5 class="font-weight-bold mb-4">لیست بنرها ({{ $banners->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.banners.create') }}">
                        <i class="fa fa-plus"></i>
                        ایجاد بنر
                    </a>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>تصویر</th>
                    <th>عنوان</th>
                    <th>متن</th>
                    <th>اولویت</th>
                    <th>وضعیت</th>
                    <th>نوع</th>
                    <th>متن دکمه</th>
                    <th>لینک دکمه</th>
                    <th>آیکون دکمه</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banners as $key => $banner)
                    <tr>
                        <td>
                            {{$banners->firstItem() + $key}}
                        </td>
                        <td>
                            <a target="_blank" href="{{url(env('BANNER_IMAGES_UPLOAD_PATH').$banner->image)}}">
                                {{$banner->image}}
                            </a>
                        </td>
                        <td>
                            {{$banner->title}}
                        </td>
                        <td>
                            {{$banner->text}}
                        </td>
                        <td>
                            {{$banner->priority}}
                        </td>
                        <td>
                            <span class="{{ $banner->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{$banner->is_active}}
                            </span>
                        </td>
                        <td>
                            {{$banner->type}}
                        </td>
                        <td>
                            {{$banner->button_text}}
                        </td>
                        <td>
                            {{$banner->button_link}}
                        </td>
                        <td>
                            {{$banner->button_icon}}
                        </td>
                        <td class="d-flex justify-content-between">
                            <a href="{{route('admin.banners.edit',['banner'=>$banner->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title="ویرایش بنر">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', ['banner' => $banner->id]) }} "
                                  id="delete-form"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirmDelete()" id="popup" type="submit"
                                        class="btn btn-sm btn-outline-danger mx-1"
                                        title="حذف بنر">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    <div class="my-5">
        {{$banners->links()}}
    </div>
@endsection
