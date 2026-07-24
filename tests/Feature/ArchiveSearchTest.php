<?php

namespace Tests\Feature;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArchiveSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_archive_index_can_filter_by_title(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Archive::create([
            'archive_code' => 'ARC-2026-0001',
            'title' => 'Surat Keputusan 2024',
            'description' => 'Alpha',
            'classification' => 'Umum',
            'archive_date' => now()->toDateString(),
            'uploaded_by' => $user->id,
        ]);

        Archive::create([
            'archive_code' => 'ARC-2026-0002',
            'title' => 'Laporan Bulanan',
            'description' => 'Beta',
            'classification' => 'Internal',
            'archive_date' => now()->toDateString(),
            'uploaded_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/archives?search=Surat');

        $response->assertStatus(200);
        $response->assertSee('Surat Keputusan 2024');
        $response->assertDontSee('Laporan Bulanan');
    }
}
