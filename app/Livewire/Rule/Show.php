<?php

namespace App\Livewire\Rule;

use App\Models\Penyakit;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $penyakit;

    #[On('showGejalaPenyakit')]
    public function show($id)
    {
        $this->mount($id);
    }

    public function mount($id_penyakit = null)
    {
        if ($id_penyakit) {
            $this->penyakit = Penyakit::query()->with('gejala')->where('id', $id_penyakit)->first();
            if ($this->penyakit->gejala->isEmpty()) {
                flash('Penyakit tidak mempunyai gejala', 'warning');
            }
        }
    }

    public function render()
    {
        return view('livewire.rule.show');
    }
}
