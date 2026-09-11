@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-4">Edit User</h4>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @method('PUT')
            @include('users._form')
        </form>
    </div>
</div>
@endsection
