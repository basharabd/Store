@extends('layouts.master')

@section('title' , $category->name)

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active"> {{ $category->name }}</li>


@endsection


@section('content')
<a class=" btn btn-danger" href="{{ route('categories.index') }}">Back</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Name</th>

            <th scope="col">Category</th>
            <th scope="col">Store</th>


            <th scope="col">Image</th>
            <th scope="col">Status</th>

            <th scope="col">Created_At</th>
            <th scope="col">Updated_At</th>

            <th scope="col">Edit</th>
            <th scope="col">Delete</th>

        </tr>
    </thead>
    <tbody>
        @php
            $products =  $category->products()->with('store')->latest()->paginate();
        @endphp
        @forelse( $products as $product )
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store->name }}</td>



            <td>
                <img src="{{ asset('uploads/'.$product->image) }}" height="90px" width="90px" alt="">

            </td>
            <td>{{ $product->status }}</td>


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
            <td style="text-align: center;font-size:20px;" colspan="10" class="alert alert-danger"> 
                No Products Defined

            </td>
        </tr>


        @endforelse




    </tbody>


</table>

{{ $products->links() }}

@endsection