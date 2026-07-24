<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Manajemen Folder</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Buat folder, subfolder, dan kelola hierarki arsip.</p>
            @can('create', App\Models\Folder::class)
                <a href="{{ route('folders.create') }}" class="btn-primary">Tambah Folder</a>
            @endcan
        </div>

        <div class="card p-6">
            @if ($folders->isEmpty())
                <x-empty-state title="Belum ada folder" description="Buat folder utama untuk memulai hierarki arsip." icon="folder" />
            @else
                <ul class="space-y-3">
                    @foreach ($folders as $folder)
                        <li class="rounded-lg border border-gray-200 px-4 py-3">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <a href="{{ route('folders.show', $folder) }}" class="font-semibold text-indigo-600 hover:text-indigo-700">{{ $folder->name }}</a>
                                    @if ($folder->description)
                                        <p class="text-sm text-gray-500">{{ $folder->description }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400">Induk: {{ $folder->parent?->name ?? 'Root' }}</p>
                                </div>
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-600">{{ $folder->children->count() }} subfolder</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
