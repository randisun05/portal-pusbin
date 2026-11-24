<?php

namespace Tests\Feature;

use App\Models\Formulir;
use App\Models\FormulirField;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * BUG-10: kontrol formulir publik tidak terhubung ke labelnya (pembaca layar
 * tidak membacakan nama kolom); kolom pencarian header tanpa nama aksesibel.
 */
class AksesibilitasFormulirTest extends TestCase
{
    use RefreshDatabase;

    public function test_label_terhubung_ke_kontrol_dan_pencarian_header_punya_nama()
    {
        $f = Formulir::create(['judul' => 'F A11y', 'slug' => 'f-a11y', 'status' => '1']);
        $text = FormulirField::create(['formulir_id' => $f->id, 'label' => 'Nama', 'tipe' => 'text', 'urutan' => 1]);
        $sel = FormulirField::create(['formulir_id' => $f->id, 'label' => 'Jenjang', 'tipe' => 'select', 'opsi' => ['A', 'B'], 'urutan' => 2]);

        $html = $this->get('/form/f-a11y')->assertOk()->getContent();

        foreach ([$text, $sel] as $field) {
            $this->assertStringContainsString('for="field' . $field->id . '"', $html);
            $this->assertMatchesRegularExpression('/<(input|select)[^>]*id="field' . $field->id . '"/', $html);
        }
        $this->assertStringContainsString('aria-label="Cari di situs ini"', $html);
    }
}
