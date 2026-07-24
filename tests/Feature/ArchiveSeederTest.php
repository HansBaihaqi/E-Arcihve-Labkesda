<?php

namespace Tests\Feature;

use Database\Seeders\ArchiveSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArchiveSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_archive_seeder_can_run(): void
    {
        $this->seed(PermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(ArchiveSeeder::class);

        $this->assertDatabaseCount('archives', 5);
    }
}
