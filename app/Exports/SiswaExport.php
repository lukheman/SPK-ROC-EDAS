<?php

namespace App\Exports;

use App\Models\Kriteria;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $kriteriaList;

    public function __construct()
    {
        $this->kriteriaList = Kriteria::orderBy('urutan')->get();
    }

    public function collection()
    {
        return Siswa::with('alternatif')->get();
    }

    public function headings(): array
    {
        $headers = ['nisn', 'nama', 'Tanggal lahir'];

        foreach ($this->kriteriaList as $kriteria) {
            $headers[] = $kriteria->nama;
        }

        return $headers;
    }

    public function map($siswa): array
    {
        $row = [
            $siswa->nisn,
            $siswa->nama,
            $siswa->tanggal_lahir,
        ];

        foreach ($this->kriteriaList as $kriteria) {
            $row[] = $siswa->getNilaiKriteria($kriteria->id_kriteria);
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $kriteriaCount = $this->kriteriaList->count();
        $lastSiswaCol = 'D';
        $firstKriteriaCol = 'E';
        $lastCol = chr(ord('D') + $kriteriaCount);

        // Style header row — siswa columns
        $sheet->getStyle("A1:{$lastSiswaCol}1")->applyFromArray([
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

        // Green header for kriteria columns
        if ($kriteriaCount > 0) {
            $sheet->getStyle("{$firstKriteriaCol}1:{$lastCol}1")->applyFromArray([
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
        }

        // Auto-size columns
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
