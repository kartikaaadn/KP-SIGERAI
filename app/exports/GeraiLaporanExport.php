<?php

namespace App\Exports;

use App\Models\LayananHarian;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeraiLaporanExport implements FromArray, WithHeadings
{
    public function __construct(
        private int $geraiId,
        private Carbon $start,
        private Carbon $end
    ) {}

    public function headings(): array
    {
        return [
            'Tanggal',
            'Hari',
            'Jenis Layanan',
            'Jumlah',
            'Keterangan',
            'Total Per Hari',
        ];
    }

    public function array(): array
    {
        $rows = [];

        $data = LayananHarian::with('details')
            ->where('gerai_id', $this->geraiId)
            ->whereBetween('tanggal', [$this->start->toDateString(), $this->end->toDateString()])
            ->orderBy('tanggal')
            ->get();

        foreach ($data as $lh) {
            $hari = $lh->tanggal->locale('id')->isoFormat('dddd');
            if ($lh->details->count() === 0) {
                $rows[] = [
                    $lh->tanggal->format('d-m-Y'),
                    $hari,
                    '-',
                    0,
                    '-',
                    (int) $lh->total_layanan,
                ];
                continue;
            }

            foreach ($lh->details as $d) {
                $rows[] = [
                    $lh->tanggal->format('d-m-Y'),
                    $hari,
                    $d->jenis_layanan,
                    (int) $d->jumlah,
                    $d->keterangan ?? '',
                    (int) $lh->total_layanan,
                ];
            }
        }

        return $rows;
    }
}
