<?php

namespace App\Http\Controllers\Gerai;

use App\Http\Controllers\Controller;
use App\Models\LayananHarian;
use App\Models\LayananHarianDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeraiLaporanController extends Controller
{
    private function getMonday(Carbon $date): Carbon
    {
        // paksa ke Monday minggu itu
        return $date->copy()->startOfWeek(Carbon::MONDAY);
    }

    private function weekDates(Carbon $monday): array
    {
        // Senin - Jumat
        $dates = [];
        for ($i = 0; $i < 5; $i++) {
            $dates[] = $monday->copy()->addDays($i);
        }
        return $dates;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'gerai', 403);

        $geraiId = $user->gerai_id;

        // default: minggu ini (mulai Senin)
        $picked = $request->filled('start')
            ? Carbon::parse($request->start)
            : Carbon::now();

        $monday = $this->getMonday($picked);
        $dates = $this->weekDates($monday);

        $start = $dates[0]->toDateString();
        $end   = $dates[4]->toDateString();

        // ambil data layanan harian + detail
        $harian = LayananHarian::with('details')
            ->where('gerai_id', $geraiId)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get()
            ->keyBy(fn($x) => $x->tanggal->toDateString());

        // hitung per-hari total dari details (lebih akurat buat tampilan)
        $perDayTotals = [];
        foreach ($dates as $d) {
            $key = $d->toDateString();
            $row = $harian->get($key);
            $sum = $row ? (int) $row->details->sum('jumlah_pengguna') : 0;
            $perDayTotals[] = $sum;
        }

        $weeklyTotal = array_sum($perDayTotals);
        $max = count($perDayTotals) ? max($perDayTotals) : 0;
        $min = count($perDayTotals) ? min($perDayTotals) : 0;

        // "Menengah" kita pakai median (biar mirip kartu menengah)
        $sorted = $perDayTotals;
        sort($sorted);
        $median = 0;
        $n = count($sorted);
        if ($n > 0) {
            $mid = (int) floor(($n - 1) / 2);
            $median = $sorted[$mid];
        }

        return view('gerai.laporan.index', [
            'user' => $user,
            'monday' => $monday,
            'dates' => $dates,
            'harian' => $harian,
            'weeklyTotal' => $weeklyTotal,
            'max' => $max,
            'median' => $median,
            'min' => $min,
            'rangeText' => $dates[0]->translatedFormat('D, d M Y') . ' - ' . $dates[4]->translatedFormat('D, d M Y'),
        ]);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'gerai', 403);

        $geraiId = $user->gerai_id;

        $picked = $request->filled('start')
            ? Carbon::parse($request->start)
            : Carbon::now();

        $monday = $this->getMonday($picked);
        $dates = $this->weekDates($monday);

        $start = $dates[0]->toDateString();
        $end   = $dates[4]->toDateString();

        $harian = LayananHarian::with('details')
            ->where('gerai_id', $geraiId)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get()
            ->keyBy(fn($x) => $x->tanggal->toDateString());

        return view('gerai.laporan.input', [
            'user' => $user,
            'monday' => $monday,
            'dates' => $dates,
            'harian' => $harian,
            'rangeText' => $dates[0]->translatedFormat('d M Y') . ' - ' . $dates[4]->translatedFormat('d M Y'),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'gerai', 403);

        $geraiId = $user->gerai_id;

        $request->validate([
            'start' => ['required','date'],
            'items' => ['required','array'],
        ]);

        $monday = $this->getMonday(Carbon::parse($request->start));
        $dates = $this->weekDates($monday);

        DB::transaction(function () use ($request, $geraiId, $dates, $user) {
            foreach ($dates as $d) {
                $dateKey = $d->toDateString();

                $rows = $request->items[$dateKey] ?? [];
                // bersihkan row kosong
                $clean = [];
                foreach ($rows as $r) {
                    $jenis = trim((string)($r['jenis'] ?? ''));
                    $jumlah = (int)($r['jumlah'] ?? 0);
                    $ket = trim((string)($r['ket'] ?? ''));

                    if ($jenis !== '' && $jumlah > 0) {
                        $clean[] = [
                            'jenis_layanan' => $jenis,
                            'jumlah_pengguna' => $jumlah,
                            'keterangan' => $ket ?: null,
                        ];
                    }
                }

                // upsert layanan harian
                $harian = LayananHarian::firstOrCreate(
                    ['gerai_id' => $geraiId, 'tanggal' => $dateKey],
                    [
                        'total_layanan' => 0,
                        'keterangan' => null,
                        'status_verifikasi' => 'draft',
                        'created_by' => $user->id,
                    ]
                );

                // hapus detail lama lalu insert baru
                $harian->details()->delete();

                $sum = 0;
                foreach ($clean as $c) {
                    $sum += (int)$c['jumlah_pengguna'];
                    $harian->details()->create($c);
                }

                // update total_layanan (sum detail)
                $harian->total_layanan = $sum;
                $harian->save();
            }
        });

        return redirect()
            ->route('gerai.laporan.index', ['start' => $monday->toDateString()])
            ->with('success', 'Data layanan berhasil disimpan.');
    }

    public function destroyDetail(LayananHarianDetail $detail)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'gerai', 403);

        $detail->load('harian');

        // pastikan milik gerai ini
        abort_unless($detail->harian && $detail->harian->gerai_id === $user->gerai_id, 403);

        $harian = $detail->harian;

        $detail->delete();

        // update total parent
        $harian->total_layanan = (int) $harian->details()->sum('jumlah_pengguna');
        $harian->save();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->role === 'gerai', 403);

        $geraiId = $user->gerai_id;

        $picked = $request->filled('start')
            ? Carbon::parse($request->start)
            : Carbon::now();

        $monday = $this->getMonday($picked);
        $dates = $this->weekDates($monday);

        $start = $dates[0]->toDateString();
        $end   = $dates[4]->toDateString();

        $rows = LayananHarian::with('details')
            ->where('gerai_id', $geraiId)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get();

        // CSV (dibuka Excel)
        $filename = "laporan_layanan_{$start}_{$end}.csv";

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');

            // Excel-friendly UTF-8 BOM
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($out, ['Hari', 'Tanggal', 'Jenis Layanan', 'Jumlah Pengguna', 'Keterangan']);

            foreach ($rows as $h) {
                $hari = $h->tanggal->translatedFormat('l');
                $tgl = $h->tanggal->format('d-m-Y');

                if ($h->details->count() === 0) {
                    fputcsv($out, [$hari, $tgl, '-', 0, '-']);
                    continue;
                }

                foreach ($h->details as $d) {
                    fputcsv($out, [
                        $hari,
                        $tgl,
                        $d->jenis_layanan,
                        $d->jumlah_pengguna,
                        $d->keterangan ?? '',
                    ]);
                }
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
