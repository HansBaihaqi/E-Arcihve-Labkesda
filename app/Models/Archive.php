<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archive extends Model
{
    protected $fillable = [
        'archive_code',
        'title',
        'description',
        'archive_date',
        'classification',
        'folder_id',
        'file_name',
        'original_file_name',
        'file_path',
        'file_size',
        'file_extension',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'archive_date' => 'date',
            'file_size' => 'integer',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if (! $this->file_size) {
            return '-';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2).' '.$units[$unit];
    }

    public function isPdf(): bool
    {
        return strtolower($this->file_extension ?? '') === 'pdf';
    }
}
