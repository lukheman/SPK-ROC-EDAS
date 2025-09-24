<?php

namespace App\Livewire\Chart;

use App\Models\Penyakit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class KurvaHasilDiagnosis extends Component
{
    public $labels;

    public $data;

    public function render()
    {
// Query untuk menghitung jumlah diagnosis per penyakit
        $penyakitCounts = DB::table('log_diagnosis_penyakit')
            ->select('penyakit.nama', DB::raw('count(*) as total'))
            ->join('penyakit', 'log_diagnosis_penyakit.id_penyakit', '=', 'penyakit.id')
            ->groupBy('penyakit.id', 'penyakit.nama')
            ->get();

        // Format hasil untuk ditampilkan
        $result = $penyakitCounts->mapWithKeys(function ($item) {
            return [$item->nama => $item->total];
        })->toArray();


        $this->labels = array_keys($result);
        $this->data = array_values($result);

        return view('livewire.chart.kurva-hasil-diagnosis');
    }
}
