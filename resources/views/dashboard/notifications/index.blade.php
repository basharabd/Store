@extends('layouts.master')

@section('title' , 'Notifications')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Notifications</li>

@endsection


@section('content')

<x-alert type="message" />

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Created_At</th>
            <th scope="col">Updated_At</th>

            <th scope="col">Read_at</th>

        </tr>
    </thead>
    <tbody>
        @foreach( $notifications as $notification )
        <tr>
            <th>{{ $notification->id }}</th>
            <th>{{ $notification->data['body']}}</th>

            <td>{{ $notification->read_at }}</td>
            <td>{{ $notification->created_at }}</td>
            <td>{{ $notification->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>





@endsection