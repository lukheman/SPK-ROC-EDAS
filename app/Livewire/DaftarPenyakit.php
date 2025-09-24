<?php

namespace App\Livewire;

use App\Models\Penyakit;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.guest')]
class DaftarPenyakit extends Component
{

    use WithPagination;

    public string $search = '';

    #[Computed]
    public function penyakitList() {
         return Penyakit::query()
            ->when($this->search, fn($query) =>
                $query->where('nama', 'like', "%{$this->search}%")
            )
            ->paginate(6);
    }

    public function render()
    {

        return view('livewire.daftar-penyakit');
    }
}
