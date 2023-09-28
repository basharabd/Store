@extends('layouts.master')

@section('title' , 'Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>

@endsection


@section('content')
<a class=" btn btn-danger my-2" href="{{ route('products.index') }}">Back</a>

<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">

    @csrf

    @include('dashboard.products._form')

</form>
@endsection