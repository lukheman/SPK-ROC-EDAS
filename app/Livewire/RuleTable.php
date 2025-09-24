<?php

namespace App\Livewire;

use App\Models\Gejala;
use App\Models\Penyakit;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Enums\State;
use App\Traits\{WithModal, WithNotify};

#[Title('Rule')]
class RuleTable extends Component
{
    use WithModal;
    use WithNotify;
    public $state = '';

    public $id_penyakit;

    public string $search = '';

    public $idModal = 'modal-rule';

    public $currentState = State::SHOW;
    public ?Penyakit $selectedPenyakit = null;

    public $id_gejala_terpilih;

    public $listGejala;

    public function mount() {
        $this->listGejala = Gejala::latest()->get();
    }

    public function save()
    {
        $this->selectedPenyakit->gejala()->sync($this->id_gejala_terpilih);
        $this->notifySuccess("Gejala penyakit ({$this->selectedPenyakit->kode} - {$this->selectedPenyakit->nama}) berhasil diperbarui");
    }


    public function detail($id)
    {
        $this->currentState = State::SHOW;
        $this->selectedPenyakit = Penyakit::with('gejala')->find($id);
        $this->openModal($this->idModal);
    }

    public function edit($id)
    {
        $this->currentState = State::UPDATE;
        $this->selectedPenyakit = Penyakit::with('gejala')->find($id);

        $this->id_gejala_terpilih = $this->selectedPenyakit->gejala->pluck('id')->toArray();

        $this->openModal($this->idModal);
    }

    #[Computed]
    public function penyakit() {
        return Penyakit::query()
            ->when($this->search, function($query) {

                $query->where('nama', 'like', '%'.$this->search.'%')
                ->orWhere('kode', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.rule-table');
    }
}
