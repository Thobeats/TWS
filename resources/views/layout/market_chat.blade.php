<div id="chatForm" class="p-2">
    <div class="row">
        <div class="col">
            <h3 class="p-2">Chat</h3>
        </div>
        <div class="col">
            <div class="p-2 text-right">
                <a class="btn btn-outline-dark btn-sm" onclick="closeChat()" href="#"><i class="bi bi-x-lg"></i></a>
            </div>
        </div>
    </div>
    <hr>
    <div id="messageWrapper" class="p-2 my-2 border border-primary-subtle bg-info-light">
        @forelse ($chats as $chat)
            @if ($chat['from'] == 'customer')
                <div class="mt-4 text-right home-bg-color">
                    <p class="p-2">{{ $chat['message'] }}</p>
                    <span class="badge text-light">{{ $chat['time'] }}</span>
                </div>
            @elseif ($chat['from'] == 'vendor')
                <div class="mt-4 text-left bg-light home-text">
                    <p class="p-2">{{ $chat['message'] }}</p>
                    <span class="badge home-text">{{ $chat['time'] }}</span>
                </div>
            @endif
        @empty

        @endforelse
    </div>
    <textarea class="form-control p-1 my-2" name="" id="textArea" cols="30" rows="2"></textarea>
    <button onclick="sendMessage()" class="w-100 btn btn-home">Send</button>
</div>
