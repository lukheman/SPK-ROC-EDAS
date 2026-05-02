<?php

namespace App\Livewire\Table;

use App\Enums\State;
use App\Livewire\Forms\KriteriaForm;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Kriteria')]
class KriteriaTable extends Component
{
    use WithPagination;
    use WithNotify;
    use WithModal;

    public $currentState = State::CREATE;
    public string $idModal = 'modal-form-kriteria';
    public string $idModalSub = 'modal-sub-kriteria';

    public KriteriaForm $form;

    public string $search = '';

    // Sub Kriteria management
    public ?int $selectedKriteriaId = null;
    public string $selectedKriteriaName = '';
    public array $subKriteriaList = [];
    public string $subNama = '';
    public int $subNilai = 0;
    public ?int $editingSubId = null;

    public function add()
    {
        $this->form->reset();
        $this->currentState = State::CREATE;
        $this->openModal($this->idModal);
    }

    public function detail($id)
    {
        $this->currentState = State::SHOW;
        $kriteria = Kriteria::with('subKriteria')->find($id);
        $this->form->fillFromModel($kriteria);
        $this->openModal($this->idModal);
    }

    public function edit($id)
    {
        $this->detail($id);
        $this->currentState = State::UPDATE;
    }

    public function delete($id)
    {
        $this->form->kriteria = Kriteria::find($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus kriteria ini?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Kriteria berhasil dihapus!');
    }

    public function save()
    {
        if ($this->currentState === State::CREATE) {
            $this->form->store();
            $this->notifySuccess('Kriteria berhasil ditambahkan!');
        } elseif ($this->currentState === State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Kriteria berhasil diperbarui!');
        }

        $this->closeModal($this->idModal);
        $this->form->reset();
    }

    // =====================
    // Sub Kriteria Methods
    // =====================

    public function manageSub($id)
    {
        $kriteria = Kriteria::with('subKriteria')->find($id);
        $this->selectedKriteriaId = $kriteria->id_kriteria;
        $this->selectedKriteriaName = $kriteria->nama;
        $this->loadSubKriteria();
        $this->resetSubForm();
        $this->openModal($this->idModalSub);
    }

    private function loadSubKriteria()
    {
        $this->subKriteriaList = SubKriteria::where('id_kriteria', $this->selectedKriteriaId)
            ->orderBy('nilai', 'desc')
            ->get()
            ->toArray();
    }

    private function resetSubForm()
    {
        $this->subNama = '';
        $this->subNilai = 0;
        $this->editingSubId = null;
    }

    public function addSub()
    {
        $this->validate([
            'subNama'  => 'required|max:100',
            'subNilai' => 'required|integer',
        ], [
            'subNama.required'  => 'Nama sub kriteria wajib diisi.',
            'subNilai.required' => 'Nilai wajib diisi.',
            'subNilai.integer'  => 'Nilai harus berupa angka.',
        ]);

        if ($this->editingSubId) {
            SubKriteria::where('id_sub_kriteria', $this->editingSubId)->update([
                'nama'  => $this->subNama,
                'nilai' => $this->subNilai,
            ]);
            $this->notifySuccess('Sub kriteria berhasil diperbarui!');
        } else {
            SubKriteria::create([
                'id_kriteria' => $this->selectedKriteriaId,
                'nama'        => $this->subNama,
                'nilai'       => $this->subNilai,
            ]);
            $this->notifySuccess('Sub kriteria berhasil ditambahkan!');
        }

        $this->loadSubKriteria();
        $this->resetSubForm();
    }

    public function editSub($id)
    {
        $sub = SubKriteria::find($id);
        $this->editingSubId = $sub->id_sub_kriteria;
        $this->subNama = $sub->nama;
        $this->subNilai = $sub->nilai;
    }

    public function deleteSub($id)
    {
        SubKriteria::destroy($id);
        $this->loadSubKriteria();
        $this->notifySuccess('Sub kriteria berhasil dihapus!');
    }

    public function cancelEditSub()
    {
        $this->resetSubForm();
    }

    #[Computed]
    public function kriteria()
    {
        return Kriteria::query()
            ->withCount('subKriteria')
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('kode', 'like', '%' . $this->search . '%');
            })
            ->orderBy('urutan')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.table.kriteria-table');
    }
}
