@extends('admin.layouts.app')

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
                    <a href="{{ route('shipping.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('shipping.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="">
                                    <label for="country">Country</label>
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select a country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="">
                                    <label for="slug">Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control"
                                        placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4">
                                    <button class="btn btn-primary">Create</button>
                                    <a href="{{ route('shipping.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>

        {{-- <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th width="60">Country ID</th>
                        <th>Country Name</th>
                        <th>Chrage Amount</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipping as $shipping)
                        <tr>
                            <td>{{ $shipping->id }}</td>
                            <td>{{ $shipping->name }}</td>
                            <td>{{ $shipping->amount }}</td>

                            <td>
                                <a href="{{ route('shipping.edit', $shipping->id) }}">
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                </a>
                                <a href="{{ route('shipping.destroy', $shipping->id) }}" class="text-danger w-4 h-4 mr-1"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $shipping->id }}').submit();">
                                    <svg wire:loading.remove.delay="" wire:target=""
                                        class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path ath fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <form id="delete-form-{{ $shipping->id }}"
                                    action="{{ route('shipping.destroy', $shipping->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>--}}
    </section>
@endsection
@section('customJs')
<script>
    function deleteProduct(id){
        if(confirm("Are you want to delete Category")){
            document.getElementById("delete-product-from-"+id).submit();
        }
    }
</script>
@endsection
