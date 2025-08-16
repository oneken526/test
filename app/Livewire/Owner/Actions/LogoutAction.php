<?php

namespace App\Livewire\Owner\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LogoutAction extends Component
{
    /**
     * Log the current owner out of the application.
     */
    public function logout()
    {
        Auth::guard('owner')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect(route('owner.login'));
    }

    public function render()
    {
        return view('livewire.owner.actions.logout-action');
    }
}
