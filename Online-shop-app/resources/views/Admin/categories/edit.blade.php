@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @include('Admin.AppMessage')
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
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
                <form action="{{ route('categories.update', $categories->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ old('name', $categories->name) }}" required
                                        name="name" id="name"
                                        class="@error('sku') is-invalid @enderror form-control" placeholder="Name">
                                </div>
                                @error('name')
                                    <p class="invalid-feedback">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $categories->status == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $categories->status == '0' ? 'selected' : '' }}>Block
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showHome">Show On Home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option value="Yes" {{ $categories->showHome == 'Yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="No" {{ $categories->showHome == 'No' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="" class="form-control">
                                    @if ($categories->image != '')
                                        <img class=" w-50 my-3"
                                            src="{{ asset('uploads/categories/' . $categories->image) }}" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
            </div>

        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
        </div>
        </form>
        <!-- /.card -->
    </section>
@endsection

@section('customJs')
    <script></script>
@endsection
