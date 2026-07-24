<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
    </x-slot>

    @php
        $breadcrumb = [
            ['label' => 'Dashboard'],
        ];
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="stat-card group">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Arsip</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalArchives) }}</p>
                </div>
            </div>

            <div class="stat-card group">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 0 1 6.75 0 3.375 3.375 0 0 1-6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total User</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                </div>
            </div>

            <div class="stat-card group">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Admin</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalAdmins) }}</p>
                </div>
            </div>

            <div class="stat-card group">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 group-hover:bg-violet-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Upload Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($uploadsToday) }}</p>
                </div>
            </div>
        </div>

        @if ($canCreateArchive || $canManageUsers)
        <div class="card p-5">
            <h2 class="text-sm font-semibold text-gray-900 mb-3">Quick Actions</h2>
            <div class="flex flex-wrap gap-3">
                @if ($canCreateArchive)
                    <a href="{{ route('archives.create') }}" class="btn-primary">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Arsip
                    </a>
                @endif
                <a href="{{ route('archives.index') }}" class="btn-secondary">Lihat Semua Arsip</a>
                @if ($canManageUsers)
                    <a href="{{ route('users.create') }}" class="btn-secondary">Tambah User</a>
                @endif
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-900">Arsip Terbaru</h2>
                    <a href="{{ route('archives.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat semua</a>
                </div>
                @if ($recentArchives->isEmpty())
                    <x-empty-state title="Belum ada arsip" description="Arsip yang baru diunggah akan muncul di sini." icon="document" />
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="table-th">Kode</th>
                                    <th class="table-th">Judul</th>
                                    <th class="table-th">Klasifikasi</th>
                                    <th class="table-th">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($recentArchives as $archive)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="table-td font-mono text-xs text-indigo-600">{{ $archive->archive_code }}</td>
                                        <td class="table-td">
                                            <a href="{{ route('archives.show', $archive) }}" class="font-medium text-gray-900 hover:text-indigo-600 transition-colors">{{ Str::limit($archive->title, 40) }}</a>
                                        </td>
                                        <td class="table-td">
                                            <span class="badge bg-gray-100 text-gray-700">{{ $archive->classification }}</span>
                                        </td>
                                        <td class="table-td text-gray-500">{{ $archive->archive_date?->format('d M Y') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Aktivitas Terbaru</h2>
                </div>
                @if ($recentActivities->isEmpty())
                    <x-empty-state title="Belum ada aktivitas" description="Log aktivitas akan muncul di sini." icon="document" />
                @else
                    <ul class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                        @foreach ($recentActivities as $activity)
                            <li class="px-6 py-3.5 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <span class="badge {{ $activity->action_color }} shrink-0 mt-0.5">{{ $activity->action_label }}</span>
                                    <div class="min-w-0">
                                        <p class="text-sm text-gray-700 truncate">{{ $activity->description }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity->user?->name ?? 'System' }} · {{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
