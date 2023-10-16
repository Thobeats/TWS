<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationTray extends Component
{

    protected $listeners = ['new_notification' => 'getNotifications'];

    public $myNotifications;

    public function getNotifications(){
        $user = Auth::user();

        $this->myNotifications = $user->unreadNotifications;
    }


    public function render()
    {
        return view('livewire.notification-tray');
    }
}
