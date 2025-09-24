<?php

namespace App\Helpers;

class DempsterShafer
{
    public array $matrix; // [['P1,P2,P3' => 0.4]]

    public function __construct(array $matrix)
    {
        $this->matrix = $matrix;
    }

    public function plausibility()
    {

        $keys = [];
        $plausibility = 1.0;

        // konflik akan dijumlahkan dengan plausibility, oleh karena itu tidak usah kurang 1 dengan set yang konflik
        $this->filterConflict();

        foreach ($this->matrix as $row) {
            foreach ($row as $key => $value) {
                if ($key !== '') {
                    $keys[] = $key;
                    $plausibility -= $value;
                }
            }
        }

        $keys = $this->unionArrays($keys);

        return [$keys => round($plausibility, 6)];

    }

    public function totalBelief()
    {
        // fungsi untuk mendapatkan total belief dengan menjumlahkan nilii belief setiap set
        $belief = 0.0;

        foreach ($this->matrix as $row) {
            foreach ($row as $key => $value) {
                $belief += $value;
            }

        }

        return $belief;

    }

    public function filterConflict()
    {
        $this->matrix = array_filter($this->matrix, function ($item) {
            $key = array_key_first($item);

            return ! empty($key); // hanya ambil yang key-nya tidak kosong
        });
    }

    /* contoh */
    /* ['P3', 'P1', 'P2'] -> ['P1', 'P2', 'P3'] */
    private function sortingKey($key)
    {
        $keys = explode(',', $key);
        sort($keys);

        return implode(',', $keys);
    }

    public function combinate(DempsterShafer $other): DempsterShafer
    {
        $result = [];

        /* this M x other belif */
        foreach ($this->matrix as $row) {
            $set1 = $this->sortingKey(array_key_first($row));
            $set2 = $this->sortingKey(array_key_first($other->matrix[0]));
            $new_belief = array_values($row)[0] * array_values($other->matrix[0])[0];

            $key = $this->intersect($set1, $set2);
            array_push($result, [$key => $new_belief]);

        }

        // kali plausibility
        $set1 = $this->sortingKey(array_key_first($this->plausibility()));
        $set2 = $this->sortingKey(array_key_first($other->matrix[0]));
        $new_belief = array_values($this->plausibility())[0] * array_values($other->matrix[0])[0];
        $key = $this->intersect($set1, $set2);
        array_push($result, [$set2 => $new_belief]);

        /* this M x other plusibility */
        foreach ($this->matrix as $row) {
            $set1 = array_key_first($row);
            $set2 = array_key_first($other->plausibility());
            $new_belief = array_values($row)[0] * array_values($other->plausibility())[0];

            $key = $this->sortingKey($set1);
            array_push($result, [$key => $new_belief]);

        }

        $result = $this->normalisasi($result);

        return new DempsterShafer($result);
    }

    private function normalisasi($matrix)
    {
        // Menjumlahkan
        $summary = [];

        foreach ($matrix as $item) {
            foreach ($item as $key => $value) {
                if (! isset($summary[$key])) {
                    $summary[$key] = 0;
                }
                $summary[$key] += $value;
            }
        }

        // Membentuk ulang ke format yang diminta
        $normalized = [];

        foreach ($summary as $key => $value) {
            $normalized[] = [$key => $value];
        }

        return $normalized;
    }

    private function unionArrays($array)
    {
        $all = [];
        foreach ($array as $item) {
            $all = array_merge($all, explode(',', $item));
        }

        $unique = array_unique($all);

        return $this->sortingKey(implode(',', $unique));
    }

    private function intersect(string $a, string $b): string
    {
        $arrA = explode(',', $a);
        $arrB = explode(',', $b);
        $intersect = array_intersect($arrA, $arrB);

        return $this->sortingKey(implode(',', $intersect));

    }

    public function getMaxValue()
    {

        $maxValue = 0;
        $maxKey = '';

        foreach ($this->matrix as $row) {

            foreach ($row as $key => $value) {
                if ($value > $maxValue) {
                    $maxValue = $value;
                    $maxKey = $key;
                }
            }
        }

        return [$maxKey => $maxValue];

    }

    /**
     * Menghitung jumlah nilai belief untuk setiap kode penyakit berdasarkan gejala.
     *
     * Melakukan iterasi pada setiap entri dalam matrix, memisahkan kode penyakit yang digabung,
     * lalu menjumlahkan nilai belief untuk setiap kode penyakit secara individual.
     * Hasil akhirnya dibulatkan hingga 4 desimal dan diproses lebih lanjut oleh maxBeliefGejala().
     *
     * @return mixed Hasil dari pemrosesan maxBeliefGejala dengan input array belief per kode penyakit.
     */
    public function sumBeliefByGejala()
    {
        $result = [];

        // Iterasi melalui setiap entri di matrix
        foreach ($this->matrix as $entry) {
            foreach ($entry as $diseases => $belief) {
                // Pisahkan kode penyakit (contoh: P01,P02,P03 menjadi array [P01, P02, P03])
                $diseaseCodes = explode(',', $diseases);

                // Tambahkan nilai belief ke setiap kode penyakit
                foreach ($diseaseCodes as $code) {
                    $code = trim($code);
                    if (! isset($result[$code])) {
                        $result[$code] = 0;
                    }
                    $result[$code] += $belief;
                }
            }
        }

        // Format hasil dengan 4 desimal
        foreach ($result as $code => $value) {
            $result[$code] = round($value, 4);
        }

        return $this->maxBeliefGejala($result);
        // return $result;

    }

    /**
     * Mengambil elemen dengan nilai terbesar dari array gejala.
     *
     * @param  array  $array  Array asosiatif gejala dengan nilai belief.
     *                        Contoh:
     *                        [
     *                        "P01" => 0.476,
     *                        "P02" => 0.416,
     *                        "P03" => 0.736,
     *                        "P04" => 0.376,
     *                        "P05" => 0.626,
     *                        "P06" => 0.352,
     *                        "P07" => 0.352
     *                        ]
     * @return array Array asosiatif dengan satu elemen (key dan value terbesar).
     *               Contoh: ["P03" => 0.736]
     */
    private function maxBeliefGejala(array $array)
    {
        $max_key = null;
        $max_value = null;

        foreach ($array as $key => $value) {
            if ($max_value === null || $value > $max_value) {
                $max_value = $value;
                $max_key = $key;
            }
        }

        return [$max_key => $max_value];

    }
}
