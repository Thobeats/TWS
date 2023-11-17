@extends('layout.admin_layout')

@section('pagetitle','Dashboard')

@section('title', 'Dashboard')

@section('content')
<style>
    li a{
        cursor: pointer;
    }
</style>
<section class="section dashboard">
    @livewire('admin-dashboard');
</section>

@endsection
