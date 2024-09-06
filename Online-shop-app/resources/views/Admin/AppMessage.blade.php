@if (Session::has('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <p>{{ Session::get('success') }}</p>
    </div>
@endif

@if (Session::has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-exclamation-triangle"></i> Error!</h4>
        <p>{{ Session::get('error') }}</p>
    </div>
@endif

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
