<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationTray extends Component
{

    protected $listeners = ['new_notification' => 'getNotifications', 'read_notification' => 'readNotifications'];

    public $myNotifications;

    public function mount(){
        $this->getNotifications('unread');
    }



    public function getNotifications($filter){
        $user = Auth::user();

        if ($filter == 'all'){
            $this->myNotifications = $user->notifications;
        }

        if ($filter == 'unread'){
            $this->myNotifications = $user->unreadNotifications;
        }
    }

    public function readNotifications($id){
        $user = Auth::user();
        $user->notifications->find($id)->markAsRead();
        $this->getNotifications('unread');
    }


    public function render()
    {
        return view('livewire.notification-tray');
    }
}
