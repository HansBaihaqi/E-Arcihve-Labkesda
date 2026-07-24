<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'subject_type', 'subject_id', 'description'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'login' => 'Login',
            'logout' => 'Logout',
            'create' => 'Tambah',
            'update' => 'Edit',
            'delete' => 'Hapus',
            default => ucfirst($this->action),
        };
    }

    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'login' => 'bg-blue-100 text-blue-700',
            'logout' => 'bg-gray-100 text-gray-700',
            'create' => 'bg-emerald-100 text-emerald-700',
            'update' => 'bg-amber-100 text-amber-700',
            'delete' => 'bg-red-100 text-red-700',
            default => 'bg-slate-100 text-slate-700',
        };
    }
}
