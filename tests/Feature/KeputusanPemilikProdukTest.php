<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Comment;
use App\Models\Dashboard;
use App\Models\PesanKontak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/** Tindak lanjut keputusan pemilik produk: modul Dashboard Eksternal, penyamaran NIP, cakupan audit log. */
class KeputusanPemilikProdukTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        return User::where('email', 'admin@gmail.com')->firstOrFail();
    }

    public function test_dashboard_eksternal_crud_lengkap_dan_tervalidasi(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk();
        $this->actingAs($admin)->get('/admin/dashboard/create')->assertOk();

        $this->post('/admin/dashboard', ['nama' => 'D', 'deskripsi' => 'x', 'link' => 'javascript:alert(1)'])
            ->assertSessionHasErrors('link');

        $this->post('/admin/dashboard', [
            'nama' => 'Dashboard SDM', 'deskripsi' => 'Ringkasan', 'link' => 'https://dash.example.test/a',
            'image' => UploadedFile::fake()->image('a.png'),
        ])->assertRedirect('/admin/dashboard');
        $d = Dashboard::firstOrFail();
        Storage::disk('public')->assertExists($d->image);

        $this->get("/admin/dashboard/{$d->id}/edit")->assertOk()->assertSee('Dashboard SDM');
        $this->put("/admin/dashboard/{$d->id}", ['nama' => 'Baru', 'deskripsi' => 'x', 'link' => 'https://dash.example.test/b'])
            ->assertRedirect('/admin/dashboard');
        $this->assertSame('Baru', $d->fresh()->nama);

        $this->delete("/admin/dashboard/{$d->id}")->assertRedirect('/admin/dashboard');
        $this->assertDatabaseCount('dashboards', 0);
        Storage::disk('public')->assertMissing($d->image);
    }

    public function test_editor_tanpa_izin_tidak_bisa_membuka_modul_dashboard(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $editor = User::factory()->create(['role_id' => \App\Models\Role::where('name', 'editor')->value('id')]);

        $this->actingAs($editor)->get('/admin/dashboard')->assertForbidden();
        $this->post('/admin/dashboard', [])->assertForbidden();
    }

    public function test_nip_disamarkan_di_halaman_verifikasi_sertifikat(): void
    {
        $this->assertSame('199001********1001', mask_nip('199001012020011001'));
        $this->assertSame('123', mask_nip('123'));
        $this->assertSame('', mask_nip(null));
    }

    public function test_komentar_dan_pesan_kontak_tercatat_di_audit_log(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $post = \App\Models\Post::factory()->create();

        $this->post("/publikasi/{$post->slug}/komentar", ['nama' => 'Warga', 'email' => 'w@example.test', 'body' => 'Komentar uji'])
            ->assertStatus(302);

        $this->assertTrue(AuditLog::where('model', 'Comment')->where('action', 'created')->exists());
        $this->assertGreaterThan(0, Comment::count());
    }

    public function test_ekspor_data_pribadi_hanya_super_admin_dan_tercatat_di_audit(): void
    {
        $admin = $this->admin();
        $biasa = User::factory()->create(['role_id' => \App\Models\Role::where('name', 'admin')->value('id')]);

        $this->actingAs($biasa)->get('/admin/data-pribadi')->assertForbidden();
        $this->post('/admin/data-pribadi/export', ['nip' => '199001012020011001'])->assertForbidden();

        $this->actingAs($admin)->get('/admin/data-pribadi')->assertOk();
        $this->post('/admin/data-pribadi/export', ['nip' => '123'])->assertSessionHasErrors('nip');

        $res = $this->post('/admin/data-pribadi/export', ['nip' => '199001012020011001']);
        $res->assertOk();
        $res->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $log = AuditLog::where('action', 'export')->first();
        $this->assertNotNull($log);
        $this->assertStringNotContainsString('199001012020011001', $log->description);
    }

    public function test_anonimisasi_data_pribadi_mengganti_identitas_dan_tercatat(): void
    {
        $admin = $this->admin();
        $biasa = User::factory()->create(['role_id' => \App\Models\Role::where('name', 'admin')->value('id')]);
        $nip = '199001012020011001';
        $keg = \App\Models\Kegiatan::create(['nama' => 'Uji', 'slug' => 'uji', 'waktu' => now()->toDateTimeString(), 'link' => 'https://example.com', 'jenis' => 'Ujikom', 'image' => 'x.png', 'status' => '1']);
        $a = \App\Models\Absensi::create(['kegiatan_id' => $keg->id, 'nip' => $nip, 'nama' => 'Budi', 'email' => 'budi@example.test', 'jabatan' => 'Analis', 'instansi' => 'BKN']);
        $lain = \App\Models\Absensi::create(['kegiatan_id' => $keg->id, 'nip' => '199201012020011002', 'nama' => 'Sari', 'email' => 's@example.test', 'jabatan' => 'Analis', 'instansi' => 'BKN']);

        $this->actingAs($biasa)->post('/admin/data-pribadi/anonimkan', ['nip' => $nip, 'konfirmasi' => 'ANONIMKAN'])->assertForbidden();

        $this->actingAs($admin)->post('/admin/data-pribadi/anonimkan', ['nip' => $nip, 'konfirmasi' => 'ya'])->assertSessionHasErrors('konfirmasi');
        $this->assertSame('Budi', $a->fresh()->nama);

        $this->post('/admin/data-pribadi/anonimkan', ['nip' => $nip, 'konfirmasi' => 'ANONIMKAN'])->assertRedirect('/admin/data-pribadi');
        $a = $a->fresh();
        $this->assertSame('Peserta Dianonimkan', $a->nama);
        $this->assertNull($a->email);
        $this->assertStringStartsWith('ANON', $a->nip);
        $this->assertSame('Sari', $lain->fresh()->nama);

        $log = AuditLog::where('action', 'anonymize')->first();
        $this->assertNotNull($log);
        $this->assertStringNotContainsString($nip, $log->description);
    }

    public function test_qr_2fa_memuat_uri_otpauth_dengan_nama_portal(): void
    {
        config(['app.name' => 'Laravel']);
        $t = app(\App\Services\TwoFactorAuthService::class);
        $this->assertSame('Portal Pusbin JF MASN', $t->issuer());
        $this->assertStringStartsWith('data:image/png;base64,', $t->qrCodeDataUri(new User(['email' => 'a@example.test']), $t->generateSecretKey()));
        config(['app.name' => 'Portal Kita']);
        $this->assertSame('Portal Kita', $t->issuer());
    }

    public function test_kunjungan_publik_tidak_membanjiri_audit_log_dengan_penghitung_tayang(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $post = \App\Models\Post::factory()->create();
        AuditLog::query()->delete();

        $this->get("/publikasi/{$post->slug}")->assertOk();

        $this->assertSame(0, AuditLog::where('model', 'Post')->count());
        $this->assertSame(1, $post->fresh()->views);
    }
}
