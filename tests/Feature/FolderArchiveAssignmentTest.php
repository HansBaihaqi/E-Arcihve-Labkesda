<?php

namespace Tests\Feature;

use App\Models\Archive;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FolderArchiveAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_existing_archive_to_folder(): void
    {
        $user = User::factory()->create();
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $user->assignRole($role);

        $folder = Folder::create(['name' => 'Folder A', 'created_by' => $user->id]);
        $archive = Archive::create([
            'archive_code' => 'ARC-9001',
            'title' => 'Dokumen Lama',
            'description' => 'Ada',
            'classification' => 'Umum',
            'archive_date' => now()->toDateString(),
            'uploaded_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/folders/'.$folder->id.'/archives', [
            'archive_ids' => [$archive->id],
        ]);

        $response->assertRedirect(route('folders.show', $folder));
        $this->assertDatabaseHas('archives', ['id' => $archive->id, 'folder_id' => $folder->id]);
    }
}
