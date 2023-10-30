@extends('layout.market_layout')

@section('title', 'Cart')


@section('content')

<div class="container pt-5">
    <h4 class="ltext-109 cl2 p-b-30">
        Shopping Cart
    </h4>
</div>

<!-- Shopping Cart -->
<form method="POST" action="/setCartSession" class="bg0 p-t-75 p-b-85">
    @csrf
    <div class="container">
        @livewire('cart-item', ['user' => $user])
    </div>
</form>


@endsection
