<?php

namespace App\Imports;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;

class SiswaImport implements ToModel, WithStartRow
{
    public int $importedCount = 0;

    protected $kriteriaList;

    public function __construct()
    {
        $this->kriteriaList = Kriteria::orderBy('urutan')->get();
    }

    /**
     * Skip the header row.
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Map columns by index:
     * A(0)=nisn, B(1)=nama, C(2)=tanggal_lahir,
     * D(3)..onwards = kriteria values (in urutan order)
     */
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row[0]) && empty($row[1])) {
            return null;
        }

        DB::beginTransaction();

        try {
            $siswa = Siswa::create([
                'nisn'          => $row[0],
                'nama'          => $row[1],
                'tanggal_lahir' => $this->parseDate($row[2]),
                'jenis_kelamin' => 'P',
                'alamat'        => '-',
                'password'      => bcrypt('password123'),
            ]);

            // Kriteria values start from column index 4
            foreach ($this->kriteriaList as $index => $kriteria) {
                $colIndex = 3 + $index;
                Alternatif::create([
                    'id_siswa'    => $siswa->id_siswa,
                    'id_kriteria' => $kriteria->id_kriteria,
                    'nilai'       => intval($row[$colIndex] ?? 0),
                ]);
            }

            $this->importedCount++;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return null;
    }

    /**
     * Parse date from various formats (Excel serial, Y-m-d, d/m/Y, etc.)
     */
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return now()->format('Y-m-d');
        }

        // Excel serial date number
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($value))->format('Y-m-d');
        }

        // Try common date formats
        foreach (['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'] as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            if ($date) {
                return $date->format('Y-m-d');
            }
        }

        return now()->format('Y-m-d');
    }
}
