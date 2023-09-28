@if (session()->has($type))
<div class=" alert alert-success">
    {{ session($type) }}
</div>
@endif

@if (session()->has('info'))
<div class=" alert alert-warning">
    {{ session('info') }}
</div>
@endif