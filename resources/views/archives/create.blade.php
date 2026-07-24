<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Tambah Arsip</h1>
    </x-slot>

    <div class="max-w-3xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('archives.store') }}" enctype="multipart/form-data" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="form-label">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="form-input @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Tanggal Arsip <span class="text-red-500">*</span></label>
                        <input type="date" name="archive_date" class="form-input @error('archive_date') border-red-500 @enderror" value="{{ old('archive_date', date('Y-m-d')) }}" required>
                        @error('archive_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Klasifikasi <span class="text-red-500">*</span></label>
                        <select name="classification" class="form-input @error('classification') border-red-500 @enderror" required>
                            <option value="">Pilih klasifikasi</option>
                            @foreach ($classifications as $cls)
                                <option value="{{ $cls }}" @selected(old('classification') === $cls)>{{ $cls }}</option>
                            @endforeach
                        </select>
                        @error('classification')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Folder</label>
                        <select name="folder_id" class="form-input @error('folder_id') border-red-500 @enderror">
                            <option value="">Root</option>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder->id }}" @selected(old('folder_id') == $folder->id)>{{ $folder->name }}</option>
                            @endforeach
                        </select>
                        @error('folder_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="form-label">File Dokumen <span class="text-red-500">*</span></label>
                        <input type="file" name="file" class="form-input @error('file') border-red-500 @enderror" required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                        <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX, JPG, PNG. Maks. 10 MB.</p>
                        @error('file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" rows="4" class="form-input @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="btn-primary" :disabled="loading">
                        <svg x-show="loading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Simpan Arsip
                    </button>
                    <a href="{{ route('archives.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
