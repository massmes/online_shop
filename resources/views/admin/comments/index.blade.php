@extends('admin.layouts.admin')

@section('title')
    لیست دیدگاه ها
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
                <h5 class="font-weight-bold mb-4"> لیست دیدگاه ها ({{ $comments->total() }})</h5>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام کاربر</th>
                    <th>نام محصول</th>
                    <th>متن دیدگاه</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $key => $comment)
                    <tr>
                        <td>
                            {{$comments->firstItem() + $key}}
                        </td>
                        <td>
                            {{$comment->user->name}}
                        </td>
                        <td>
                            <a href="{{route('admin.products.show',['product'=>$comment->product->id])}}">
                                {{$comment->product->name}}
                            </a>
                        </td>
                        <td>
                            <p>{{ Str::limit($comment->text, $limit = 40, $end = '...') }}</p>
                        </td>

                        <td class="{{$comment->getRawOriginal('approved') ? 'text-success' : 'text-danger'}}">
                            {{$comment->approved}}
                        </td>
                        <td class="d-flex justify-content-center">
                            <a href="{{route('admin.comments.show',['comment'=>$comment->id])}}"
                               class="btn btn-sm btn-outline-info mx-1"
                               title=" نمایش دیدگاه">
                                <i class="fa fa-eye"></i>
                            </a>

                            <form class="mx-1"
                                  action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirmDelete()" id="popup" type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="حذف دیدگاه">
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
        {{$comments->links()}}
    </div>
@endsection
