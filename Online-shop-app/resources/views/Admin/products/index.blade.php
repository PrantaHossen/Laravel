@extends('Admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @include('Admin.AppMessage')
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">New Product</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route('product.index') }}'"
                            class="btn btn-default btn-sm">
                            Reset
                        </button>
                    </div>
                    <div class="card-tools">

                        <form action="{{ route('product.index') }}" method="GET">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" name="keyword" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="5">ID</th>
                                <th width="80">Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>SKU</th>
                                <th width="100">Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @if ($product->image)
                                                <img width="50" height="50"
                                                    src="{{ asset('uploads/products/' . $product->image) }}"
                                                    alt="{{ $product->name }}">
                                            @endif
                                        </td>
                                        <td><a href="#">{{ $product->name }}</a></td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->qty }} -left in Stock</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>
                                            @if ($product->status == 1)
                                                <svg class="text-success-500 h-6 w-6 text-success"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            @endif
                                        </td>
                                        <td align="middle">
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="btn btn-primary">Edit</a>
                                            <a href="#" onclick="deleteProduct({{ $product->id }})"
                                                class="btn btn-danger">Delete</a>
                                            <form id="delete-product-from-{{ $product->id }}"
                                                action="{{ route('product.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>Record Not Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        function deleteProduct(id) {
            if (confirm("Are you want to delete Category")) {
                document.getElementById("delete-product-from-" + id).submit();
            }
        }
    </script>
@endsection
