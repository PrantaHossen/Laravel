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
                <a href="{{route('products.create')}}" class="btn btn-dark">Create Product</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
            <div class="col-md-10 mt-4">
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            </div>
            @endif
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-dark mt-4">
                        <h4 class="text-white text-center mt-3">Product List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Name</th>
                                <th>Sku</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Created_at</th>
                                <th>Action</th>
                            </tr>
                            @if($products->isNotEmpty())
                            @foreach( $products as $product )
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>
                                    @if($product->image!="")
                                    <img width="70" height="70" src="{{asset('uploads/products/'.$product->image)}}" alt="">
                                    @endif
                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->sku}}</td>
                                <td>${{$product->price}}</td>
                                <td>{{$product->description}}</td>
                                <td>{{$product->created_at}}</td>
                                <td align="middle">
                                    <a href="{{route('products.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                                    <a href="#" onclick="deleteProduct({{$product->id}})" class="btn btn-danger">Delete</a>
                                    <form id="delete-product-from-{{$product->id}}" action="{{route('products.destroy',$product->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>

<script>
    function deleteProduct(id){
        if(confirm("Are you want to delete product")){
            document.getElementById("delete-product-from-"+id).submit();
        }
    }
</script>
