<?php

namespace Tests\Feature;

use App\Models\Jdihjfk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_document_without_link_or_image()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/repository', [
            'title' => 'Pengetahuan Internal',
            'deskripsi' => 'Isi pengetahuan tanpa dokumen fisik.',
            'status' => Jdihjfk::STATUS_INTERNAL,
        ]);

        $response->assertRedirect('/admin/repository');
        $this->assertDatabaseHas('jdihjfks', [
            'title' => 'Pengetahuan Internal',
            'status' => Jdihjfk::STATUS_INTERNAL,
            'link' => null,
            'image' => null,
        ]);
    }

    public function test_admin_can_update_document_status()
    {
        $admin = User::factory()->create();
        $doc = Jdihjfk::create([
            'title' => 'Dokumen',
            'deskripsi' => 'Deskripsi',
            'status' => Jdihjfk::STATUS_INTERNAL,
        ]);

        $response = $this->actingAs($admin)->put("/admin/repository/{$doc->id}", [
            'title' => 'Dokumen',
            'deskripsi' => 'Deskripsi',
            'status' => Jdihjfk::STATUS_PUBLISHED,
        ]);

        $response->assertRedirect('/admin/repository');
        $this->assertDatabaseHas('jdihjfks', ['id' => $doc->id, 'status' => Jdihjfk::STATUS_PUBLISHED]);
    }

    public function test_admin_can_delete_document()
    {
        $admin = User::factory()->create();
        $doc = Jdihjfk::create([
            'title' => 'Dokumen',
            'deskripsi' => 'Deskripsi',
            'status' => Jdihjfk::STATUS_PUBLISHED,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/repository/{$doc->id}");

        $response->assertRedirect('/admin/repository');
        $this->assertDatabaseMissing('jdihjfks', ['id' => $doc->id]);
    }

    public function test_admin_listing_shows_both_published_and_internal_documents()
    {
        $admin = User::factory()->create();
        Jdihjfk::create(['title' => 'Dokumen Publik', 'deskripsi' => 'x', 'status' => Jdihjfk::STATUS_PUBLISHED]);
        Jdihjfk::create(['title' => 'Dokumen Internal', 'deskripsi' => 'x', 'status' => Jdihjfk::STATUS_INTERNAL]);

        $response = $this->actingAs($admin)->get('/admin/repository');

        $response->assertOk();
        $response->assertSee('Dokumen Publik');
        $response->assertSee('Dokumen Internal');
    }
}
