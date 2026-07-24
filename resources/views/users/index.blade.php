<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">User Management</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-500">Kelola pengguna dan assign role.</p>
            <a href="{{ route('users.create') }}" class="btn-primary shrink-0">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Tambah User
            </a>
        </div>

        <div class="card p-5">
            <form method="GET" class="flex gap-3">
                <input type="text" name="search" class="form-input max-w-md" placeholder="Cari nama atau email..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn-primary">Cari</button>
                @if ($search)<a href="{{ route('users.index') }}" class="btn-secondary">Reset</a>@endif
            </form>
        </div>

        <div class="card overflow-hidden">
            @if ($users->isEmpty())
                <x-empty-state title="Tidak ada user" description="Belum ada user yang terdaftar." icon="users">
                    <x-slot name="action"><a href="{{ route('users.create') }}" class="btn-primary">Tambah User</a></x-slot>
                </x-empty-state>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="table-th">Nama</th>
                                <th class="table-th">Email</th>
                                <th class="table-th">Role</th>
                                <th class="table-th">Bergabung</th>
                                <th class="table-th text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="table-td">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="table-td text-gray-500">{{ $user->email }}</td>
                                    <td class="table-td">
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-indigo-100 text-indigo-700">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="table-td text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="table-td">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('users.edit', $user) }}" class="btn-ghost">Edit</a>
                                            <button type="button" class="btn-ghost text-amber-600" x-data @click="$dispatch('open-reset-modal', { id: {{ $user->id }}, name: '{{ $user->name }}' })">Reset PW</button>
                                            @can('delete', $user)
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" x-data x-ref="form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" @click="if(confirm('Hapus user {{ $user->name }}?')) $refs.form.submit()" class="btn-ghost text-red-600">Hapus</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">{{ $users->links() }}</div>
            @endif
        </div>
    </div>

    <div x-data="{ open: false, userId: null, userName: '' }"
         @open-reset-modal.window="open = true; userId = $event.detail.id; userName = $event.detail.name"
         x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
        <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-6" @click.stop>
            <h3 class="text-lg font-semibold text-gray-900">Reset Password</h3>
            <p class="text-sm text-gray-500 mt-1">Reset password untuk <span x-text="userName" class="font-medium"></span></p>
            <form :action="'/users/' + userId + '/reset-password'" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required minlength="8">
                </div>
                <div>
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" @click="open = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
