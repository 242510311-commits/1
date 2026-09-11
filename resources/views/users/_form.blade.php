@csrf

<div class="mb-3">
    <label for="name" class="form-label">Nama</label>
    <input type="text" id="name" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $user->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $user->email ?? '') }}" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label">
        Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
    </label>
    <input type="password" id="password" name="password"
           class="form-control @error('password') is-invalid @enderror"
           {{ isset($user) ? '' : 'required' }}>
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="role_id" class="form-label">Role</label>
    <select id="role_id" name="role_id"
            class="form-select @error('role_id') is-invalid @enderror" required>
        <option value="">-- Pilih Role --</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}"
                @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
    @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<button class="btn btn-success" type="submit">
    <i class="bi bi-check-lg"></i> Simpan
</button>
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
