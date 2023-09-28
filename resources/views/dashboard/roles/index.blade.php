@extends('layouts.master')

@section('title', 'Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')

<div class="mb-5">
    <a href="{{ route('roles.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
</div>

<x-alert type="message" />

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td><a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a></td>
            <td>{{ $role->created_at }}</td>
            <td>
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                    @csrf
                    <!-- Form Method Spoofing -->
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td style="text-align: center;font-size:20px;" colspan="4" class="alert alert-danger">No roles defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $roles->withQueryString()->links() }}

@endsection