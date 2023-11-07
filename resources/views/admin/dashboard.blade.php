@extends('layout.admin_layout')

@section('pagetitle','Dashboard')

@section('title', 'Dashboard')

@section('content')
<section class="section dashboard">
    @livewire('admin-dashboard');
</section>

@endsection