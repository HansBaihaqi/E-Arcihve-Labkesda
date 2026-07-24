@php
    $sortLink = function ($column) use ($sort, $direction) {
        $newDirection = ($sort === $column && $direction === 'asc') ? 'desc' : 'asc';
        return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $newDirection]);
    };
@endphp

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Arsip Dokumen</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-500">Kelola dan cari dokumen arsip laboratorium.</p>
            @can('create archives')
                <a href="{{ route('archives.create') }}" class="btn-primary shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Arsip
                </a>
            @endcan
        </div>

        <div class="card p-5">
            <form method="GET" action="{{ route('archives.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-input" placeholder="Judul, kode, deskripsi..." value="{{ $search ?? '' }}">
                </div>
                <div>
                    <label class="form-label">Klasifikasi</label>
                    <select name="classification" class="form-input">
                        <option value="">Semua</option>
                        @foreach ($classifications as $cls)
                            <option value="{{ $cls }}" @selected(($classification ?? '') === $cls)>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-input" value="{{ $dateFrom ?? '' }}">
                </div>
                <div>
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-input" value="{{ $dateTo ?? '' }}">
                </div>
                <div class="sm:col-span-2 lg:col-span-5 flex gap-2">
                    <button type="submit" class="btn-primary">Filter</button>
                    <a href="{{ route('archives.index') }}" class="btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="card overflow-hidden">
            @if ($archives->isEmpty())
                <x-empty-state title="Tidak ada arsip ditemukan" description="Coba ubah filter pencarian atau tambahkan arsip baru." icon="document">
                    <x-slot name="action">
                        @can('create archives')
                            <a href="{{ route('archives.create') }}" class="btn-primary">Tambah Arsip</a>
                        @endcan
                    </x-slot>
                </x-empty-state>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="table-th">
                                    <a href="{{ $sortLink('archive_code') }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Kode @if($sort === 'archive_code')<span class="text-indigo-500">{{ $direction === 'asc' ? '↑' : '↓' }}</span>@endif
                                    </a>
                                </th>
                                <th class="table-th">
                                    <a href="{{ $sortLink('title') }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Judul @if($sort === 'title')<span class="text-indigo-500">{{ $direction === 'asc' ? '↑' : '↓' }}</span>@endif
                                    </a>
                                </th>
                                <th class="table-th">
                                    <a href="{{ $sortLink('classification') }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Klasifikasi @if($sort === 'classification')<span class="text-indigo-500">{{ $direction === 'asc' ? '↑' : '↓' }}</span>@endif
                                    </a>
                                </th>
                                <th class="table-th">
                                    <a href="{{ $sortLink('archive_date') }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Tanggal @if($sort === 'archive_date')<span class="text-indigo-500">{{ $direction === 'asc' ? '↑' : '↓' }}</span>@endif
                                    </a>
                                </th>
                                <th class="table-th">File</th>
                                <th class="table-th text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($archives as $archive)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="table-td font-mono text-xs text-indigo-600">{{ $archive->archive_code }}</td>
                                    <td class="table-td font-medium text-gray-900 max-w-xs truncate">{{ $archive->title }}</td>
                                    <td class="table-td"><span class="badge bg-gray-100 text-gray-700">{{ $archive->classification }}</span></td>
                                    <td class="table-td text-gray-500">{{ $archive->archive_date?->format('d M Y') ?? '-' }}</td>
                                    <td class="table-td text-gray-500">{{ $archive->original_file_name ?? '-' }}</td>
                                    <td class="table-td">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('archives.show', $archive) }}" class="btn-ghost" title="Detail">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                            </a>
                                            @if ($archive->file_path)
                                                @can('download archives')
                                                    <a href="{{ route('archives.download', $archive) }}" class="btn-ghost text-emerald-600" title="Download">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12M12 16.5V3" /></svg>
                                                    </a>
                                                @endcan
                                            @endif
                                            @can('update', $archive)
                                                <a href="{{ route('archives.edit', $archive) }}" class="btn-ghost" title="Edit">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                                </a>
                                            @endcan
                                            @can('delete', $archive)
                                                <form action="{{ route('archives.destroy', $archive) }}" method="POST" x-data x-ref="form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" @click="if(confirm('Hapus arsip ini?')) $refs.form.submit()" class="btn-ghost text-red-600" title="Hapus">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $archives->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
