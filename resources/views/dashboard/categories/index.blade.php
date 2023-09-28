@extends('layouts.master')

@section('title' , 'Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>

@endsection


@section('content')

<div>
    @can('categories.create')
    <a class=" btn btn-info" href="{{ route('categories.create') }}">Create</a>
    @endcan
     <a class=" btn btn-primary mr-2" href="{{ route('categories.trash') }}">Trash</a>




</div>

<x-alert type="message" />

<form action="{{ URL::current() }}" method="get" class=" d-flex justify-content-between mb-4 mt-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>Active</option>
        <option value="archived" @selected(request('status')=='archived' )>Archived</option>
    </select>
    <button type="submit" class="btn btn-sm btn-dark mx-2">Search</button>

</form>


<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Parent</th>
            <th scope="col">Product Number</th>

            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Description</th>

            <th scope="col">Created_At</th>
            <th scope="col">Updated_At</th>

            @can('categories.update')
            <th scope="col">Edit</th>

            @endcan

                @can('categories.delete')
                <th scope="col">Delete</th>

                @endcan

        </tr>
    </thead>
    <tbody>
        @forelse( $categories as $category )
        <tr>
            <th>{{ $category->id }}</th>
            <td><a href="{{ route('categories.show' , $category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->products_number }}</td>


            <td>
                <img src="{{ asset('uploads/'.$category->image) }}" height="90px" width="90px" alt="">

            </td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->description }}</td>


            <td>{{ $category->created_at }}</td>
            <td>{{ $category->updated_at }}</td>

            <td>
                @can('categories.update')
                <a class="btn btn-sm btn-primary" href="{{ route('categories.edit', $category->id) }}">Edit</a>
                @endcan
            </td>



            <td>
                @can('categories.delete')
                <form action="{{ route('categories.destroy' , $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                @endcan
            </td>






        </tr>
        @empty

        <tr>
            <td style="text-align: center;font-size:20px;" colspan="11" class="alert alert-danger"> No Categories
                Defined
            </td>
        </tr>


        @endforelse




    </tbody>

</table>

{{ $categories->withQueryString()->links() }}




@endsection
