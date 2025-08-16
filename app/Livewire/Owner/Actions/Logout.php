<?php

namespace App\Livewire\Owner\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current owner out of the application.
     */
    public function __invoke()
    {
        Auth::guard('owner')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('owner.login');
    }
}
