@extends('layout.market_layout')

@section('title', $vendor->business_name)


@section('content')
<style>
    #chatForm{
        background: #fff;
        height: 100vh;
        display: none;
        position: fixed;
        bottom: 0;
        right: 0px;
        width: 350px;
        border: 3px solid #f1f1f1;
        z-index: 4000;
    }
    #messageWrapper{
        height: 70%;
        overflow-y: scroll;
        scroll-behavior: smooth;
    }
</style>
    <div class="container">

        <div class="row">
            <div class="col-lg-7">
                <div class="d-flex justify-content-end" style="height:300px; background-image: url('{{ url('storage/' . $vendor->business_banner)}}'); background-position:center; background-size:cover;"></div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-column justify-content-center align-content-center pt-4" style="height: 300px;">
                    <div class="mt-2">
                        <span class="ltext-1071 ml-3">{{ $vendor->business_name }}</span>
                        <span class="fs-18 cl11">
                            <i class="item-rating zmdi zmdi-star"></i>
                            <i class="item-rating zmdi zmdi-star"></i>
                            <i class="item-rating zmdi zmdi-star"></i>
                            <i class="item-rating zmdi zmdi-star"></i>
                            <i class="item-rating zmdi zmdi-star"></i>
                        </span>
                    </div>
                    <div class="mt-2">
                        <a href="?step=reviews#about" class="btn btn-outline-primary btn-sm mr-2">
                            <i class="item-rating zmdi zmdi-star"></i>
                            View Reviews
                        </a>

                        @if($check == false)
                        <span onclick="subscribe(event)" data-vendorid = "{{ $vendor->user_id }}" style="cursor: pointer" class="btn btn-outline-danger btn-sm mr-2">
                            <i class="item-rating zmdi  zmdi-notifications"></i>
                            Subscribe
                        </span>
                        @else
                            <span onclick="subscribe(event)" data-vendorid = "{{ $vendor->user_id }}" style="cursor: pointer" class="btn btn-outline-danger btn-sm mr-2">
                                <i class="item-rating zmdi  zmdi-check"></i>
                                Unsubscribe
                            </span>
                        @endif

                        <a class="btn btn-outline-success btn-sm" href="#" onclick="openChat()">
                            <i class="zmdi zmdi-comments"></i>
                            Chat with the Vendor
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Subscribe and Chat --}}
        <div class="row mt-3">
             <!-- Chat -->
             @include('layout.market_chat')
        </div>

        @forelse ($cProducts as $cp)
            @if($cp['products'] != [])
                <div class="vendor_products mt-5 p-2">
                    <div class="p-b-32">
                        <h6 class="ltext-107 cl5 txt-left respon1">
                            {{ $cp['category_name'] }}
                        </h6>
                    </div>

                    <div class="wrap-slick2">
                        <div class="slick2">
                        @foreach ($cp['products'] as $product)
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-pic hov-img0">
                                        <img src="{{ url('storage/products/'. json_decode($product['pics'],true)[0]) }}" alt="IMG-PRODUCT">
                                    </div>

                                    <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                                        <div class="block2-txt-child1 flex-col-l">
                                            <a href="/market/product/{{$product['id']}}" class="mtext-101 cl2 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                {{ $product['name'] }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @empty
        @endforelse
        <div class="row my-3" id="about">
            <div class="col-lg-12">
                <div class="bor10 m-t-50 p-t-43 p-b-40">
                    <!-- Tab01 -->
                    <div class="tab01">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item p-b-10">
                                <a class="nav-link {{ $step == 'about' ? 'show active' : ''}}" href="?step=about#about" role="tab">About {{ $vendor->business_name }}</a>
                            </li>

                            <li class="nav-item p-b-10">
                                <a class="nav-link {{ $step == 'reviews' ? 'show active' : ''}}"  href="?step=reviews#about" role="tab">All Reviews</a>
                            </li>

                            <li class="nav-item p-b-10">
                                <a class="nav-link {{ $step == 'new_review' ? 'show active' : ''}}" href="?step=new_review#about" role="tab">New Review</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-t-43" id="review">
                            <!-- - -->
                            <div class="tab-pane fade {{ $step == 'about' ? 'show active' : ''}}" id="description" role="tabpanel">
                                <div class="how-pos2 p-lr-15-md">
                                    <div class="mtext-101 cl6 text-center">
                                        {{ $vendor->about }}
                                    </div>
                                </div>
                            </div>

                            <!-- - -->
                            <div class="tab-pane fade {{ $step == 'reviews' ? 'show active' : ''}}" id="information" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                        <!-- Review -->
                                        @forelse ($vendor->reviews() as $review)
                                            <div class="flex-w flex-t p-b-68">
                                                <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                    <img src="{{url('storage/' . $review->profile)}}" alt="AVATAR">
                                                </div>

                                                <div class="size-207">
                                                    <div class="flex-w flex-sb-m p-b-17">
                                                        <span class="mtext-107 cl2 p-r-20">
                                                            {{ $review->firstname }} {{ $review->lastname }}
                                                        </span>

                                                        <span class="fs-18 cl11">
                                                            {{-- <i class="zmdi zmdi-star"></i>
                                                            <i class="zmdi zmdi-star"></i>
                                                            <i class="zmdi zmdi-star"></i>
                                                            <i class="zmdi zmdi-star"></i>
                                                            <i class="zmdi zmdi-star-half"></i> --}}
                                                            @for ($i = 0; $i < $review->rating; $i++)
                                                            <i class="zmdi zmdi-star"></i>
                                                            @endfor
                                                        </span>
                                                    </div>

                                                    <p class="stext-102 cl6">
                                                        {{ $review->comment }}
                                                    </p>
                                                </div>
                                            </div>
                                        @empty

                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- - -->
                            <div class="tab-pane fade {{ $step == 'new_review' ? 'show active' : ''}}" id="reviews" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                        <div class="p-b-30 m-lr-15-sm">
                                            <!-- Add review -->
                                            <form class="w-full" action="{{ route('vendor.review') }}" method="POST">
                                                @csrf
                                                <h5 class="mtext-108 cl2 p-b-7">
                                                    Add a review
                                                </h5>

                                                <p class="stext-102 cl6">
                                                    Your email address will not be published. Required fields are marked *
                                                </p>

                                                <div class="flex-w flex-m p-t-50 p-b-23">
                                                    <span class="stext-102 cl3 m-r-16">
                                                        Your Rating
                                                    </span>

                                                    <span class="wrap-rating fs-18 cl11 pointer">
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <input class="dis-none" type="number" name="rating">
                                                    </span>

                                                    <div class="invalid-feedback">
                                                        @error('rating') {{ $message }} @enderror
                                                    </div>
                                                </div>

                                                <div class="row p-b-25">
                                                    <div class="col-12 p-b-5">
                                                        <label class="stext-102 cl3" for="review">Your review</label>
                                                        <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="comment"></textarea>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        @error('comment') {{ $message }} @enderror
                                                    </div>

                                                    {{-- <div class="col-sm-6 p-b-5">
                                                        <label class="stext-102 cl3" for="name">Name</label>
                                                        <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name">
                                                    </div>

                                                    <div class="col-sm-6 p-b-5">
                                                        <label class="stext-102 cl3" for="email">Email</label>
                                                        <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
                                                    </div> --}}
                                                </div>

                                                <input type="hidden" name="vendor_id" value="{{$vendor->user_id}}">

                                                <button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                    Submit
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
                    <span class="stext-107 cl6 p-lr-25">
                        SKU: {{ $product->sku }}
                    </span>

                    <span class="stext-107 cl6 p-lr-25">
                        Categories: @foreach ($product->categories() as $ct)
                            <a class="mx-2" href="{{$ct->id}}">{{$ct->name}}</a>
                        @endforeach
                    </span>
                </div> --}}
            </div>
        </div>

        {{-- @if($product->otherVendorProducts()->count() > 0)
        <hr>
        <section class="sec-product bg0 p-b-50">
            <div class="container">
                <div class="p-b-32">
                    <h6 class="ltext-107 cl5 txt-left respon1">
                       Other Products By {{$product->vendor()['name']}}
                    </h6>
                </div>

                <div class="wrap-slick2">
                    <div class="slick2">
                        @foreach ($product->otherVendorProducts() as $product)
                             <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG-PRODUCT">

                                    <a href="/market/product/{{$product->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product="{{$product->id}}">
                                        Quick View
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $product->name }}
                                        </a>

                                        <span class="stext-105 cl3">
                                            ${{ $product->price }}
                                        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04" src="/images/icons/icon-heart-01.png" alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="/images/icons/icon-heart-02.png" alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
        @endif

        @if($product->otherProducts()->count() > 0)
        <hr>
        <section class="sec-product bg0 p-b-50">
            <div class="container">
                <div class="p-b-32">
                    <h6 class="ltext-107 cl5 txt-left respon1">
                       Other Products
                    </h6>
                </div>

                <div class="wrap-slick2">
                    <div class="slick2">

                        @foreach ($product->otherProducts() as $product)
                         <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG-PRODUCT">

                                    <a href="/market/product/{{$product->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product="{{$product->id}}">
                                        Quick View
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $product->name }}
                                        </a>

                                        <span class="stext-105 cl3">
                                            ${{ $product->price }}
                                        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04" src="/images/icons/icon-heart-01.png" alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="/images/icons/icon-heart-02.png" alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                         </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
        @endif --}}
    </div>

    <script>
        function subscribe(e){
            let vendorId = e.target.dataset.vendorid;

            fetch(`/market/subscribe/vendor/${vendorId}`, {
                method : "GET",
                headers : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
                },
            })
            .then(response => response.json())
            .then(json => {
                if (json.code == 0){
                    e.target.innerHTML = `
                    <i class="item-rating zmdi  zmdi-check"></i>
                        Unsubscribe
                    `;
                }

               if (json.code == 1){
                    e.target.innerHTML = `
                        <i class="item-rating zmdi  zmdi-notifications"></i>
                        Subscribe
                    `;
                }
            });
        }

        function closeChat(){
            document.getElementById("chatForm").style.display = 'none';
        }

        function openChat(){
            document.getElementById("chatForm").style.display = 'block';
        }


        const messageWrapper = document.getElementById('messageWrapper');
        const message = document.getElementById('textArea');
        const recipient = "{{$vendor->user_id}}";
        const time = "{{ date_format(date_create(now()), 'H:i a | M d') }}";
        socket.onopen = function(e) {
            console.log("[open] Connection established");
        };

        function sendMessage(){
            if(message.value == ""){
                return;
            }

            let data = {
                recipient : recipient,
                from : "{{$user->id}}",
                message : message.value,
                source : "customer",
                time : time,
                customerName : "{{ $user->fullname()}}",
                _token : "{{ csrf_token() }}"
            };

            console.log(data);

            myMessage(data);
            saveChat(data);
            message.value = "";

        }

        function myMessage(data){
            let myTemplate = `
                <div class="mt-4 text-right home-bg-color">
                    <p class="p-2">${data.message}</p>
                    <span class="badge text-light">${data.time}</span>
                </div>
            `;
            messageWrapper.innerHTML += myTemplate;
        }

        function incomingMessage(data){
            let responseTemplate = `
                <div class="mt-4 text-left bg-light home-text">
                    <p class="p-2">${data.message}</p>
                    <span class="badge home-text">${data.time}</span>
                </div>
            `;
            messageWrapper.innerHTML += responseTemplate;
        }


        function saveChat(data){
            fetch('/market/saveChat', {
                method : "POST",
                headers : {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response=>response.json())
            .then(json=>{
                data.chat_id = json.message.id;
                socket.send(JSON.stringify(data));
            })
        }

    </script>

@endsection
