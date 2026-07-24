<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Role & Permission</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-500">Kelola role dan permission pengguna.</p>
            <a href="{{ route('roles.create') }}" class="btn-primary shrink-0">Tambah Role</a>
        </div>

        <div class="card overflow-hidden">
            @if ($roles->isEmpty())
                <x-empty-state title="Tidak ada role" description="Belum ada role yang dibuat." icon="users" />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="table-th">Nama Role</th>
                                <th class="table-th">Permissions</th>
                                <th class="table-th">Users</th>
                                <th class="table-th text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($roles as $role)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="table-td font-medium text-gray-900">{{ $role->name }}</td>
                                    <td class="table-td"><span class="badge bg-gray-100 text-gray-700">{{ $role->permissions_count }} permission</span></td>
                                    <td class="table-td text-gray-500">{{ $role->users_count }} user</td>
                                    <td class="table-td">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('roles.edit', $role) }}" class="btn-ghost">Edit</a>
                                            @can('delete', $role)
                                                <form action="{{ route('roles.destroy', $role) }}" method="POST" x-data x-ref="form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" @click="if(confirm('Hapus role ini?')) $refs.form.submit()" class="btn-ghost text-red-600">Hapus</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
