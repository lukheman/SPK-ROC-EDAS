<?php

namespace App\Livewire;

use App\Livewire\Forms\ProfileForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Profil')]
class Profile extends Component
{
    use WithFileUploads;

    public ProfileForm $form;
    public $user;

    public function edit()
    {
        if ($this->form->update()) {

            $this->dispatch('toast', message: 'Berhasil menyimpan perubahan profile');
        }

    }

    public function mount()
    {

        $user = auth()->user();
        $this->user = $user;

        $this->form->name = $user->name;
        $this->form->email = $user->email;

    }

    public function render()
    {
        return view('livewire.profile');
    }
}
