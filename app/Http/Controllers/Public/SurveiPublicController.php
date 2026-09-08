<?php

namespace App\Http\Controllers\Public;

use App\Models\Survei;
use App\Models\SurveiGroup;
use App\Models\SurveiPublic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurveiPublicController extends Controller
{
    /**
     * Tingkat "badge" kontributor survei berdasarkan jumlah survei berbeda
     * yang sudah pernah diisi oleh satu NIP.
     */
    const BADGE_TIERS = [
        1 => ['label' => 'Kontributor Baru', 'icon' => '🌱'],
        3 => ['label' => 'Kontributor Aktif', 'icon' => '⭐'],
        6 => ['label' => 'Kontributor Istimewa', 'icon' => '🏆'],
        10 => ['label' => 'Kontributor Legenda', 'icon' => '👑'],
    ];

    public static function badgeFor(int $count): array
    {
        $badge = ['label' => 'Peserta', 'icon' => '📝'];

        foreach (self::BADGE_TIERS as $threshold => $tier) {
            if ($count >= $threshold) {
                $badge = $tier;
            }
        }

        return $badge;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.survei.index', [
            'title' => "Daftar Survei Pusat Pembinaan Jabatan Fungsional Kepegawaian",
            'surveis' => Survei::orderBy('title')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Survei  $survei
     * @return \Illuminate\Http\Response
     */
    public function create(Survei $survei)
    {
        $groups = SurveiGroup::with('indikator')->where('survei_id', $survei->id)->get();

        return view('public.survei.create', [
            'title' => $survei->title,
            'survei' => $survei,
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survei  $survei
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survei $survei)
    {
        $validatedData = $request->validate([
            'nip' => 'required',
            'jawaban' => 'required|array',
        ]);

        foreach ($validatedData['jawaban'] as $indikatorId => $nilai) {
            SurveiPublic::create([
                'nip' => $validatedData['nip'],
                'survei_id' => $survei->id,
                'indikator_id' => $indikatorId,
                'velue' => $nilai,
            ]);
        }

        $jumlahSurveiSelesai = SurveiPublic::where('nip', $validatedData['nip'])->distinct('survei_id')->count('survei_id');
        $badge = self::badgeFor($jumlahSurveiSelesai);

        return redirect('/survei')
            ->with('success', 'Terima kasih, survei Anda berhasil dikirim.')
            ->with('badgeLabel', $badge['label'])
            ->with('badgeIcon', $badge['icon'])
            ->with('jumlahSurveiSelesai', $jumlahSurveiSelesai);
    }
}
