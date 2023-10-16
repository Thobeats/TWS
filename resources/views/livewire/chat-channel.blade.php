<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <div class="row">
        <div class="col-lg-3">
            <aside id="sidebar" class="bg-white border-dark p-2" style="height: 80vh;">
                <p class="text-center p-3 home-bg-color text-light">All Conversations</p>
                <ul class="sidebar-nav text-center" id="chat-sidebar">
                    @forelse ($chats as $chat)
                        <li class="nav-item">
                            {{-- <a onclick="loadChat({{$chat->id}}, {{$chat->customer_id}})" href="#" class="nav-link justify-content-between bg-white border border-primary text-center text-primary"> --}}
                            <a wire:click="loadChat({{$chat->id}})" href="#newChat">
                                <div class="card">
                                    <div class="card-body p-2 {{ $activeChat == $chat->id ? 'home-bg-color text-light fw-bold' : 'home-text' }}">
                                      <div class="d-flex align-items-center justify-content-between mb-0">
                                        <span class="text-start chat-user-name">{{ strtolower($chat->firstname . " " . $chat->lastname) }}</span>
                                        <span class="badge text-danger {{ $chat->read_status == 1 ? 'd-none' : 'd-block'}}">new</span>
                                      </div>
                                    </div>
                                </div>
                            </a>


                        </li>
                    @empty

                    @endforelse
                </ul>
            </aside>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body py-2" style="height: 80vh;">
                    <input type="hidden" id="recipient" value="{{$recipient}}">
                    <div id="message-wrapper" class="messages mt-3 mb-1 border border-2 border-secondary-subtle rounded p-2" style="height:75%;">
                        {{-- <div id="loading" class="spinner-border d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div> --}}

                        @if ($type == 'vendor')
                            @forelse ($chat_messages as $chat_message)
                                @if($chat_message['from'] == 'customer')
                                    <div class="mt-4">
                                        <div class="text-start home-bg-color text-light border rounded-2 p-2" style="width: fit-content;">
                                            <p class="p-1 mb-0">{{ $chat_message['message'] }}</p>
                                            <span class="time-text text-light">{{ $chat_message['time'] }}</span>
                                        </div>
                                    </div>
                                @elseif ($chat_message['from'] == 'vendor')
                                <div class="mt-4 d-flex flex-column align-items-end">
                                    <div class="text-start home-text border rounded-2 p-2" style="width: fit-content;">
                                        <p class="p-1 mb-0">{{ $chat_message['message'] }}</p>
                                        <span class="time-text home-text">{{ $chat_message['time'] }}</span>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <div class="mt-4 text-center bg-light">
                                    <p class="p-1 text-dark">No Message</p>
                                </div>
                            @endforelse
                        @elseif($type == 'customer')
                            @forelse ($chat_messages as $chat_message)
                                @if($chat_message['from'] == 'customer')
                                    <div class="mt-4 d-flex flex-column align-items-end">
                                        <div class="text-start home-text border rounded-2 p-2" style="width: fit-content;">
                                            <p class="p-1 mb-0">{{ $chat_message['message'] }}</p>
                                            <span class="time-text home-text">{{ $chat_message['time'] }}</span>
                                        </div>
                                    </div>
                                @elseif ($chat_message['from'] == 'vendor')
                                    <div class="mt-4">
                                        <div class="text-start home-bg-color text-light border rounded-2 p-2" style="width: fit-content;">
                                            <p class="p-1 mb-0">{{ $chat_message['message'] }}</p>
                                            <span class="time-text text-light">{{ $chat_message['time'] }}</span>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="mt-4 text-center bg-light">
                                    <p class="p-1 text-dark">No Message</p>
                                </div>
                            @endforelse
                        @endif


                    </div>
                    <div class="chat-form text-end" style="height: 20%;">
                        <textarea name="" id="textArea" cols="30" rows="1" class="form-control mb-1 p-2 border border-primary-subtle border-2"></textarea>
                        <button onclick="chat()" class="btn btn-home btn-sm px-3"> Send <i class="bi bi-send-fill"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
