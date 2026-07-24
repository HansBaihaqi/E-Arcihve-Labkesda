<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Tambah Folder</h1>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card p-6">
            <form method="POST" action="{{ route('folders.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="form-label">Nama Folder <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                </div>

                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-input">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Parent Folder</label>
                    <select name="parent_id" class="form-input">
                        <option value="">Root</option>
                        @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}" @selected(old('parent_id', $parentId ?? '') == $folder->id)>{{ $folder->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-primary">Simpan Folder</button>
                    <a href="{{ route('folders.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
