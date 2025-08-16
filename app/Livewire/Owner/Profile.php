<?php

namespace App\Livewire\Owner;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public $name;
    public $email;
    public $shop_name;
    public $shop_description;
    public $phone;
    public $address;

    public function mount()
    {
        $owner = Auth::guard('owner')->user();
        $this->name = $owner->name;
        $this->email = $owner->email;
        $this->shop_name = $owner->shop_name;
        $this->shop_description = $owner->shop_description;
        $this->phone = $owner->phone;
        $this->address = $owner->address;
    }

    public function updateProfile()
    {
        $owner = Auth::guard('owner')->user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('owners')->ignore($owner->id)],
            'shop_name' => ['nullable', 'string', 'max:255'],
            'shop_description' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $owner->update($validated);

        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.owner.profile');
    }
}
