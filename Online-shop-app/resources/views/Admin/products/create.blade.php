@extends('Admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @include('Admin.AppMessage')
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('product.index') }}" class="btn btn-primary">Back To List</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Left column -->
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input required type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                        value="{{ old('name') }}" oninput="updateSlug()">
                                    @error('name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        class="form-control @error('slug') is-invalid @enderror" placeholder="Slug"
                                        value="{{ old('slug') }}" readonly>
                                    @error('slug')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="shortDescription">Sort Description</label>
                                    <textarea required name="shortDescription" id="description" cols="30" rows="10"
                                        class="form-control @error('shortDescription') is-invalid @enderror summernote" placeholder="Short Description">{{ old('shortDescription') }}</textarea>
                                    @error('shortDescription')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea required name="description" id="description" cols="30" rows="10"
                                        class="form-control @error('description') is-invalid @enderror summernote" placeholder="Description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_returns">Shipping & Returns</label>
                                    <textarea required name="shipping_returns" id="shipping_returns" cols="30" rows="10"
                                        class="form-control @error('shipping_returns') is-invalid @enderror summernote" placeholder="shipping_returns">{{ old('shipping_returns') }}</textarea>
                                    @error('shipping_returns')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input required type="text" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Price"
                                        value="{{ old('price') }}">
                                    @error('price')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="compare_price">Compare at Price</label>
                                    <input type="text" name="compare_price" id="compare_price"
                                        class="form-control @error('compare_price') is-invalid @enderror"
                                        placeholder="Compare Price" value="{{ old('compare_price') }}">
                                    <p class="text-muted mt-3">To show a reduced price, move the product's original price
                                        into Compare at price. Enter a lower value into Price.</p>
                                    @error('compare_price')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="mb-3">
                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                    <input required type="text" name="sku" id="sku"
                                        class="form-control @error('sku') is-invalid @enderror" placeholder="SKU"
                                        value="{{ old('sku') }}">
                                    @error('sku')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode"
                                        class="form-control @error('barcode') is-invalid @enderror" placeholder="Barcode"
                                        value="{{ old('barcode') }}">
                                    @error('barcode')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="hidden" name="track_qty" value="No" id="">
                                        <input class="custom-control-input" type="checkbox" id="track_qty"
                                            value="Yes" name="track_qty"
                                            {{ old('track_qty', 'Yes') == 'Yes' ? 'checked' : '' }}>
                                        <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="qty">Enter Quantity</label>
                                    <input required type="number" min="0" name="qty" id="qty"
                                        class="form-control @error('qty') is-invalid @enderror" placeholder="Qty"
                                        value="{{ old('qty') }}">
                                    @error('qty')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Block
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="sub_category">Subcategory</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select a Subcategory</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select a Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('brand') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured Product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No" {{ old('is_featured', 'No') == 'No' ? 'selected' : '' }}>No
                                        </option>
                                        <option value="Yes" {{ old('is_featured', 'Yes') == 'Yes' ? 'selected' : '' }}>
                                            Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Related Product</h2>
                                <div class="mb-3">
                                    <select multiple class="related-product w-100" name="related_products[]"
                                        id="related-products">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $('.related-product').select2({
            ajax: {
                url: '{{ route('product.getProducts') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });


        function updateSlug() {
            let name = document.getElementById('name').value;
            let slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '-') // Replace all non-alphanumeric characters with hyphens
                .trim() // Trim leading/trailing spaces
                .replace(/-+/g, '-') // Replace multiple hyphens with a single hyphen
                .replace(/\s+/g, '-'); // Replace spaces with hyphens
            document.getElementById('slug').value = slug;
        }

        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('product.getSubcategories', ':categoryId') }}'.replace(
                            ':categoryId', categoryId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#sub_category').empty().append(
                                '<option value="">Select a Subcategory</option>');
                            $.each(data, function(key, value) {
                                $('#sub_category').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            alert('Error: ' + error);
                        }
                    });
                } else {
                    $('#sub_category').empty().append('<option value="">No data found</option>');
                }
            });
        });
    </script>
@endsection
