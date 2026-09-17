<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\PengaturanSertifikat;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Sertifikat;
use App\Models\SertifikatTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SertifikatTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAbsensi(): Absensi
    {
        $kegiatan = Kegiatan::create([
            'nama' => 'Ujikom Periode I',
            'slug' => 'ujikom-periode-i',
            'waktu' => now()->toDateTimeString(),
            'link' => 'https://example.com',
            'jenis' => 'Ujikom',
            'image' => 'post-image/dummy.png',
            'status' => '1',
        ]);

        return Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'nip' => '199001012020011001',
            'nama' => 'Peserta Ujikom',
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);
    }

    public function test_admin_can_create_template_with_logo_upload()
    {
        Storage::fake('local');
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/sertifikat-template', [
            'nama' => 'Template Emas',
            'warna_aksen' => '#0d6efd',
            'teks_pembuka' => 'Diberikan kepada:',
            'teks_keterangan' => 'Atas partisipasinya dalam {kegiatan}.',
            'logo' => UploadedFile::fake()->image('logo.png'),
            'is_default' => '1',
        ]);

        $response->assertRedirect('/admin/sertifikat-template');
        $this->assertDatabaseHas('sertifikat_templates', ['nama' => 'Template Emas', 'is_default' => true]);
        $template = SertifikatTemplate::first();
        Storage::disk('local')->assertExists($template->logo);
    }

    public function test_only_one_template_can_be_default()
    {
        $admin = User::factory()->create();
        $t1 = SertifikatTemplate::create(['nama' => 'A', 'is_default' => true, 'teks_keterangan' => 'x']);

        $this->actingAs($admin)->post('/admin/sertifikat-template', [
            'nama' => 'B',
            'warna_aksen' => '#000000',
            'teks_pembuka' => 'x',
            'teks_keterangan' => 'x',
            'is_default' => '1',
        ]);

        $this->assertFalse($t1->fresh()->is_default);
        $this->assertTrue(SertifikatTemplate::where('nama', 'B')->first()->is_default);
    }

    public function test_template_in_use_cannot_be_deleted()
    {
        $admin = User::factory()->create();
        $template = SertifikatTemplate::create(['nama' => 'A', 'teks_keterangan' => 'x']);
        $absensi = $this->makeAbsensi();
        Sertifikat::create([
            'absensi_id' => $absensi->id,
            'template_id' => $template->id,
            'nomor_sertifikat' => Sertifikat::generateNomor(),
        ]);

        $response = $this->actingAs($admin)->delete("/admin/sertifikat-template/{$template->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('sertifikat_templates', ['id' => $template->id]);
    }

    public function test_unused_template_can_be_deleted()
    {
        $admin = User::factory()->create();
        $template = SertifikatTemplate::create(['nama' => 'A', 'teks_keterangan' => 'x']);

        $response = $this->actingAs($admin)->delete("/admin/sertifikat-template/{$template->id}");

        $response->assertRedirect('/admin/sertifikat-template');
        $this->assertDatabaseMissing('sertifikat_templates', ['id' => $template->id]);
    }

    public function test_issuing_certificate_defaults_to_default_template()
    {
        $admin = User::factory()->create();
        SertifikatTemplate::create(['nama' => 'Bukan Default', 'teks_keterangan' => 'x']);
        $default = SertifikatTemplate::create(['nama' => 'Default', 'teks_keterangan' => 'x', 'is_default' => true]);
        $absensi = $this->makeAbsensi();

        $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");

        $this->assertDatabaseHas('sertifikats', ['absensi_id' => $absensi->id, 'template_id' => $default->id]);
    }

    public function test_certificate_pdf_uses_template_custom_text_and_color()
    {
        $admin = User::factory()->create();
        $template = SertifikatTemplate::create([
            'nama' => 'Template Khusus',
            'warna_aksen' => '#123456',
            'teks_pembuka' => 'Dengan bangga diberikan kepada:',
            'teks_keterangan' => 'Telah lulus {kegiatan} sebagai {jabatan}.',
            'is_default' => true,
        ]);
        $absensi = $this->makeAbsensi();
        $this->actingAs($admin)->post("/admin/sertifikat/{$absensi->id}/issue");
        $sertifikat = Sertifikat::where('absensi_id', $absensi->id)->first();

        $response = $this->actingAs($admin)->get("/admin/sertifikat/{$sertifikat->id}/cetak");

        $response->assertOk();
        $response->assertSee('Dengan bangga diberikan kepada:');
        $response->assertSee('#123456', false);
        $response->assertSee('Telah lulus Ujikom Periode I sebagai Analis.');
        $response->assertDontSee('{kegiatan}');
        $response->assertDontSee('{jabatan}');
    }

    public function test_admin_can_switch_template_on_issued_certificate()
    {
        $admin = User::factory()->create();
        $templateA = SertifikatTemplate::create(['nama' => 'A', 'teks_keterangan' => 'x']);
        $templateB = SertifikatTemplate::create(['nama' => 'B', 'teks_keterangan' => 'x']);
        $absensi = $this->makeAbsensi();
        $sertifikat = Sertifikat::create([
            'absensi_id' => $absensi->id,
            'template_id' => $templateA->id,
            'nomor_sertifikat' => Sertifikat::generateNomor(),
        ]);

        $response = $this->actingAs($admin)->post("/admin/sertifikat/{$sertifikat->id}/template", [
            'template_id' => $templateB->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('sertifikats', ['id' => $sertifikat->id, 'template_id' => $templateB->id]);
    }

    public function test_numbering_settings_control_generated_certificate_number()
    {
        PengaturanSertifikat::create(['prefix' => 'BUKTI', 'digit_urut' => 3, 'reset_tahunan' => true]);

        $nomor = Sertifikat::generateNomor();

        $this->assertSame('BUKTI/' . date('Y') . '/001', $nomor);
    }

    public function test_numbering_without_yearly_reset_keeps_counting()
    {
        PengaturanSertifikat::create(['prefix' => 'SERT', 'digit_urut' => 5, 'reset_tahunan' => false]);
        $absensi = $this->makeAbsensi();
        Sertifikat::create(['absensi_id' => $absensi->id, 'nomor_sertifikat' => 'SERT/2020/00001']);

        $nomor = Sertifikat::generateNomor();

        $this->assertSame('SERT/' . date('Y') . '/00002', $nomor);
    }

    public function test_admin_can_update_numbering_settings()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->put('/admin/pengaturan-sertifikat', [
            'prefix' => 'CERT',
            'digit_urut' => 6,
            'reset_tahunan' => '0',
        ]);

        $response->assertRedirect('/admin/pengaturan-sertifikat');
        $this->assertDatabaseHas('pengaturan_sertifikats', ['prefix' => 'CERT', 'digit_urut' => 6, 'reset_tahunan' => false]);
    }

    public function test_role_without_permission_is_denied_template_access()
    {
        $role = Role::create(['name' => 'staf-terbatas-sertifikat', 'label' => 'Staf Terbatas']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/sertifikat-template');

        $response->assertForbidden();
    }

    public function test_role_with_permission_can_access_template_management()
    {
        $permission = Permission::create([
            'slug' => 'manage-sertifikat-template',
            'label' => 'Kelola Template & Penomoran Sertifikat',
            'grup' => 'Operasional',
        ]);
        $role = Role::create(['name' => 'staf-sertifikat', 'label' => 'Staf Sertifikat']);
        $role->permissions()->attach($permission->id);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/admin/sertifikat-template');

        $response->assertOk();
    }

    public function test_visiting_role_edit_self_heals_missing_permission_definition()
    {
        // Simulasikan database lama sebelum permission baru ditambahkan.
        Permission::where('slug', 'manage-sertifikat-template')->delete();
        $this->assertDatabaseMissing('permissions', ['slug' => 'manage-sertifikat-template']);

        $admin = User::factory()->create();
        $role = Role::create(['name' => 'staf-lain', 'label' => 'Staf Lain']);

        $this->actingAs($admin)->get("/admin/role/{$role->id}/edit")->assertOk();

        $this->assertDatabaseHas('permissions', ['slug' => 'manage-sertifikat-template']);
    }
}
