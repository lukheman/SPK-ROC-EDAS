<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Alternatif;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;

class SiswaImport implements ToModel, WithStartRow
{
    public int $importedCount = 0;

    /**
     * Skip the header row.
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Map columns by index:
     * A(0)=nisn, B(1)=nama, C(2)=tanggal_lahir, D(3)=phone,
     * E(4)=nama(skip), F(5)=pekerjaan_ayah, G(6)=penghasilan_ayah,
     * H(7)=pekerjaan_ibu, I(8)=penghasilan_ibu, J(9)=yatim_piatu,
     * K(10)=peringkat_kelas
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
                'nisn'           => $row[0],
                'nama'           => $row[1],
                'tanggal_lahir'  => $this->parseDate($row[2]),
                'phone'          => $row[3] ?? '',
                'jenis_kelamin'  => 'P',
                'alamat'         => '-',
                'password'       => bcrypt('password123'),
            ]);

            Alternatif::create([
                'id_siswa'         => $siswa->id_siswa,
                'pekerjaan_ayah'   => intval($row[5] ?? 0),
                'penghasilan_ayah' => intval($row[6] ?? 0),
                'pekerjaan_ibu'    => intval($row[7] ?? 0),
                'penghasilan_ibu'  => intval($row[8] ?? 0),
                'yatim_piatu'      => intval($row[9] ?? 0),
                'peringkat_kelas'  => intval($row[10] ?? 0),
            ]);

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
