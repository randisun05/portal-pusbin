<?php

namespace Tests\Feature;

use App\Models\Formulir;
use App\Models\FormulirSubmission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormulirTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    protected function makeFormulirWithFields(): Formulir
    {
        $formulir = Formulir::create([
            'judul' => 'Pendataan Kebutuhan Pelatihan',
            'slug' => 'pendataan-kebutuhan-pelatihan',
            'deskripsi' => 'Isi kebutuhan pelatihan Anda.',
            'status' => '1',
        ]);

        $formulir->fields()->create(['label' => 'Nama', 'tipe' => 'text', 'wajib' => true, 'urutan' => 0]);
        $formulir->fields()->create(['label' => 'Email', 'tipe' => 'email', 'wajib' => true, 'urutan' => 1]);
        $formulir->fields()->create(['label' => 'Unit Kerja', 'tipe' => 'select', 'opsi' => ['Pusat', 'Daerah'], 'wajib' => true, 'urutan' => 2]);
        $formulir->fields()->create(['label' => 'Minat Topik', 'tipe' => 'checkbox', 'opsi' => ['Kepemimpinan', 'Teknis', 'Manajerial'], 'wajib' => false, 'urutan' => 3]);
        $formulir->fields()->create(['label' => 'Kepuasan', 'tipe' => 'rating', 'wajib' => false, 'urutan' => 4]);
        $formulir->fields()->create(['label' => 'Dokumen Pendukung', 'tipe' => 'file', 'wajib' => false, 'urutan' => 5]);

        return $formulir;
    }

    // ---------- Admin: CRUD Formulir ----------

    public function test_admin_can_create_formulir_and_slug_is_generated()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/formulir', [
            'judul' => 'Formulir Uji Coba',
            'deskripsi' => 'Deskripsi uji',
            'status' => '1',
        ]);

        $formulir = Formulir::where('judul', 'Formulir Uji Coba')->firstOrFail();
        $response->assertRedirect("/admin/formulir/{$formulir->id}/field");
        $this->assertSame('formulir-uji-coba', $formulir->slug);
    }

    public function test_duplicate_judul_gets_unique_slug()
    {
        $admin = User::factory()->create();
        Formulir::create(['judul' => 'Formulir Sama', 'slug' => 'formulir-sama', 'status' => '1']);

        $this->actingAs($admin)->post('/admin/formulir', [
            'judul' => 'Formulir Sama',
            'status' => '1',
        ]);

        $this->assertDatabaseHas('formulirs', ['slug' => 'formulir-sama-2']);
    }

    public function test_guest_cannot_access_admin_formulir_routes()
    {
        $response = $this->get('/admin/formulir');
        $response->assertRedirect('/login');
    }

    public function test_role_without_permission_is_denied()
    {
        $role = Role::create(['name' => 'editor-terbatas-formulir', 'label' => 'Editor Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/formulir');
        $response->assertForbidden();
    }

    public function test_admin_can_delete_formulir_and_fields_cascade()
    {
        $admin = User::factory()->create();
        $formulir = $this->makeFormulirWithFields();
        $fieldId = $formulir->fields()->first()->id;

        $this->actingAs($admin)->delete("/admin/formulir/{$formulir->id}");

        $this->assertDatabaseMissing('formulirs', ['id' => $formulir->id]);
        $this->assertDatabaseMissing('formulir_fields', ['id' => $fieldId]);
    }

    // ---------- Admin: Field management ----------

    public function test_admin_can_add_field_with_opsi()
    {
        $admin = User::factory()->create();
        $formulir = Formulir::create(['judul' => 'F1', 'slug' => 'f1', 'status' => '1']);

        $this->actingAs($admin)->post("/admin/formulir/{$formulir->id}/field", [
            'label' => 'Jenis Kelamin',
            'tipe' => 'radio',
            'opsi' => "Laki-laki\nPerempuan",
            'wajib' => '1',
        ]);

        $field = $formulir->fields()->firstOrFail();
        $this->assertSame(['Laki-laki', 'Perempuan'], $field->opsi);
        $this->assertTrue($field->wajib);
    }

    public function test_field_reorder_swaps_urutan()
    {
        $admin = User::factory()->create();
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields()->orderBy('urutan')->get();
        $first = $fields[0];
        $second = $fields[1];

        $this->actingAs($admin)->post("/admin/formulir/{$formulir->id}/field/{$second->id}/naik");

        $this->assertSame(0, $second->fresh()->urutan);
        $this->assertSame(1, $first->fresh()->urutan);
    }

    public function test_admin_can_delete_field()
    {
        $admin = User::factory()->create();
        $formulir = $this->makeFormulirWithFields();
        $field = $formulir->fields()->first();

        $this->actingAs($admin)->delete("/admin/formulir/{$formulir->id}/field/{$field->id}");

        $this->assertDatabaseMissing('formulir_fields', ['id' => $field->id]);
    }

    // ---------- Public: listing & form rendering ----------

    public function test_public_index_only_shows_active_formulir()
    {
        Formulir::create(['judul' => 'Aktif', 'slug' => 'aktif', 'status' => '1']);
        Formulir::create(['judul' => 'Nonaktif', 'slug' => 'nonaktif', 'status' => '0']);

        $response = $this->get('/form');

        $response->assertOk();
        $response->assertSee('Aktif');
        $response->assertDontSee('Nonaktif');
    }

    public function test_inactive_formulir_create_page_returns_404()
    {
        $formulir = Formulir::create(['judul' => 'Nonaktif', 'slug' => 'nonaktif-2', 'status' => '0']);

        $response = $this->get("/form/{$formulir->slug}");

        $response->assertNotFound();
    }

    public function test_public_create_page_renders_all_field_types()
    {
        $formulir = $this->makeFormulirWithFields();

        $response = $this->get("/form/{$formulir->slug}");

        $response->assertOk();
        foreach ($formulir->fields as $field) {
            $response->assertSee($field->label);
        }
    }

    // ---------- Public: submission ----------

    public function test_submission_stores_data_json_correctly()
    {
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields->keyBy('label');

        $response = $this->post("/form/{$formulir->slug}", [
            'data' => [
                $fields['Nama']->id => 'Budi Santoso',
                $fields['Email']->id => 'budi@example.com',
                $fields['Unit Kerja']->id => 'Pusat',
                $fields['Minat Topik']->id => ['Teknis', 'Manajerial'],
                $fields['Kepuasan']->id => 4,
            ],
        ]);

        $response->assertRedirect(route('public.formulir.index'));
        $submission = FormulirSubmission::where('formulir_id', $formulir->id)->firstOrFail();
        $this->assertSame('Budi Santoso', $submission->jawabanUntuk($fields['Nama']));
        $this->assertSame(['Teknis', 'Manajerial'], $submission->jawabanUntuk($fields['Minat Topik']));
        $this->assertEquals(4, $submission->jawabanUntuk($fields['Kepuasan']));
    }

    public function test_submission_requires_wajib_fields()
    {
        $formulir = $this->makeFormulirWithFields();

        $response = $this->post("/form/{$formulir->slug}", [
            'data' => [],
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('formulir_submissions', 0);
    }

    public function test_submission_rejects_invalid_select_option()
    {
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields->keyBy('label');

        $response = $this->post("/form/{$formulir->slug}", [
            'data' => [
                $fields['Nama']->id => 'Budi',
                $fields['Email']->id => 'budi@example.com',
                $fields['Unit Kerja']->id => 'Bukan Opsi Valid',
            ],
        ]);

        $response->assertSessionHasErrors("data.{$fields['Unit Kerja']->id}");
    }

    public function test_submission_rejects_rating_out_of_range()
    {
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields->keyBy('label');

        $response = $this->post("/form/{$formulir->slug}", [
            'data' => [
                $fields['Nama']->id => 'Budi',
                $fields['Email']->id => 'budi@example.com',
                $fields['Unit Kerja']->id => 'Pusat',
                $fields['Kepuasan']->id => 9,
            ],
        ]);

        $response->assertSessionHasErrors("data.{$fields['Kepuasan']->id}");
    }

    public function test_submission_can_attach_file_to_specific_field()
    {
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields->keyBy('label');
        $file = UploadedFile::fake()->create('dokumen.pdf', 200, 'application/pdf');

        $response = $this->post("/form/{$formulir->slug}", [
            'data' => [
                $fields['Nama']->id => 'Budi',
                $fields['Email']->id => 'budi@example.com',
                $fields['Unit Kerja']->id => 'Pusat',
            ],
            'lampiran' => [
                $fields['Dokumen Pendukung']->id => $file,
            ],
        ]);

        $response->assertRedirect(route('public.formulir.index'));
        $submission = FormulirSubmission::where('formulir_id', $formulir->id)->firstOrFail();
        $lampiran = $submission->lampiranUntuk($fields['Dokumen Pendukung']);
        $this->assertNotNull($lampiran);
        $this->assertSame('dokumen.pdf', $lampiran->nama_asli);
        Storage::disk('public')->assertExists($lampiran->path);
    }

    public function test_file_field_is_optional_when_not_wajib()
    {
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields->keyBy('label');

        $response = $this->post("/form/{$formulir->slug}", [
            'data' => [
                $fields['Nama']->id => 'Budi',
                $fields['Email']->id => 'budi@example.com',
                $fields['Unit Kerja']->id => 'Pusat',
            ],
        ]);

        $response->assertRedirect(route('public.formulir.index'));
        $submission = FormulirSubmission::where('formulir_id', $formulir->id)->firstOrFail();
        $this->assertCount(0, $submission->lampirans);
    }

    public function test_honeypot_silently_blocks_bot_submission()
    {
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields->keyBy('label');

        $response = $this->post("/form/{$formulir->slug}", [
            'website' => 'http://spam.example.com',
            'data' => [
                $fields['Nama']->id => 'Bot',
                $fields['Email']->id => 'bot@example.com',
                $fields['Unit Kerja']->id => 'Pusat',
            ],
        ]);

        $response->assertRedirect(route('public.formulir.index'));
        $this->assertDatabaseCount('formulir_submissions', 0);
    }

    // ---------- Admin: submissions view ----------

    public function test_admin_submissions_view_shows_dynamic_columns_and_lampiran_link()
    {
        $admin = User::factory()->create();
        $formulir = $this->makeFormulirWithFields();
        $fields = $formulir->fields->keyBy('label');

        $submission = $formulir->submissions()->create([
            'data' => [
                $fields['Nama']->id => 'Budi Santoso',
                $fields['Email']->id => 'budi@example.com',
                $fields['Unit Kerja']->id => 'Pusat',
            ],
        ]);
        $submission->simpanLampiran(
            UploadedFile::fake()->create('bukti.pdf', 100, 'application/pdf'),
            'formulir',
            "field:{$fields['Dokumen Pendukung']->id}"
        );

        $response = $this->actingAs($admin)->get("/admin/formulir/{$formulir->id}/submissions");

        $response->assertOk();
        $response->assertSee('Budi Santoso');
        $response->assertSee('bukti.pdf');
    }
}
