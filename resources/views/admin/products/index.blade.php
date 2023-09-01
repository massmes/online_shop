@extends('admin.layouts.admin')

@section('title')
    لیست محصولات
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-5 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-4">لیست محصولات ({{ $products->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.create') }}"
                       title="ایجاد محصول">
                        <i class="fa fa-plus"></i>
                        ایجاد محصول
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام محصول</th>
                    <th>نام برند</th>
                    <th>نام دسته بندی</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $key => $product)
                    <tr>
                        <td>
                            {{$products->firstItem() + $key}}
                        </td>
                        <td>
                            <a class="btn-link" href="{{route('admin.products.show',['product'=>$product->id])}}">
                                {{$product->name}}
                            </a>
                        </td>
                        <td>
                            <a class="btn-link" href="{{route('admin.brands.show',['brand'=>$product->brand->id])}}">
                                {{$product->brand->name}}
                            </a>
                        </td>
                        <td>
                            {{$product->category->name}}
                        </td>
                        <td>
                            <span class="{{ $product->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{$product->is_active}}
                            </span>
                        </td>
                        <th>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    عملیات
                                </button>
                                <div class="dropdown-menu">

                                    <a href="{{route('admin.products.edit',['product'=>$product->id])}}"
                                       class="dropdown-item text-right" title="ویرایش محصول">
                                        ویرایش محصول
                                    </a>

                                    <a href="{{route('admin.products.images.edit',['product'=>$product->id,'title'=>$product->slug])}}"
                                       class="dropdown-item text-right" title="ویرایش تصاویر">
                                        ویرایش تصاویر
                                    </a>

                                    <a href="{{route('admin.products.category.edit',['product'=>$product->id,'title'=>$product->category->slug])}}"
                                       class="dropdown-item text-right" title="ویرایش دسته بندی و ویژگی">
                                        ویرایش دسته بندی و ویژگی
                                    </a>

                                </div>
                            </div>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center my-5">
                {{$products->links()}}
            </div>
        </div>
    </div>

@endsection
