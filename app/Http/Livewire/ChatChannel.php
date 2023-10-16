<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use Livewire\Component;
use Illuminate\Http\Request;

class ChatChannel extends Component
{
    protected $listeners = ['incoming-message' => 'incomingMessage'];

    public $chats;
    public $user_id;
    public $messageCount;
    public $chat_messages = [];
    public $recipient;
    public $activeChat;
    public $type;

    public function mount()
    {
        $this->getChats();
    }

    public function getChats(){
        if($this->type == 'vendor'){
            $chats = Chat::where('chats.vendor_id',$this->user_id)
            ->join('users', 'users.id', '=', 'chats.customer_id')
            ->select('users.firstname', 'users.lastname','chats.customer_id','chats.id','chats.vendor_read_status as read_status')
            ->get();
        }elseif($this->type == 'customer'){
            $chats = Chat::where('chats.customer_id',$this->user_id)
            ->join('users', 'users.id', '=', 'chats.vendor_id')
            ->select('users.firstname', 'users.lastname','chats.vendor_id','chats.id','chats.customer_read_status as read_status')
            ->get();
        }

        $this->chats = $chats;
    }

    public function incomingMessage(Request $request, $data)
    {
        // Save it in the database and append the message to the current one
        $activeSession = $request->session()->get('activeChatSession');
        $dataJson = json_decode($data);

        if($activeSession == $dataJson->chat_id){
            $this->loadChat($request,$dataJson->chat_id);
        }else{
            $this->getChats();
        }
    }

    public function loadChat(Request $request, $chat_id){
        $chatHistory = Chat::find($chat_id);

        if(!$chatHistory){
            return ['code' => 1, 'chat_message' => ""];
        }
        $request->session()->put(['activeChatSession'=>$chat_id]);

        if($this->type == 'vendor'){
            $chatHistory->vendor_read_status = true;
            $this->recipient = $chatHistory->customer_id;
        }elseif($this->type == 'customer'){
            $chatHistory->customer_read_status = true;
            $this->recipient = $chatHistory->vendor_id;
        }

        $chatHistory->save();

        $this->activeChat = $chat_id;

        $this->getChats();

        $this->chat_messages = json_decode($chatHistory->chat_message,true);

        $this->emit('read-message');
    }

    public function render()
    {
        return view('livewire.chat-channel');
    }
}
