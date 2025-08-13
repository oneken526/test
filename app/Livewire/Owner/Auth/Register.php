<?php

namespace App\Livewire\Owner\Auth;

use App\Models\Owner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth', ['title' => 'オーナーアカウント作成'])]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $shop_name = '';

    public string $phone = '';

    public string $address = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Owner::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'shop_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($owner = Owner::create($validated))));

        Auth::guard('owner')->login($owner);

        $this->redirect(route('owner.dashboard', absolute: false), navigate: true);
    }

    public function updatedName(): void
    {
        $this->validateOnly('name', [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }
}
