<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="bg-dark py-3">
        <h4 class="text-white text-center">
            Laravel Crud
        </h4>
    </div>

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{route('products.index')}}" class="btn btn-dark">Back to Product List</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-dark mt-4">
                        <h4 class="text-white text-center mt-3">Create Product</h4>
                    </div>
                    <form enctype="multipart/form-data" action="{{route('products.store')}}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label h5">Name</label>
                                <input type="text" value="{{old('name')}}" name="name"  class=" @error('name') is-invalid @enderror form-control form-control-lg" placeholder="Enter Product Name">
                                @error('name')
                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for=""class="form-label h5">Product SKU</label>
                                <input type="text" value="{{old('sku')}}" name="sku" id="" class="@error('sku') is-invalid @enderror form-control form-control-lg" placeholder="Enter Product sku">
                                @error('sku')
                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for=""class="form-label h5">Product Price</label>
                                <input type="text" value="{{old('price')}}" name="price" id="" class=" @error('price') is-invalid @enderror form-control form-control-lg" placeholder="Enter Product Price">
                                @error('price')
                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" value="{{old('description')}}" class="form-label h5">Description</label>
                                <textarea name="description" class="form-control form-control-lg" cols="10" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for=""class="form-label h5">Select Product Image</label>
                                <input type="file" name="image" id="" class="form-control form-control-lg">
                            </div>
                            <div class="d-grid">
                                <button name="submit" class="btn btn-success form-control "> <h5>Submit</h5></button>
                            </div>

                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
