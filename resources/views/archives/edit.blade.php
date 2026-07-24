<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Edit Arsip</h1>
    </x-slot>

    <div class="max-w-3xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('archives.update', $archive) }}" enctype="multipart/form-data" x-data="{ loading: false }" @submit="loading = true">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="form-label">Kode Arsip</label>
                        <input type="text" class="form-input bg-gray-50" value="{{ $archive->archive_code }}" disabled>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="form-label">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="form-input @error('title') border-red-500 @enderror" value="{{ old('title', $archive->title) }}" required>
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Tanggal Arsip <span class="text-red-500">*</span></label>
                        <input type="date" name="archive_date" class="form-input @error('archive_date') border-red-500 @enderror" value="{{ old('archive_date', $archive->archive_date?->format('Y-m-d')) }}" required>
                        @error('archive_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Klasifikasi <span class="text-red-500">*</span></label>
                        <select name="classification" class="form-input @error('classification') border-red-500 @enderror" required>
                            @foreach ($classifications as $cls)
                                <option value="{{ $cls }}" @selected(old('classification', $archive->classification) === $cls)>{{ $cls }}</option>
                            @endforeach
                        </select>
                        @error('classification')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="form-label">File Dokumen</label>
                        @if ($archive->original_file_name)
                            <p class="text-sm text-gray-500 mb-2">File saat ini: <span class="font-medium">{{ $archive->original_file_name }}</span> ({{ $archive->formatted_file_size }})</p>
                        @endif
                        <input type="file" name="file" class="form-input @error('file') border-red-500 @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti file.</p>
                        @error('file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" rows="4" class="form-input">{{ old('description', $archive->description) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="btn-primary" :disabled="loading">Perbarui Arsip</button>
                    <a href="{{ route('archives.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
