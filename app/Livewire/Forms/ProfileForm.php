<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;

class ProfileForm extends Form
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public $photo;

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'min:4'],
            'photo' => ['nullable', 'image'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal :max karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'password.min' => 'Password minimal :min karakter.',

            'photo.image' => 'File foto harus berupa gambar (jpg, png, dll).',
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $user = getActiveUser();

        $updates = [];

        if ($this->name !== $user->name) {
            $updates['name'] = $this->name;
        }

        // Email uniqueness check (manual, karena perlu pengecualian user sendiri)
        if ($this->email !== $user->email) {
            $modelClass = get_class($user);
            $emailExists = $modelClass::where('email', $this->email)
                ->where($user->getKeyName(), '!=', $user->getKey())
                ->exists();

            if ($emailExists) {
                $this->addError('email', 'Email sudah terdaftar, silakan gunakan email lain.');
                return false;
            }

            $updates['email'] = $this->email;
        }

        if (!empty($this->password)) {
            $updates['password'] = Hash::make($this->password);
        }

        if ($this->photo) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $this->photo->store('photos', 'public');
            $updates['photo'] = $path;
        }

        if (!empty($updates)) {
            $user->update($updates);
            return true;
        }

        return true;
    }
}
