<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Tambah User</h1>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="form-label">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="form-input @error('password') border-red-500 @enderror" required>
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Role <span class="text-red-500">*</span></label>
                        <select name="role" class="form-input @error('role') border-red-500 @enderror" required>
                            <option value="">Pilih role</option>
                            @foreach ($roles as $name => $label)
                                <option value="{{ $name }}" @selected(old('role') === $name)>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('role')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="btn-primary">Simpan User</button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
