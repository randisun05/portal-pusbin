<?php

namespace Tests\Feature;

use App\Models\Survei;
use App\Models\SurveiGroup;
use App\Models\SurveiIndikator;
use App\Models\SurveiPublic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveiKepuasanTest extends TestCase
{
    use RefreshDatabase;

    protected function makeSurveiKepuasan(int $type = 4): Survei
    {
        $survei = Survei::create(['title' => 'Survei Kepuasan Layanan', 'type' => $type]);
        $indikator = SurveiIndikator::create(['title' => 'Kualitas Pelayanan']);
        SurveiGroup::create(['survei_id' => $survei->id, 'indikator_id' => $indikator->id]);

        return $survei;
    }

    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/admin/survei-kepuasan');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_shows_only_scale_type_surveys_in_dropdown()
    {
        $admin = User::factory()->create();
        $this->makeSurveiKepuasan(4);
        Survei::create(['title' => 'Survei Teks Bebas', 'type' => 1]);

        $response = $this->actingAs($admin)->get('/admin/survei-kepuasan');

        $response->assertOk();
        $response->assertSee('Survei Kepuasan Layanan');
        $response->assertDontSee('Survei Teks Bebas');
    }

    public function test_public_can_submit_emoji_scale_survey_and_dashboard_computes_correct_index()
    {
        $survei = $this->makeSurveiKepuasan(4);
        $indikator = SurveiGroup::where('survei_id', $survei->id)->first()->indikator_id;

        SurveiPublic::create(['nip' => 'nip1', 'survei_id' => $survei->id, 'indikator_id' => $indikator, 'velue' => 4]);
        SurveiPublic::create(['nip' => 'nip2', 'survei_id' => $survei->id, 'indikator_id' => $indikator, 'velue' => 2]);

        // rata-rata (4+2)/2 = 3, skala maksimum 4 => indeks (3/4)*100 = 75.0
        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get("/admin/survei-kepuasan?survei={$survei->id}");

        $response->assertOk();
        $response->assertSee('75');
        $response->assertSee('2 responden');
        $response->assertSee('Baik');
    }

    public function test_emoji_survey_form_renders_scale_options()
    {
        $survei = $this->makeSurveiKepuasan(4);

        $response = $this->get("/survei/{$survei->id}/create");

        $response->assertOk();
        $response->assertSee('sv-emoji-card', false);
        $response->assertSee('😄');
        $response->assertSee('😠');
    }

    public function test_survey_submission_stores_numeric_scale_value()
    {
        $survei = $this->makeSurveiKepuasan(4);
        $indikator = SurveiGroup::where('survei_id', $survei->id)->first()->indikator_id;

        $response = $this->post("/survei/{$survei->id}", [
            'nip' => '199001012020011001',
            'jawaban' => [$indikator => '3'],
        ]);

        $response->assertRedirect('/survei');
        $this->assertDatabaseHas('survei_publics', [
            'nip' => '199001012020011001',
            'indikator_id' => $indikator,
            'velue' => '3',
        ]);
    }

    public function test_dashboard_shows_empty_state_message_for_survey_with_no_respondents()
    {
        $survei = $this->makeSurveiKepuasan(3);
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get("/admin/survei-kepuasan?survei={$survei->id}");

        $response->assertOk();
        $response->assertSee('belum memiliki responden');
    }
}
