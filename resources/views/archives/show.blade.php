<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Detail Arsip</h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">
        <div class="card p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                <div>
                    <span class="badge bg-indigo-100 text-indigo-700 font-mono">{{ $archive->archive_code }}</span>
                    <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $archive->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Diunggah oleh {{ $archive->uploader?->name ?? '-' }} · {{ $archive->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if ($archive->file_path)
                        @can('download archives')
                            <a href="{{ route('archives.download', $archive) }}" class="btn-primary">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12M12 16.5V3" /></svg>
                                Download
                            </a>
                        @endcan
                        @if ($archive->isPdf())
                            <a href="{{ route('archives.preview', $archive) }}" target="_blank" class="btn-secondary">Preview PDF</a>
                        @endif
                    @endif
                    @can('update', $archive)
                        <a href="{{ route('archives.edit', $archive) }}" class="btn-secondary">Edit</a>
                    @endcan
                </div>
            </div>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Arsip</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $archive->archive_date?->format('d F Y') ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Klasifikasi</dt>
                    <dd class="mt-1"><span class="badge bg-gray-100 text-gray-700">{{ $archive->classification }}</span></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama File</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $archive->original_file_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Ukuran File</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $archive->formatted_file_size }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Ekstensi</dt>
                    <dd class="mt-1 text-sm text-gray-900 uppercase">{{ $archive->file_extension ?? '-' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $archive->description ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        @if ($archive->isPdf() && $archive->file_path)
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Preview PDF</h3>
                </div>
                <iframe src="{{ asset('storage/' . $archive->file_path) }}" class="w-full h-[600px] border-0"></iframe>
            </div>
        @endif

        <a href="{{ route('archives.index') }}" class="btn-secondary inline-flex">← Kembali ke Daftar</a>
    </div>
</x-app-layout>
