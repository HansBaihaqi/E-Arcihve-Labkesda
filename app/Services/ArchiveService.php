<?php

namespace App\Services;

use App\Models\Archive;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchiveService
{
    public function generateArchiveCode(): string
    {
        $year = now()->format('Y');
        $latest = Archive::whereYear('created_at', $year)->count() + 1;

        return sprintf('ARC-%s-%04d', $year, $latest);
    }

    public function handleFileUpload(UploadedFile $file): array
    {
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $storedName = Str::uuid()->toString().'.'.$extension;
        $path = $file->storeAs('archives', $storedName, 'public');

        return [
            'file_path' => $path,
            'file_name' => $storedName,
            'original_file_name' => $originalName,
            'file_size' => $file->getSize(),
            'file_extension' => $extension,
        ];
    }

    public function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
