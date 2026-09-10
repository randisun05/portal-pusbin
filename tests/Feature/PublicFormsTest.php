<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Faq;
use App\Models\Jdihjfk;
use App\Models\Kegiatan;
use App\Models\PesanKontak;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\Survei;
use App\Models\SurveiGroup;
use App\Models\SurveiIndikator;
use App\Models\SurveiPublic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PublicFormsTest extends TestCase
{
    use RefreshDatabase;

    protected function makeKegiatan(array $overrides = []): Kegiatan
    {
        return Kegiatan::create(array_merge([
            'nama' => 'Sosialisasi Uji Coba',
            'slug' => 'sosialisasi-uji-coba',
            'waktu' => now()->addDay()->toDateTimeString(),
            'link' => 'https://example.com/zoom',
            'jenis' => 'Sosialisasi',
            'image' => 'post-image/dummy.png',
            'status' => '1',
        ], $overrides));
    }

    public function test_kontak_form_creates_pesan_kontak()
    {
        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'pesan' => 'Pertanyaan tentang layanan.',
        ]);

        $response->assertRedirect('/about/kontak-kami');
        $this->assertDatabaseHas('pesan_kontaks', ['email' => 'budi@example.com']);
    }

    public function test_kontak_form_honeypot_silently_blocks_bot()
    {
        $response = $this->post('/about/kontak-kami', [
            'nama' => 'Bot',
            'email' => 'bot@example.com',
            'pesan' => 'Spam',
            'website' => 'http://spam.example.com',
        ]);

        $response->assertRedirect('/about/kontak-kami');
        $this->assertDatabaseMissing('pesan_kontaks', ['email' => 'bot@example.com']);
    }

    public function test_absensi_registration_creates_record_and_sends_email()
    {
        Mail::fake();
        $kegiatan = $this->makeKegiatan();

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011001',
            'nama' => 'Peserta Satu',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);

        $response->assertRedirect(route('public.absensi.index'));
        $this->assertDatabaseHas('absensis', ['nip' => '199001012020011001', 'kegiatan_id' => $kegiatan->id]);
        Mail::assertQueued(\App\Mail\SendEmailAbsensi::class);
    }

    public function test_absensi_registration_rejects_duplicate_nip_for_same_kegiatan()
    {
        Mail::fake();
        $kegiatan = $this->makeKegiatan();
        Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'nip' => '199001012020011001',
            'nama' => 'Peserta Satu',
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);

        $response = $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011001',
            'nama' => 'Peserta Satu',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'peserta@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertSame(1, Absensi::where('nip', '199001012020011001')->count());
    }

    public function test_absensi_registration_honeypot_silently_blocks_bot()
    {
        Mail::fake();
        $kegiatan = $this->makeKegiatan();

        $this->post("/absensi/{$kegiatan->slug}/store", [
            'nip' => '199001012020011002',
            'nama' => 'Bot',
            'kegiatan_id' => $kegiatan->id,
            'email' => 'bot@example.com',
            'jabatan' => 'Analis',
            'instansi' => 'BKN',
            'website' => 'http://spam.example.com',
        ]);

        $this->assertDatabaseMissing('absensis', ['nip' => '199001012020011002']);
        Mail::assertNothingSent();
    }

    public function test_comment_submission_requires_admin_approval_before_visible()
    {
        $category = Category::create(['name' => 'Umum', 'slug' => 'umum']);
        $author = User::factory()->create();
        $post = Post::create([
            'category_id' => $category->id,
            'user_id' => $author->id,
            'title' => 'Berita Uji Coba',
            'slug' => 'berita-uji-coba',
            'excerpt' => 'Ringkasan',
            'body' => '<p>Isi berita</p>',
            'publish_at' => now()->toDateString(),
        ]);

        $response = $this->post("/publikasi/{$post->slug}/komentar", [
            'nama' => 'Pembaca',
            'email' => 'pembaca@example.com',
            'body' => 'Komentar yang bagus.',
        ]);

        $response->assertRedirect();
        $comment = Comment::where('post_id', $post->id)->first();
        $this->assertNotNull($comment);
        $this->assertFalse((bool) $comment->approved);
    }

    public function test_reaction_can_be_recorded()
    {
        $category = Category::create(['name' => 'Umum', 'slug' => 'umum']);
        $author = User::factory()->create();
        $post = Post::create([
            'category_id' => $category->id,
            'user_id' => $author->id,
            'title' => 'Berita Reaksi',
            'slug' => 'berita-reaksi',
            'excerpt' => 'Ringkasan',
            'body' => '<p>Isi berita</p>',
            'publish_at' => now()->toDateString(),
        ]);

        $response = $this->postJson("/publikasi/{$post->slug}/react", ['type' => 'suka']);

        $response->assertOk();
        $this->assertDatabaseHas('reactions', ['post_id' => $post->id, 'type' => 'suka']);
    }

    public function test_survei_submission_stores_answers_for_each_indicator()
    {
        $survei = Survei::create(['title' => 'Survei Uji Coba', 'type' => 1]);
        $indikator = SurveiIndikator::create(['title' => 'Kepuasan Layanan']);
        SurveiGroup::create(['survei_id' => $survei->id, 'indikator_id' => $indikator->id]);

        $response = $this->post("/survei/{$survei->id}", [
            'nip' => '199001012020011001',
            'jawaban' => [$indikator->id => 'Sangat Puas'],
        ]);

        $response->assertRedirect('/survei');
        $this->assertDatabaseHas('survei_publics', [
            'survei_id' => $survei->id,
            'indikator_id' => $indikator->id,
            'velue' => 'Sangat Puas',
        ]);
    }

    public function test_survei_submission_honeypot_silently_blocks_bot()
    {
        $survei = Survei::create(['title' => 'Survei Uji Coba', 'type' => 1]);
        $indikator = SurveiIndikator::create(['title' => 'Kepuasan Layanan']);
        SurveiGroup::create(['survei_id' => $survei->id, 'indikator_id' => $indikator->id]);

        $this->post("/survei/{$survei->id}", [
            'nip' => '199001012020011099',
            'jawaban' => [$indikator->id => 'Sangat Puas'],
            'website' => 'http://spam.example.com',
        ]);

        $this->assertDatabaseMissing('survei_publics', ['nip' => '199001012020011099']);
    }

    public function test_repository_public_page_only_shows_published_documents()
    {
        Jdihjfk::create([
            'title' => 'Dokumen Publik',
            'deskripsi' => 'Deskripsi publik',
            'status' => Jdihjfk::STATUS_PUBLISHED,
        ]);
        Jdihjfk::create([
            'title' => 'Dokumen Internal',
            'deskripsi' => 'Deskripsi internal',
            'status' => Jdihjfk::STATUS_INTERNAL,
        ]);

        $response = $this->get('/repository');

        $response->assertOk();
        $response->assertSee('Dokumen Publik');
        $response->assertDontSee('Dokumen Internal');
    }

    public function test_chat_ask_returns_null_answer_when_api_key_not_configured()
    {
        config(['services.anthropic.api_key' => null]);
        Faq::create(['pertanyaan' => 'Apa itu JF MASN?', 'jawaban' => 'Jawaban FAQ.']);

        $response = $this->postJson('/chat/ask', ['question' => 'Apa itu JF MASN?']);

        $response->assertOk();
        $response->assertJson(['answer' => null]);
    }
}
