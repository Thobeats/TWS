@extends('layout.market_layout')

@section('title', 'All Vendors')


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
{{-- All Vendors --}}

<section style="min-height: 100vh;">
    @livewire('vendors-page')
</section>
@endsection
