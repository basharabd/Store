@extends('layouts.master')

@section('title' , 'Edit Category')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">Edit Category</li>


@endsection


@section('content')
<a class=" btn btn-danger" href="{{ route('categories.index') }}">Back</a>

<form action="{{ route('categories.update' , $category->id) }}" method="post" enctype="multipart/form-data">

    @csrf
    @method('put')

    @include('dashboard.categories._form' , [
        'button_lable'=>'Update'
    ])

</form>
@endsection