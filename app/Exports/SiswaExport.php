<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Siswa::with('alternatif')->get();
    }

    public function headings(): array
    {
        return [
            'nisn',
            'nama',
            'Tanggal lahir',
            'phone',
            'nama',
            'pekerjaan ayah',
            'penghasilan ayah',
            'pekerjaan ibu',
            'penghasilan ibu',
            'yatim/piatu',
            'peringkat kelas',
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nisn,
            $siswa->nama,
            $siswa->tanggal_lahir,
            $siswa->phone,
            $siswa->nama,
            $siswa->alternatif->pekerjaan_ayah ?? 0,
            $siswa->alternatif->penghasilan_ayah ?? 0,
            $siswa->alternatif->pekerjaan_ibu ?? 0,
            $siswa->alternatif->penghasilan_ibu ?? 0,
            $siswa->alternatif->yatim_piatu ?? 0,
            $siswa->alternatif->peringkat_kelas ?? 0,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header row
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFFFF'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Green header for alternatif columns (E1:K1)
        $sheet->getStyle('E1:K1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '92D050'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Auto-size columns
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
