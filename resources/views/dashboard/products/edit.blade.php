@extends('layouts.master')

@section('title' , 'Edit Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
<li class="breadcrumb-item active">Edit Product</li>


@endsection


@section('content')
<a class=" btn btn-danger" href="{{ route('products.index') }}">Back</a>

<form action="{{ route('products.update' , $product->id) }}" method="post" enctype="multipart/form-data">

    @csrf
    @method('put')

    @include('dashboard.products._form' , [
        'button_lable'=>'Update'
    ])

</form>
@endsection