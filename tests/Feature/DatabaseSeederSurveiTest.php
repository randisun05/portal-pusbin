<?php

namespace Tests\Feature;

use App\Models\Survei;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederSurveiTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_links_indicators_so_every_survey_form_has_questions(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(5, Survei::count());

        foreach (Survei::orderBy('id')->get() as $survei) {
            $this->assertGreaterThan(0, $survei->indikators()->count(), "Survei '{$survei->title}' tidak punya indikator");
            $this->get('/survei/' . $survei->id . '/create')
                ->assertOk()
                ->assertDontSee('Indikator Survei Belum Tersedia');
        }
    }
}
