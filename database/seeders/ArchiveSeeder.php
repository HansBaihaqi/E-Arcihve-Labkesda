<?php

namespace Database\Seeders;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArchiveSeeder extends Seeder
{
    public function run(): void
    {
        $uploader = User::where('email', 'admin@example.com')->first();

        if (! $uploader) {
            return;
        }

        $archives = [
            [
                'archive_code' => 'ARC-2026-0001',
                'title' => 'Laporan Pemeriksaan Air Minum Q1 2026',
                'description' => 'Laporan hasil pemeriksaan kualitas air minum triwulan pertama tahun 2026.',
                'archive_date' => '2026-01-15',
                'classification' => 'Umum',
                'file_name' => 'laporan-air-q1-2026.pdf',
                'original_file_name' => 'Laporan_Air_Q1_2026.pdf',
                'file_path' => null,
                'file_size' => 245760,
                'file_extension' => 'pdf',
                'uploaded_by' => $uploader->id,
            ],
            [
                'archive_code' => 'ARC-2026-0002',
                'title' => 'SOP Pengambilan Sampel Makanan',
                'description' => 'Standar operasional prosedur pengambilan sampel makanan di laboratorium.',
                'archive_date' => '2026-02-10',
                'classification' => 'Internal',
                'file_name' => 'sop-sampel-makanan.pdf',
                'original_file_name' => 'SOP_Sampel_Makanan.pdf',
                'file_path' => null,
                'file_size' => 512000,
                'file_extension' => 'pdf',
                'uploaded_by' => $uploader->id,
            ],
            [
                'archive_code' => 'ARC-2026-0003',
                'title' => 'Berita Acara Kalibrasi Alat Lab',
                'description' => 'Dokumen berita acara kalibrasi peralatan laboratorium kesehatan.',
                'archive_date' => '2026-03-05',
                'classification' => 'Rahasia',
                'file_name' => 'ba-kalibrasi-alat.pdf',
                'original_file_name' => 'BA_Kalibrasi_Alat.pdf',
                'file_path' => null,
                'file_size' => 189440,
                'file_extension' => 'pdf',
                'uploaded_by' => $uploader->id,
            ],
            [
                'archive_code' => 'ARC-2026-0004',
                'title' => 'Rekap Hasil Uji Mikrobiologi',
                'description' => 'Rekapitulasi hasil uji mikrobiologi sampel lingkungan bulan Maret 2026.',
                'archive_date' => '2026-03-20',
                'classification' => 'Umum',
                'file_name' => 'rekap-uji-mikrobiologi.xlsx',
                'original_file_name' => 'Rekap_Uji_Mikrobiologi_Mar2026.xlsx',
                'file_path' => null,
                'file_size' => 98304,
                'file_extension' => 'xlsx',
                'uploaded_by' => $uploader->id,
            ],
            [
                'archive_code' => 'ARC-2026-0005',
                'title' => 'Surat Keputusan Penetapan Tim Lab',
                'description' => 'SK penetapan tim kerja laboratorium kesehatan daerah.',
                'archive_date' => '2026-04-01',
                'classification' => 'Internal',
                'file_name' => 'sk-tim-lab.pdf',
                'original_file_name' => 'SK_Tim_Lab_2026.pdf',
                'file_path' => null,
                'file_size' => 327680,
                'file_extension' => 'pdf',
                'uploaded_by' => $uploader->id,
            ],
        ];

        foreach ($archives as $archive) {
            Archive::firstOrCreate(
                ['archive_code' => $archive['archive_code']],
                $archive
            );
        }
    }
}
