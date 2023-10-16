@extends('layout.vendor_layout')

@section('pagetitle','Verify Email')

@section('title', 'Verify Email')

@section('content')

<style>
    a{
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
    }


</style>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="back pt-3 px-2">
                    <a href="/vendor/get_started" class="text-primary"><i class="bi bi-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="card h-100">
            <div class="card-body">
                <div class="verify_wrapper mt-2 p-3 d-flex justify-content-center align-items-center">
                    <div class="verify_wrapper p-3">

                        <form action="/vendor/emailVerify" method="post" id="otpForm">
                            @csrf
                            <div class="form-group p-4 mt-2">
                                <input oninput="formSubmit(event)" type="text" name="token" class="text-center border-0 border-bottom border-dark border-1" style="font-size: 40px; outline:none;" max="6">
                            </div>
                        </form>
                        <div class="text-center ltext-104">Please Enter the OTP sent to your email</div>

                    </div>
                </div>
            </div>
        </div>
    </section>

   <script>
     function formSubmit(e){
        let length = e.target.value.length;

        if(length == 6){
            document.getElementById('otpForm').submit();
        }
    }
   </script>


@endsection
