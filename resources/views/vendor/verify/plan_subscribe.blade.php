@extends('layout.vendor_layout')

@section('pagetitle','Subscription')

@section('title', 'Subscription')

@section('content')

<style>
    a{
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
    }
    .subscribe-title{
        font-family: Poppins-Bold, 'Arial',sans-serif;
        font-weight: 900;
    }
    .subscribe-price{
        font-family: Poppins-Bold, 'Arial',sans-serif;
        font-weight: 900;
        font-size: 35px;
    }
    .subscribe-pay{
        font-weight: 700;
        text-transform: uppercase;
    }
    .details{
        font-weight: 300;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }
    .ltext-102 {
        font-family: Poppins-Bold;
        font-size: 28px;
        line-height: 1.1;
        font-weight: 800;
    }
    .ltext-103 {
        font-family: Poppins-Bold;
        font-size: 17px;
        font-weight: 700;
    }
    .stext-301 {
        font-family: Montserrat-Bold;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.1;
    }
    .btn-text{
        font-size: 18px;
    }
</style>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="back pt-3 px-2">
                <a href="/vendor/subscribe" class="text-primary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
<form action="/vendor/subscribe" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="container mt-4">
               <div class="row">
                    <div class="col-9">
                        <div class="card card-body p-3">
                            <span class="ltext-102">{{ $plan['package_name'] }}</span>
                            <input type="hidden" name="package_id" value="{{$plan['id']}}">
                        </div>
                        <div class="card mt-1">
                            <div class="card-body p-3">
                                <div class="details pt-3">
                                    <ul>
                                        {!! $plan['details'] !!}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-1">
                            <div class="card-body p-3">
                                <div class="row g-3">
                                    <div class="col-5">
                                        <span class="ltext-103">Unit Price</span>
                                    </div>

                                    <div class="col-7">
                                        <div class="text-end p-2">
                                            <span class="stext-301">$</span>
                                            <input type="text" readonly class="ltext-102 text-dark border border-0 text-start" style="width: 50px;" value="{{$plan['package_price']}}">
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="card mt-1">
                            <div class="card-body p-3">
                                <div class="row g-3">
                                    <div class="col-5">
                                        <span class="ltext-103">Subscription Cycle</span>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="p-2">
                                            <button type="button" onclick="increase()" class="btn btn-dark text-light btn-text btn-sm"><i class="bi bi-plus-lg"></i></button>
                                            <button type="button" onclick="decrease()" class="btn btn-dark text-light btn-text btn-sm"><i class="bi bi-dash-lg"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-end border border-dark p-2">
                                            <input type="text" id="cycle" name="cycle" readonly class="ltext-102 text-dark border border-0 text-end" style="width: 40px;" value="1">
                                            <span class="stext-301">Months</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <div class="col p-3">
                                <label for="packageName" class="stext-301">Total</label>
                                <input id="package_price" name="total" type="text" class="form-control ltext-102" readonly value="{{$plan['package_price']}}">
                                <input type="hidden" id="multiplier" value="{{$plan['package_price']}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-dark w-100 subscribe-pay"><i class="bi bi-credit-card"></i> PAY</button>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</form>

</section>

<script>

function increase(){
    let cycle = document.getElementById('cycle').value;
    let price = document.getElementById('multiplier').value;
    let increment = parseInt(cycle)+1;
    let product = increment * price;

    document.getElementById('cycle').value = increment;
    document.getElementById('package_price').value = product;
}

function decrease(){
    let cycle = document.getElementById('cycle').value;

    if(cycle == 1){
        return;
    }
    let price = document.getElementById('multiplier').value;
    let increment = parseInt(cycle)-1;
    let product = increment * price;

    document.getElementById('cycle').value = increment;
    document.getElementById('package_price').value = product;
}

</script>

@endsection
