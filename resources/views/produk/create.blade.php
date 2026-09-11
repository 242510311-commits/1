@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-4">Tambah Produk</h4>
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @include('produk._form')
        </form>
    </div>
</div>
@endsection
