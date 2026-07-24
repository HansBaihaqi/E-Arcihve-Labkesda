<?php

namespace Tests\Feature;

use App\Models\Archive;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FolderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_folder(): void
    {
        $user = User::factory()->create();
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $user->assignRole($role);

        $response = $this->actingAs($user)->post('/folders', [
            'name' => 'Folder Utama',
            'description' => 'Folder tes',
        ]);

        $response->assertRedirect(route('folders.index'));
        $this->assertDatabaseHas('folders', ['name' => 'Folder Utama']);
    }

    public function test_archives_can_be_assigned_to_folder_and_folder_view_can_open_it(): void
    {
        $user = User::factory()->create();
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $user->assignRole($role);

        $folder = Folder::create(['name' => 'Root Folder', 'created_by' => $user->id]);
        $child = Folder::create(['name' => 'Sub Folder', 'parent_id' => $folder->id, 'created_by' => $user->id]);

        $archive = Archive::create([
            'archive_code' => 'ARC-0001',
            'title' => 'Surat Uji',
            'description' => 'Contoh',
            'classification' => 'Umum',
            'archive_date' => now()->toDateString(),
            'uploaded_by' => $user->id,
            'folder_id' => $child->id,
        ]);

        $response = $this->actingAs($user)->get('/folders/'.$child->id);

        $response->assertStatus(200);
        $response->assertSee($child->name);
        $response->assertSee($archive->title);
    }

    public function test_user_cannot_create_folder(): void
    {
        $user = User::factory()->create();
        $user->assignRole('User');

        $response = $this->actingAs($user)->get('/folders/create');

        $response->assertStatus(403);
    }
}
