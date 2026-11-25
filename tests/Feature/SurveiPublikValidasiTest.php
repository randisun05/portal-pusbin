<?php

namespace Tests\Feature;

use App\Models\Survei;
use App\Models\SurveiGroup;
use App\Models\SurveiIndikator;
use App\Models\SurveiPublic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * BUG-02: request survei buatan (jawaban kosong / indikator asing) tadinya
 * menyebabkan HTTP 500 (kolom velue NOT NULL) atau data yatim.
 */
class SurveiPublikValidasiTest extends TestCase
{
    use RefreshDatabase;

    private function survei(): array
    {
        $survei = Survei::create(['title' => 'Survei Uji', 'type' => 1]);
        $a = SurveiIndikator::create(['title' => 'A']);
        $b = SurveiIndikator::create(['title' => 'B']);
        SurveiGroup::create(['survei_id' => $survei->id, 'indikator_id' => $a->id]);
        SurveiGroup::create(['survei_id' => $survei->id, 'indikator_id' => $b->id]);

        return [$survei, $a, $b];
    }

    public function test_jawaban_kosong_ditolak_dengan_validasi_bukan_500()
    {
        [$survei, $a, $b] = $this->survei();

        $this->from("/survei/{$survei->id}/create")
            ->post("/survei/{$survei->id}", ['nip' => '199001012020011001', 'jawaban' => [$a->id => '', $b->id => 'x']])
            ->assertSessionHasErrors('jawaban.' . $a->id);

        $this->assertSame(0, SurveiPublic::count());
    }

    public function test_indikator_asing_atau_kurang_ditolak()
    {
        [$survei, $a, $b] = $this->survei();

        $this->post("/survei/{$survei->id}", ['nip' => '199001012020011001', 'jawaban' => [99999 => 'x', $a->id => 'y', $b->id => 'z']])
            ->assertSessionHasErrors('jawaban');
        $this->post("/survei/{$survei->id}", ['nip' => '199001012020011001', 'jawaban' => [$a->id => 'y']])
            ->assertSessionHasErrors('jawaban');

        $this->assertSame(0, SurveiPublic::count());
    }

    public function test_jawaban_lengkap_tetap_tersimpan()
    {
        [$survei, $a, $b] = $this->survei();

        $this->post("/survei/{$survei->id}", ['nip' => '199001012020011001', 'jawaban' => [$a->id => 'y', $b->id => 'z']])
            ->assertRedirect('/survei');

        $this->assertSame(2, SurveiPublic::count());
    }

    public function test_nip_yang_sama_tidak_bisa_mengisi_survei_dua_kali(): void
    {
        [$survei, $a, $b] = $this->survei();
        $kirim = fn () => $this->post("/survei/{$survei->id}", ['nip' => '199001012020011001', 'jawaban' => [$a->id => 'y', $b->id => 'z']]);

        $kirim()->assertRedirect('/survei');
        $kirim()->assertSessionHasErrors('nip');
        $this->assertSame(2, \App\Models\SurveiPublic::where('survei_id', $survei->id)->count());
    }
}
