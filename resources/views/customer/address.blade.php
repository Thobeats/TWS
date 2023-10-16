@extends('layout.customer_new_layout')

@section('title', 'My Account')

@section('pagetitle', 'Addresses')

@section('content')
<section class="p-2">
    <div class="row">
        <div class="col-12 text-end">
            <a href="{{ route('customer_new_address')}}" class="btn btn-primary btn-sm">Add New Address</a>
        </div>
        @php
            $address = json_decode($user->address,true);
        @endphp
        @if(!is_null($address))
        @foreach ($address as $key => $add)
        <div class="col-lg-4 mt-3">
            <div class="card border-dark">
                 <div class="card-body p-2 text-dark">
                    <div class="name text-uppercase h6 fw-bold">
                        {{ $add['fname'] . " " . $add['lname']}}
                    </div>
                    <p class="address">
                        {{ $add['delivery_address']}}
                    </p>
                    <p class="address">
                        {{ $add['region'] . ", " . $add['country']}}
                    </p>
                    <p class="address">
                        {{ $add['zip']}}
                    </p>
                    <p class="phone text-secondary">
                        {{ $add['phone'] . " " . $add['add_phone']}}
                    </p>
                </div>
                <div class="card-title pt-2 px-3" style="border-top: 1px solid #000;">
                    <a href="{{ route('make_default', $key) }}"  class="text-dark {{ $key == 0 ? 'disabled' : '' }}">
                        <i class="bi {{ $key == 0 ? 'bi-circle-fill' : 'bi-circle' }}" style="font-size: 20px"></i>
                    </a>
                    <a href="{{ route('edit_address', $key)}}" class="text-primary" style="position: absolute; right:30px">
                        <i class="bi bi-pencil-square" style="font-size: 20px"></i>
                    </a>
                    <a href="{{ route('delete_address', $key)}}" class="text-danger" style="position: absolute; right:10px">
                        <i class="bi bi-trash" style="font-size: 20px"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</section>

@endsection

