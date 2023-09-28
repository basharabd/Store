@extends('layouts.master')

@section('title' , 'Orders')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Orders</li>

@endsection


@section('content')

<div>
{{--    <a class=" btn btn-info" href="{{ route('orders.create') }}">Create</a>--}}
{{--    <a class=" btn btn-primary mr-2" href="{{ route('orders.trash') }}">Trash</a>--}}
{{--    <a class="btn btn-danger mr-2" href="{{ route('orders.export', request()->query()) }}">Export</a>--}}

{{--    <a class="btn btn-success mr-2" href="{{ route('orders.import') }}">Import</a>--}}





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
            <th scope="col">Store</th>
            <th scope="col">User</th>
            <th scope="col">order_number</th>
            <th scope="col">payment_method</th>
            <th scope="col">status</th>
            <th scope="col">payment_status</th>
            <th scope="col">shipping</th>
            <th scope="col">tax</th>
            <th scope="col">discount</th>
            <th scope="col">total</th>
            <th scope="col">Accept</th>
            <th scope="col">Cancel</th>


        </tr>
    </thead>
    <tbody>
        @forelse( $orders as $order )
        <tr>

            <th>{{ $order->store->name }}</th>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->number }}</td>
            <td>{{ $order->payment_method }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->payment_status }}</td>
            <td>{{ $order->shipping }}</td>
            <td>{{ $order->tax }}</td>
            <td>{{ $order->discount }}</td>
            <td>{{ $order->total }}</td>

            <td>
                <!-- Cancel Order Button -->
                <form method="POST" action="{{ route('orders.cancel', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                </form>
            </td>

            <td>
                <!-- Accept Order Button -->
                <form method="POST" action="{{ route('orders.accept', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm  btn-success">Accept</button>
                </form>
            </td>








        </tr>
        @empty

        <tr>
            <td style="text-align: center;font-size:20px;" colspan="11" class="alert alert-danger">
                No Orders Defined

            </td>
        </tr>


        @endforelse




    </tbody>

</table>

{{--{{ $orders->withQueryString()->links() }}--}}




@endsection
