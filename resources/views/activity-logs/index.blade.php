<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Activity Log</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="card p-5">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" class="form-input max-w-md" placeholder="Cari deskripsi..." value="{{ $search ?? '' }}">
                <select name="action" class="form-input max-w-xs">
                    <option value="">Semua Aksi</option>
                    @foreach ($actions as $act)
                        <option value="{{ $act }}" @selected(($action ?? '') === $act)>{{ ucfirst($act) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary">Filter</button>
                @if ($search || $action)<a href="{{ route('activity-logs.index') }}" class="btn-secondary">Reset</a>@endif
            </form>
        </div>

        <div class="card overflow-hidden">
            @if ($logs->isEmpty())
                <x-empty-state title="Tidak ada log" description="Belum ada aktivitas yang tercatat." icon="document" />
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="table-th">Waktu</th>
                                <th class="table-th">User</th>
                                <th class="table-th">Aksi</th>
                                <th class="table-th">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="table-td text-gray-500 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
                                    <td class="table-td">{{ $log->user?->name ?? 'System' }}</td>
                                    <td class="table-td"><span class="badge {{ $log->action_color }}">{{ $log->action_label }}</span></td>
                                    <td class="table-td text-gray-700">{{ $log->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">{{ $logs->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
