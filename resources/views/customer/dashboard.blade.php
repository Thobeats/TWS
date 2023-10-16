@extends('layout.customer_new_layout')

@section('pagetitle','Dashboard')

@section('title', 'Dashboard')

@section('content')

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            @livewire('customer-dashboard')

            {{-- Recent Orders --}}


        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            {{-- Notification Tray --}}

            @livewire('notification-tray')

        </div>

    </div>
</section>

@endsection

