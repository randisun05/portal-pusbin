<?php

namespace App\Http\Controllers\Public;

use App\Models\Survei;
use App\Models\SurveiGroup;
use App\Models\SurveiPublic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\GuardsAgainstSpam;

class SurveiPublicController extends Controller
{
    use GuardsAgainstSpam;

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
            'title' => "Daftar Survei Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara",
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
            'nip' => 'required|digits:18',
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|string|max:2000',
        ]);

        // Hanya indikator milik survei ini yang boleh dijawab, dan semuanya wajib terisi
        // (sama dengan aturan di formulir). Mencegah error 500 / data yatim dari request buatan.
        $indikatorSurvei = SurveiGroup::where('survei_id', $survei->id)->pluck('indikator_id')->map(fn ($id) => (string) $id);
        $indikatorDijawab = collect(array_keys($validatedData['jawaban']))->map(fn ($id) => (string) $id);
        if ($indikatorDijawab->diff($indikatorSurvei)->isNotEmpty() || $indikatorSurvei->diff($indikatorDijawab)->isNotEmpty()) {
            return back()->withErrors(['jawaban' => 'Jawaban survei tidak lengkap atau tidak sesuai dengan indikator.'])->withInput();
        }

        // Satu NIP hanya sekali per survei: jawaban ganda menggandakan hitungan responden/statistik dan lencana.
        if (SurveiPublic::where('nip', $validatedData['nip'])->where('survei_id', $survei->id)->exists()) {
            return back()->withErrors(['nip' => 'NIP ini sudah pernah mengisi survei tersebut.'])->withInput();
        }

        if ($this->isSpamSubmission($request)) {
            return redirect('/survei')->with('success', 'Terima kasih, survei Anda berhasil dikirim.');
        }

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
