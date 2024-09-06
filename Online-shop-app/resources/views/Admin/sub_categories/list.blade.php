@extends('Admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sub-categories.create') }}" class="btn btn-primary">New Sub Category</a>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form action="{{ route('sub-categories.index') }}" method="GET">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{ request()->get('keyword') }}">
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
                            <th width="60">ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Category</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($subCategories->count())
                            @foreach ($subCategories as $subCategory)
                                <tr>
                                    <td>{{ $subCategory->id }}</td>
                                    <td>{{ $subCategory->name }}</td>
                                    <td>{{ $subCategory->slug }}</td>
                                    <td>{{ $subCategory->categoryName }}</td>
                                    <td>
                                        @if ($subCategory->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('sub-categories.edit', $subCategory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('sub-categories.destroy', $subCategory->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No Sub Categories Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $subCategories->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
