<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileForm extends Form
{
    #[Rule(['required', 'max:50'])]
    public string $name = '';

    #[Validate(onUpdate: false)]
    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Validate(onUpdate: false)]
    #[Rule(['nullable', 'min:4', 'confirmed'])]
    public string $password = '';

    #[Rule('nullable')]
    public string $password_confirmation = '';

    #[Rule('nullable', 'image')]
    public $photo;

    public function update()
    {

        $validated = $this->validate();
        $user = User::find(auth()->user()->id);

        // Only update fields that have changed
        $updates = [];

        if ($this->name !== $user->name) {
            $updates['name'] = $this->name;
        }

        // For email, we need to ensure uniqueness except for the user's own record
        if ($this->email !== $user->email) {
            // Manually validate email uniqueness excluding current user
            $emailExists = User::where('email', $this->email)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($emailExists) {
                $this->addError('email', 'The email has already been taken.');

                return false;
            }

            $updates['email'] = $this->email;
        }

        // Only hash and update password if it's provided
        if (! empty($this->password)) {
            $updates['password'] = Hash::make($this->password);
        }

        if ($this->photo) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // Store new photo
            $path = $this->photo->store('photos', 'public');
            $updates['photo'] = $path;
        }

        // Only perform update if there are changes
        if (! empty($updates)) {
            $user->update($updates);

            return true;
        }

        return true; // Return true even if no updates (consider this a successful operation)

    }
}
