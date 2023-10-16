<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;

class NotificationAndMessage extends Component
{

    public $messageCount;
    public $messages;
    public $user_id;
    public $type;
    public $route;
    protected $listeners = ['incoming-message' => 'incomingMessage', 'read-message' => 'readMessage'];

    public function mount(){
        $this->incomingMessage();
    }

    public function incomingMessage(){
        if($this->type == 'vendor'){
            $chatHistory = Chat::where(['vendor_id'=>$this->user_id, 'vendor_read_status' => 0])
            ->selectRaw('JSON_EXTRACT(`chat_message`,CONCAT("$[",JSON_LENGTH(`chat_message`)-1,"].message"))  as message, customer_id as user_id, JSON_EXTRACT(`chat_message`,CONCAT("$[",JSON_LENGTH(`chat_message`)-1,"].time")) as time')
            ->get();
            $this->route = '/vendor/chat';

       }elseif($this->type == 'customer'){
            $chatHistory = Chat::where(['customer_id'=>$this->user_id, 'customer_read_status' => 0])
                                    ->selectRaw('JSON_EXTRACT(`chat_message`,CONCAT("$[",JSON_LENGTH(`chat_message`)-1,"].message"))  as message, vendor_id as user_id, JSON_EXTRACT(`chat_message`,CONCAT("$[",JSON_LENGTH(`chat_message`)-1,"].time")) as time')
                                    ->get();

            $this->route = '/customer/chat';
        }elseif($this->type == 'admin'){
            $chatHistory = [];
        }

        if($chatHistory != []){
            $this->messages = $chatHistory->map(function($item){
                $user = User::find($item->user_id);
    
                return [
                    'user' => $user,
                    'message' => $item->message,
                    'time' => $item->time
                ];
    
            })->take(3);
    
            $this->messageCount = $chatHistory->count();
        }else{
            $this->messages = [];
            $this->messageCount = 0;
        }
       
    }

    public function readMessage(){
        $this->incomingMessage();
    }

    public function render()
    {
        return view('livewire.notification-and-message');
    }
}
