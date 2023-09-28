@extends('layouts.master')

@section('title' , $brand->name)

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Brands</li>
<li class="breadcrumb-item active"> {{ $brand->name }}</li>


@endsection


@section('content')
<a class=" btn btn-danger" href="{{ route('brands.index') }}">Back</a>

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


            <td>{{ $brand->name }}</td>
            <td>{{ $brand->description }}</td>

            <td>
                <img src="{{ asset('uploads/'.$brand->image) }}" height="90px" width="90px" alt="">

            </td>
            <td>{{ $brand->status }}</td>
            <td>{{ $brand->created_at }}</td>
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
            <td style="text-align: center;font-size:20px;" colspan="10" class="alert alert-danger">
                No Brands Defined

            </td>
        </tr>


        @endforelse




    </tbody>


</table>

{{ $brands->links() }}

@endsection
