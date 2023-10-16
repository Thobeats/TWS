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
    <section class="section d-flex justify-content-center p-5">
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
    </section>
@endsection
