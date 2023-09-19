@extends('admin.layouts.admin')

@section('title')
    لیست کاربران
@endsection

@section('script')
    <script>
        function confirmDelete() {
            if (confirm('آیا از حذف  مطمئن هستید؟')) {
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
                <h5 class="font-weight-bold mb-4"> لیست کاربران ({{ $users->total() }})</h5>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام کاربر</th>
                    <th>نام مستعار کاربر</th>
                    <th>تلفن کاربر</th>
                    <th>عکس پروفایل</th>
                    <th>سطح دسترسی</th>
                    <th>ایمیل</th>
                    <th>تاریخ ایجاد(ویرایش)حساب کاربری</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $key => $user)
                    <tr>
                        <td>
                            {{$users->firstItem() + $key}}
                        </td>
                        <td>
                            @if($user->name == null)
                                ---
                            @else
                                {{$user->name}}
                            @endif
                        </td>
                        <td>
                            @if($user->user_name == null)
                                ---
                            @else
                                {{$user->user_name}}
                            @endif
                        </td>
                        <td>
                            @if($user->cellphone == null)
                                ---
                            @else
                                {{$user->cellphone}}
                            @endif
                        </td>
                        <td>
                            <div class="review-img">
                                <img width="50" class="img-fluid"
                                     src="{{$user->avatar == null ? asset('images/home/user.png') : $user->avatar}}"
                                     alt="{{$user->name}}">
                            </div>
                        </td>
                        <td>
                            {{$user->user_type == 'user' ? 'کاربر سایت' : 'ادمین'}}
                        </td>
                        <td>
                            @if($user->email == null)
                                ---
                            @else
                                {{$user->email}}
                            @endif
                        </td>
                        <td>
                            @if($user->created_at == $user->updated_at)
                               {{ verta($user->created_at)->format('Y/m/d-H-i-s')}}
                                <p>ایجاد شده</p>
                            @else
                                {{verta($user->updated_at)->format('Y/m/d-H-i-s')}}
                                <p>ویرایش شده</p>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.users.edit',['user'=>$user->id])}}" title="ویرایش مشخصات کاربر">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="my-5">
        {{$users->links()}}
    </div>
@endsection
