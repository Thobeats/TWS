@extends('layout.vendor_layout')

@section('pagetitle','Account Setup')

@section('title', 'Create Payment Account')

@section('content')

<style>
    .card-input{
        border-bottom: 1px solid #ccc;
        padding: 10px;
    }
</style>
    <section class="section">
        <div class="card p-3 card-body">
            <div class="row">
                <div class="col-lg-4">
                    <h6>Payment Account</h6>
                </div>
                <div class="col-lg-8 text-center">
                    @if (!$stripe_verification)
                    <a class="btn btn-primary w-50" href="/vendor/account/setup/initiate/{{$accountID}}">Setup Account</a>
                    @else
                    <span class="badge bg-success">Verified <i class="bi bi-check2-circle"></i></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card p-3 card-body">
            <div class="row">
                <div class="col-lg-4">
                    <h6>Card Setup</h6>
                </div>
                <div class="col-lg-8 text-center">
                    @if (!$hasCard)
                        <form method="post" id="payment-form" class='row card card-body p-5' style="width:500px;">
                            <h5>Credit or Debit Card</h5>
                            <div class="col-lg-12 p-5">
                                <div class="card-input" id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display Element errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>

                            <div class="col-lg-12 px-5">
                                <button class="btn btn-primary w-100">Create</button>
                            </div>
                        </form>
                    @else
                        <span class="badge bg-success">Verified <i class="bi bi-check2-circle"></i></span>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
