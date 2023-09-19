@extends('admin.layouts.admin')

@section('title')
    مشخصات کاربر
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <div class="review-img d-flex justify-content-between">
                    <h5 class="font-weight-bolder">
                        کاربر : {{ $user->name ?? $user->user_name ?? $user->email ?? $user->cellphone }}
                    </h5>
                    <img width="50" class="img-fluid rounded-pill"
                         src="{{$user->avatar == null ? asset('images/home/user.png') : $user->avatar}}"
                         alt="{{$user->name}}">
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام کاربر</label>
                        <input type="text" disabled class="form-control"
                               value="{{ $user->name ?? $user->user_name ?? $user->cellphone }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>ایمیل کاربر</label>
                        <input type="text" class="form-control"
                               value="{{$user->email == null ? 'ایمیلی وارد نشده' : $user->email}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>تلفن کاربر</label>
                        <input type="text" class="form-control"
                               value="{{$user->cellphone == null ? 'وارد نشده' : $user->cellphone}}">
                    </div>
                    @php
                        $date = verta($user->updated_at)->format('Y/m/d-H-i-s');
                        if ($user->created_at == $user->updated_at) {
                            $date = verta($user->created_at)->format('Y/m/d-H-i-s');
                        }
                    @endphp

                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد(ویرایش)حساب کاربری</label>
                        <input type="text" class="form-control" value="{{ $date }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="access-level">سطح دسترسی</label>
                        <select id="access-level" name="access-level" class="form-control">
                            <option value="user" {{$user->user_type == 'user' ? 'selected' : ''}}>کاربر سایت</option>
                            <option value="user" {{$user->user_type == 'admin' ? 'selected' : ''}}>ادمین</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
