@extends('admin.layouts.admin')

@section('title')
    جزییات دیدگاه
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-5">
                <h5 class="font-weight-bolder">دیدگاه</h5>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>نام کاربر</label>
                        <input type="text" disabled class="form-control"
                               value="{{ $comment->user->name ?? $comment->user->user_name ?? $comment->user->cellphone }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>ایمیل کاربر</label>
                        <input type="text" disabled class="form-control"
                               value="{{$comment->user->email == null ? $comment->user->cellphone : $comment->user->email}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>نام محصول</label>
                        <input type="text" disabled class="form-control" value="{{$comment->product->name}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>وضعیت</label>
                        <input type="text" disabled class="form-control" value="{{$comment->approved}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ ایجاد دیدگاه</label>
                        <input type="text" disabled class="form-control"
                               value="{{verta($comment->created_at)->format('Y/m/d')}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label>متن دیدگاه</label>
                        <textarea disabled class="form-control" rows="8">{{$comment->text}}</textarea>
                    </div>
                </div>
                <a href="{{route('admin.comments.index')}}" class="btn btn-secondary mt-5 mx-md-2">بازگشت</a>
                @if($comment->getRawOriginal('approved'))
                    <a href="{{route('admin.comments.change.status',['comment'=>$comment->id])}}"
                       class="btn btn-danger mt-5 mx-md-2" title=" عدم تایید دیدگاه کاربر  {{$comment->user->name}}">
                        عدم تایید دیدگاه
                    </a>
                @else
                    <a href="{{route('admin.comments.change.status',['comment'=>$comment->id])}}"
                       class="btn btn-success mt-5 mx-md-2">
                        تایید دیدگاه
                    </a>

                @endif
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
