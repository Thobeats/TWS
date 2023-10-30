@extends('layout.market_layout')

@section('title', 'Cart')


@section('content')

<div class="container pt-5">
    <h4 class="ltext-109 cl2 p-b-30">
        Shopping Cart
    </h4>
</div>

<!-- Shopping Cart -->
    <div class="container">
        @livewire('cart-item', ['user' => $user])
    </div>



@endsection
