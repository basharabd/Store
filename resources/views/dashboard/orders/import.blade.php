@extends('layouts.master')

@section('title' , 'Import Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>

@endsection


@section('content')
    <a class=" btn btn-danger my-2" href="{{ route('products.index') }}">Back</a>

    <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">

        @csrf

        <div class="mb-3 form-group">
            <x-form.input label="Excel File:" name="file" type="file" accept="image/*" />
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3 form-group">
            <button class="btn btn-sm btn-outline-primary" type="submit">Import</button>
        </div>

    </form>


@endsection
