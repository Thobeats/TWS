@extends('layout.customer_new_layout')

@section('pagetitle','Chat')

@section('title', 'Chat')

@section('content')

<style>
    p{
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;
    }
    #loading{
        z-index: 30;
        position: absolute;
        top: 40%;
        left: 50%;
    }
    #message-wrapper{
        overflow-y: scroll;
        scroll-behavior: smooth;
    }
    .time-text{
        font-size: 10px;
    }
</style>
<section class="section">
    @livewire('chat-channel', ['user_id' => $user->id, 'type' => 'customer'])
</section>

<script>
    const messageWrapper = document.getElementById('message-wrapper');
    const message = document.getElementById('textArea');
    const spinner = document.getElementById("loading");
    const recipient = document.getElementById('recipient');
    const time = "{{ date_format(date_create(now()), 'H:i a | M d') }}";
    const sideBarNav = document.getElementById("chat-sidebar");
    const sessions = "{{ implode(',',$sessions)}}";
    const activeChatSession = "{{session('activeChatSession')}}";


    socket.onopen = function(e) {
        console.log("[open] Connection established");
      //  socket.send("My name is John");
    };

    socket.onmessage = (event) => {
        /**@argument
         *
         * The idea is this, if a new chat comes in while a session is going,
         * Add the new tag to the customers name on the tray, by the way if the
         * new message belongs to the current session append the messages to the dialogue
         *
         * **/
        let data = JSON.parse(event.data);
        Livewire.emit('incoming-message', event.data);

        messageWrapper.scroll({
            top: messageWrapper.scrollHeight,
            left: 100,
            behavior: "smooth",
        });

        // console.log(data);
        // loadTray(data);


        // if(data.chat_id == activeChatSession){
        //     incomingMessage(data);
        // }else{
        //     document.getElementById(`new${data.chat_id}`).style.display = 'block';
        // }
    };

    function chat(){
        if(recipient.value == "" || message.value == ""){
            return;
        }

        let data = {
            recipient : recipient.value,
            message : message.value,
            source : "customer",
            time : time,
            from : "{{ $user->id}}",
            _token : "{{ csrf_token() }}",
            chat_id : "{{session('activeChatSession')}}"
        };

        myMessage(data);
        message.value = "";
        saveChat(data);
       // socket.send(JSON.stringify(data));
    }

    function loadChat(chat_id, customer_id){
        spinner.classList.remove("d-none");

        const postData ={
            _token : "{{ csrf_token() }}",
            chat_id : chat_id
        };

        fetch("/vendor/chatHistory",{
            method : "POST",
            headers : {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(postData)
        })
        .then(response => response.json())
        .then(json => {
            console.log(json)
            spinner.classList.add("d-none");
            messageWrapper.innerHTML = "";
            document.getElementById(`new${chat_id}`).style.display = 'none';
            recipient.value = customer_id;

           for(let record of json.chat_message){
                if(record.from == 'customer'){
                    incomingMessage(record);
                }

                if(record.from == 'vendor'){
                    myMessage(record);
                }
           }
        })
        .catch(error => {
            // Handle any errors that occurred during the fetch
            console.error('Fetch error:', error);
        });

    }


    function myMessage(data){
        let myTemplate = `
        <div class="mt-4 d-flex flex-column align-items-end">
            <div class="text-start home-text border rounded-2 p-2" style="width: fit-content;">
                <p class="p-1 mb-0">${data.message}</p>
                <span class="time-text home-text">${data.time}</span>
            </div>
        </div>
        `;
        messageWrapper.innerHTML += myTemplate;
    }

    function incomingMessage(data){
        let responseTemplate = `
        <div class="mt-4">
            <div class="text-start home-bg-color text-light border rounded-2 p-2" style="width: fit-content;">
                <p class="p-1 mb-0">${data.message}</p>
                <span class="time-text text-light">${data.time}</span>
            </div>
        </div>
        `;
        messageWrapper.innerHTML += responseTemplate;
    }

    function loadTray(data){
        if(!sessions.split().includes(`${data.chat_id}`)){
            let sideTemplate = `
                <li class="nav-item">
                    <a onclick="loadChat(${data.chat_id})" href="#" class="nav-link justify-content-between bg-white border border-primary text-center text-primary">
                        <span>${data.customerName}</span>
                        <span id="new${data.chat.id}" class="badge text-danger">new</span>
                    </a>
                </li>
            `;
            sideBarNav.innerHTML += sideTemplate;
        }
    }

    function saveChat(data){
        fetch('/customer/saveChat', {
            method : "POST",
            headers : {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response=>response.json())
        .then(json=>{
            socket.send(JSON.stringify(data));
        })
    }


</script>
@endsection
