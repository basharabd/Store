@extends('layouts.master')

@section('title' , 'Brands')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Brands</li>

@endsection


@section('content')
<a class=" btn btn-danger my-2" href="{{ route('brands.index') }}">Back</a>

<form action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">

    @csrf

    @include('dashboard.brands._form')

</form>
@endsection
