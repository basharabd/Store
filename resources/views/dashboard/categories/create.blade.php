@extends('layouts.master')

@section('title' , 'Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>

@endsection


@section('content')
<a class=" btn btn-danger my-2" href="{{ route('categories.index') }}">Back</a>

<form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">

    @csrf

    @include('dashboard.categories._form')

</form>
@endsection