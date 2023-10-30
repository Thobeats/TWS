@extends('layout.market_layout')

@section('title', 'Shop')


@section('content')

<style>
    .accordion a{
        color: #888;
        font-family: Poppins-Regular;
        font-size: 15px;
        line-height: 1.2;
        transition : color 900ms;
    }

    .accordion a:hover{
        color: #000;
    }
</style>
<!-- Product -->
@if (isset($catgry))
    @livewire('shop',['cats' => explode(",", $catgry)])
@else
    @livewire('shop')
@endif

@endsection
