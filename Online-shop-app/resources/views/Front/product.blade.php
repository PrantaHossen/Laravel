@extends('Front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('Front.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop.index') }}">Shop</a></li>
                    <li class="breadcrumb-item">{{ $product->name }}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            <div class="carousel-item active">
                                @if ($product->image != '')
                                    <a href="{{ route('shop.product', $product->slug) }}" class="product-img">
                                        <img src="{{ asset('uploads/products/' . $product->image) }}" alt=""
                                            class="img-fluid" style="width: 100%; height: 150px; object-fit: cover;">
                                    </a>
                                @else
                                    <img src="{{ asset('demo-assets/productDemo.jpg') }}" alt="">
                                @endif
                            </div>

                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{ $product->name }}</h1>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>
                        <h2 class="price text-secondary"><del>{{ $product->compare_price }}</del></h2>
                        <h2 class="price ">{{ $product->price }}</h2>

                        <p>{!! $product->short_description !!}</p>
                        <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark"><i
                                class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                    aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                                    type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping &
                                    Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                    type="button" role="tab" aria-controls="reviews"
                                    aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <p>
                                    {!! $product->description !!}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                <p>
                                    {!! $product->shipping_returns !!}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (!empty($relatedProducts))
        <section class="pt-5 section-8">
            <div class="container">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
                <div class="col-md-12">
                    <div id="related-products-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">

                            @foreach ($relatedProducts->chunk(6) as $index => $chunk)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="row">
                                        @foreach ($chunk as $relatedProduct)
                                            <div class="col-md-4 mb-4">
                                                <div class="card product-card">
                                                    <div class="product-image position-relative">
                                                        <a href="{{ route('shop.product', $relatedProduct->slug) }}"
                                                            class="product-img">
                                                            <img src="{{ $relatedProduct->image != '' && file_exists(public_path('uploads/products/' . $relatedProduct->image))
                                                                ? asset('uploads/products/' . $relatedProduct->image)
                                                                : asset('demo-assets/productDemo.jpg') }}"
                                                                alt="" class="img-fluid"
                                                                style="width: 100%; height: 100%; object-fit: cover;">
                                                        </a>
                                                        <a class="whishlist position-absolute top-0 end-0"
                                                            href="#"><i class="far fa-heart"></i></a>
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <a class="h6 link d-block mb-1"
                                                            href="{{ route('shop.product', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
                                                        <div class="price mt-2">
                                                            <span
                                                                class="h5"><strong>{{ $relatedProduct->price }}</strong></span>
                                                            @if ($relatedProduct->compare_price > 0)
                                                                <span
                                                                    class="h6 text-underline"><del>{{ $relatedProduct->compare_price }}</del></span>
                                                            @endif
                                                        </div>
                                                        <div class="product-action mt-2">
                                                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <a class="carousel-control-prev" href="#related-products-carousel" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#related-products-carousel" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

            </div>
            </div>
        </section>
    @endif
@endsection

@section('customJs')
    <script type="text/javascript">
    </script>
@endsection
