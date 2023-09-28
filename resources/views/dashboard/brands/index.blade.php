@extends('layouts.master')

@section('title' , 'Brands')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Brands</li>

@endsection


@section('content')

<div>
    <a class=" btn btn-info" href="{{ route('brands.create') }}">Create</a>
   <a class=" btn btn-primary mr-2" href="{{ route('brands.trash') }}">Trash</a>
{{--    <a class="btn btn-danger mr-2" href="{{ route('brands.export', request()->query()) }}">Export</a>--}}

{{--    <a class="btn btn-success mr-2" href="{{ route('brands.import') }}">Import</a>--}}





</div>

<x-alert type="message" />

<form action="{{ URL::current() }}" method="get" class=" d-flex justify-content-between mb-4 mt-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>Active</option>
        <option value="inactive" @selected(request('status')=='inactive' )>Inactive</option>

    </select>
    <button type="submit" class="btn btn-sm btn-dark mx-2">Search</button>

</form>


<table class="table">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Created_At</th>
            <th scope="col">Updated_At</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>

        </tr>
    </thead>
    <tbody>
        @forelse( $brands as $brand )
        <tr>
            <th>{{ $brand->name }}</th>
            <td>{{ $brand->description }}</td>

            <td>
                <img src="{{ asset('uploads/'.$brand->image) }}" height="90px" width="90px" alt="">

            </td>
            <td>{{ $brand->status }}</td>
            <th>{{ $brand->created_at }}</th>
            <td>{{ $brand->updated_at }}</td>

            <td>
                <a class="btn btn-sm btn-primary" href="{{ route('brands.edit', $brand->id) }}">Edit</a>
            </td>

            <td>

                <form action="{{ route('brands.destroy' , $brand->id) }}" method="post">
                    @csrf
                    @method('delete')

                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>



                </form>
            </td>


        </tr>
        @empty

        <tr>
            <td style="text-align: center;font-size:20px;" colspan="11" class="alert alert-danger">
                No Brands Defined

            </td>
        </tr>


        @endforelse




    </tbody>

</table>

{{ $brands->withQueryString()->links() }}




@endsection
