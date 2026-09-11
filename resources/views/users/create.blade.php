@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-4">Tambah User</h4>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @include('users._form')
        </form>
    </div>
</div>
@endsection
