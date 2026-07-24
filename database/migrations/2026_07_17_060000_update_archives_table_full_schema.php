<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('archives', function (Blueprint $table) {
            if (! Schema::hasColumn('archives', 'archive_code')) {
                $table->string('archive_code')->nullable()->after('id');
            }
            if (! Schema::hasColumn('archives', 'archive_date')) {
                $table->date('archive_date')->nullable()->after('description');
            }
            if (! Schema::hasColumn('archives', 'classification')) {
                $table->string('classification')->nullable()->after('archive_date');
            }
            if (! Schema::hasColumn('archives', 'original_file_name')) {
                $table->string('original_file_name')->nullable()->after('file_name');
            }
            if (! Schema::hasColumn('archives', 'file_size')) {
                $table->unsignedBigInteger('file_size')->nullable()->after('file_path');
            }
            if (! Schema::hasColumn('archives', 'file_extension')) {
                $table->string('file_extension', 20)->nullable()->after('file_size');
            }
            if (! Schema::hasColumn('archives', 'uploaded_by')) {
                $table->foreignId('uploaded_by')->nullable()->after('file_extension')->constrained('users')->nullOnDelete();
            }
        });

        $archives = DB::table('archives')->whereNull('archive_code')->orWhere('archive_code', '')->get();
        foreach ($archives as $index => $archive) {
            DB::table('archives')->where('id', $archive->id)->update([
                'archive_code' => 'ARC-2026-'.str_pad($archive->id, 4, '0', STR_PAD_LEFT),
                'classification' => $archive->category ?? 'Umum',
                'archive_date' => $archive->created_at ?? now(),
            ]);
        }

        if (Schema::hasColumn('archives', 'category')) {
            Schema::table('archives', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }

        Schema::table('archives', function (Blueprint $table) {
            $table->string('archive_code')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn([
                'archive_code',
                'archive_date',
                'classification',
                'original_file_name',
                'file_size',
                'file_extension',
                'uploaded_by',
            ]);
        });
    }
};
