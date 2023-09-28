@extends('layouts.master')

@section('title' , 'Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>

@endsection


@section('content')

<div>
    <a class=" btn btn-info" href="{{ route('products.create') }}">Create</a>
    <a class=" btn btn-primary mr-2" href="{{ route('products.trash') }}">Trash</a>
    <a class="btn btn-danger mr-2" href="{{ route('product.export', request()->query()) }}">Export</a>

    <a class="btn btn-success mr-2" href="{{ route('product.import') }}">Import</a>





</div>

<x-alert type="message" />

<form action="{{ URL::current() }}" method="get" class=" d-flex justify-content-between mb-4 mt-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>Active</option>
        <option value="draft" @selected(request('status')=='draft' )>Draft</option>
        <option value="archived" @selected(request('status')=='archived' )>Archived</option>

    </select>
    <button type="submit" class="btn btn-sm btn-dark mx-2">Search</button>

</form>


<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>

            <th scope="col">Category</th>
            <th scope="col">Store</th>


            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Description</th>

            <th scope="col">Created_At</th>
            <th scope="col">Updated_At</th>

            <th scope="col">Edit</th>
            <th scope="col">Delete</th>

        </tr>
    </thead>
    <tbody>
        @forelse( $products as $product )
        <tr>
            <th>{{ $product->id }}</th>
            <td>{{ $product->name }}</td>
            <td>{{ optional($product->category)->name }}</td>
            <td>{{ $product->store->name }}</td>



            <td>
                <img src="{{ asset('uploads/'.$product->image) }}" height="90px" width="90px" alt="">

            </td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->description }}</td>


            <td>{{ $product->created_at }}</td>
            <td>{{ $product->updated_at }}</td>

            <td>
                <a class="btn btn-sm btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
            </td>

            <td>

                <form action="{{ route('products.destroy' , $product->id) }}" method="post">
                    @csrf
                    @method('delete')

                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>



                </form>
            </td>


        </tr>
        @empty

        <tr>
            <td style="text-align: center;font-size:20px;" colspan="11" class="alert alert-danger">
                No Products Defined

            </td>
        </tr>


        @endforelse




    </tbody>

</table>

{{ $products->withQueryString()->links() }}




@endsection
