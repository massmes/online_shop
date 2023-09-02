@extends('admin.layouts.admin')
{!! $msg??"" !!}
@section('title')
    ویرایش بنر
@endsection

@section('script')
    <script>
        $('#banner_image').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder"> ویرایش بنر : {{$banner->image}} </h5>
                <hr>
                @include('admin.sections.errors')
                <form action="{{route('admin.banners.update',['banner'=>$banner->id])}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 mb-3">
                            <div class="card">
                                <img class="card-img-top img-thumbnail"
                                     src="{{url(env('BANNER_IMAGES_UPLOAD_PATH').$banner->image)}}"
                                     title="{{$banner->title}}">
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="form-row">

                        <div class="form-group col-md-3">
                            <label for="banner_image">انتخاب تصویر</label>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="banner_image">
                                <label class="custom-file-label" for="banner_image"> انتخاب فایل </label>
                            </div>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="title">عنوان</label>
                            <input type="text" id="title" name="title" class="form-control" value=" {{$banner->title}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="text">متن</label>
                            <input type="text" id="text" name="text" class="form-control" value=" {{$banner->text}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="priority">الویت</label>
                            <input type="number" id="priority" name="priority"
                                   class="form-control" value="{{$banner->priority}}">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="is_active">وضعیت</label>
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" {{$banner->getRawOriginal('is_active') == 1 ? 'selected' : ''}}>فعال
                                </option>
                                <option value="0" {{$banner->getRawOriginal('is_active') == 0 ? 'selected': ''}}>غیر
                                    فعال
                                </option>
                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="type">نوع</label>
                            <input type="text" id="type" name="type" class="form-control" value=" {{$banner->type}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="button_text">متن دکمه</label>
                            <input type="text" id="button_text" name="button_text"
                                   class="form-control" value=" {{$banner->button_text}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="button_link">لینک دکمه</label>
                            <input type="text" id="button_link" name="button_link"
                                   class="form-control" value=" {{$banner->button_link}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="button_icon">آیکون دکمه</label>
                            <input type="text" id="button_icon" name="button_icon"
                                   class="form-control" value=" {{$banner->button_icon}}">
                        </div>


                    </div>

                    <button type="submit" class="btn btn-outline-primary mt-5 px-4">ثبت</button>
                    <a href="{{route('admin.banners.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>

                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
