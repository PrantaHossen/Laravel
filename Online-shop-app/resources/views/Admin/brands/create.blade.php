@extends('Admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @include('Admin.AppMessage')
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
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
            <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name" oninput="updateSlug()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" required id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Blocked</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
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
                .replace(/[^a-z0-9\s-]/g, '-') // Replace all non-alphanumeric characters with hyphens
                .trim() // Trim leading/trailing spaces
                .replace(/-+/g, '-') // Replace multiple hyphens with a single hyphen
                .replace(/\s+/g, '-'); // Replace spaces with hyphens
            document.getElementById('slug').value = slug;
        }
    </script>
@endsection
