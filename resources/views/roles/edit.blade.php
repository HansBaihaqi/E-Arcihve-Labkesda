<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Edit Role</h1>
    </x-slot>

    <div class="max-w-3xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('roles.update', $role) }}">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="form-label">Nama Role <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" value="{{ old('name', $role->name) }}" required>
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label mb-3 block">Permissions</label>
                        <div class="space-y-4">
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-gray-700 capitalize mb-3">{{ $group }}</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach ($groupPermissions as $permission)
                                            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-gray-900">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" @checked(in_array($permission->name, old('permissions', $rolePermissions)))>
                                                {{ $permission->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="btn-primary">Perbarui Role</button>
                    <a href="{{ route('roles.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
