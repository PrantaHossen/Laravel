@extends('Admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('brand.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('brand.update', $brands->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                        value="{{ old('name', $brands->name) }}" oninput="updateSlug()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" readonly
                                        value="{{ old('slug', $brands->slug) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" required id="status" class="form-control">
                                        <option value="1" {{ $brands->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$brands->status ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('brand.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function updateSlug() {
            let name = document.getElementById('name').value;
            let slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '-')  // Replace all non-alphanumeric characters with hyphens
                .trim()                         // Trim leading/trailing spaces
                .replace(/-+/g, '-')            // Replace multiple hyphens with a single hyphen
                .replace(/\s+/g, '-');          // Replace spaces with hyphens
            document.getElementById('slug').value = slug;
        }
    </script>
@endsection
