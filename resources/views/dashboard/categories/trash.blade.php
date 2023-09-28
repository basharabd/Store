@extends('layouts.master')

@section('title' , 'Trash Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Trash</li>

@endsection


@section('content')

<div>
    <a class=" btn btn-info" href="{{ route('categories.index') }}">Back</a>



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
            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Description</th>

            <th scope="col">Deleted_At</th>

            <th scope="col">Restore</th>
            <th scope="col">Delete</th>

        </tr>
    </thead>
    <tbody>
        @forelse( $categories as $category )
        <tr>
            <th>{{ $category->id }}</th>
            <td>{{ $category->name }}</td>

            <td>
                <img src="{{ asset('uploads/'.$category->image) }}" height="90px" width="90px" alt="">

            </td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->description }}</td>


            <td>{{ $category->deleted_at }}</td>

            <td>
                <form action="{{ route('categories.restore' , $category->id) }}" method="post">
                    @csrf
                    @method('put')

                    <button type="submit" class="btn btn-sm btn-info">Restore</button>



                </form>            </td>

            <td>

                <form action="{{ route('categories.force_delete' , $category->id) }}" method="post">
                    @csrf
                    @method('delete')

                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>



                </form>
            </td>


        </tr>
        @empty

        <tr>
            <td style="text-align: center;font-size:20px;" colspan="10" class="alert alert-danger"> No Categories
                Defined
            </td>
        </tr>


        @endforelse




    </tbody>

</table>

{{ $categories->withQueryString()->links() }}




@endsection