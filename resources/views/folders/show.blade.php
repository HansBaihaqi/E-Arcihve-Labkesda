<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">{{ $folder->name }}</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="card p-5">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">Induk: {{ $folder->parent?->name ?? 'Root' }}</p>
                    @if ($folder->description)
                        <p class="mt-1 text-sm text-gray-600">{{ $folder->description }}</p>
                    @endif
                </div>
                <a href="{{ route('folders.index') }}" class="btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="card p-5">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Subfolder</h2>
                    @can('create', App\Models\Folder::class)
                        <a href="{{ route('folders.create', ['parent_id' => $folder->id]) }}" class="btn-secondary text-sm">Tambah Subfolder</a>
                    @endcan
                </div>

                @if ($subfolders->isEmpty())
                    <x-empty-state title="Belum ada subfolder" description="Buat subfolder untuk mengelompokkan arsip lebih detail." icon="folder" />
                @else
                    <ul class="space-y-2">
                        @foreach ($subfolders as $subfolder)
                            <li class="flex items-center justify-between rounded-lg border border-gray-200 px-3 py-2">
                                <a href="{{ route('folders.show', $subfolder) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">{{ $subfolder->name }}</a>
                                <span class="text-xs text-gray-500">{{ $subfolder->children->count() }} subfolder</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="card p-5">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Arsip</h2>
                    @can('create', App\Models\Folder::class)
                        <button type="button" class="btn-secondary text-sm" onclick="document.getElementById('assign-archive-form').classList.toggle('hidden')">Masukkan Arsip</button>
                    @endcan
                </div>

                <form id="assign-archive-form" method="POST" action="{{ route('folders.assign-archives', $folder) }}" class="hidden mb-4 space-y-3 rounded-lg border border-dashed border-gray-300 p-3">
                    @csrf
                    <div class="flex items-center gap-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-input text-sm" placeholder="Cari arsip berdasarkan judul atau kode" />
                        <button type="submit" formaction="{{ route('folders.show', $folder) }}" formmethod="GET" class="btn-secondary text-sm">Cari</button>
                    </div>
                    @if ($availableArchives->isEmpty())
                        <p class="text-sm text-gray-500">Tidak ada arsip yang bisa dimasukkan.</p>
                    @else
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                            @foreach ($availableArchives as $archive)
                                <label class="flex items-center gap-2 rounded border border-gray-200 px-3 py-2 text-sm">
                                    <input type="checkbox" name="archive_ids[]" value="{{ $archive->id }}" class="rounded border-gray-300">
                                    <span>{{ $archive->title }} <span class="text-gray-400">({{ $archive->archive_code }})</span></span>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="btn-primary text-sm">Simpan</button>
                            <button type="button" class="btn-secondary text-sm" onclick="document.getElementById('assign-archive-form').classList.add('hidden')">Batal</button>
                        </div>
                    @endif
                </form>

                @if ($archives->isEmpty())
                    <x-empty-state title="Belum ada arsip" description="Arsip yang ditempatkan dalam folder ini akan muncul di sini." icon="document" />
                @else
                    <ul class="space-y-2">
                        @foreach ($archives as $archive)
                            <li class="flex items-center justify-between rounded-lg border border-gray-200 px-3 py-2">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $archive->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $archive->archive_code }}</p>
                                </div>
                                <a href="{{ route('archives.show', $archive) }}" class="text-sm text-indigo-600 hover:text-indigo-700">Lihat</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
