@extends('layouts.master')

@section('title' , 'Edit Brand')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Brands</li>
<li class="breadcrumb-item active">Edit Brand</li>


@endsection


@section('content')
<a class=" btn btn-danger" href="{{ route('brands.index') }}">Back</a>

<form action="{{ route('brands.update' , $brand->id) }}" method="post" enctype="multipart/form-data">

    @csrf
    @method('put')

    @include('dashboard.brands._form' , [
        'button_lable'=>'Update'
    ])

</form>
@endsection
