@extends('layout.market_auth')

@section('title', 'Confirm Email')

@section('form')
    <form action="" class='w-50 p-4 bg-white border rounded mb-5'>
        <div class="d-flex my-4">
            <div class='d-flex flex-even align-items-center'>
                <p class='auth_title'>Confirm Email</p>
            </div>
        </div>
        <div class="form-group">
            <input type="number" name="otp" placeholder="Enter OTP here" class="form-control">
        </div>
        <div class="form-group mt-2">
            <button type="submit" class="btn btn-home w-100">Register</button>
        </div>
    </form>
@endsection
