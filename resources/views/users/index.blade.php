@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Users</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Tambah User
    </a>
</div>

<form action="{{ route('admin.users.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="search" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Cari nama atau email...">
        <button class="btn btn-outline-secondary" type="submit">Cari</button>
    </div>
</form>

<div class="card shadow-sm border-0">
<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead class="table-dark"><tr><th>#</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td>{{ $users->firstItem() + $loop->index }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge text-bg-secondary">{{ ucfirst($user->role?->name ?? '-') }}</span></td>
            <td class="d-flex gap-1">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted py-4">User tidak ditemukan.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
