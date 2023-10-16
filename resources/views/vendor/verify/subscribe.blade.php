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
</style>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="back pt-3 px-2">
                <a href="/vendor/get_started" class="text-primary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container mt-4">
                <div class="row">
                    @forelse ($packages as $package)
                        <div class="col p-4">
                            <div class="card border">
                                <div class="card-body text-bg-light py-3 rounded">
                                    <h5 class="text-center py-2 subscribe-title">{{ $package['package_name'] }}</h5>

                                    <div class="text-center py-2">$<b class="subscribe-price ">{{ $package['package_price'] }}</b>/mo</div>

                                    <div class="details">
                                        <ul>
                                            {!! $package['details'] !!}
                                        </ul>
                                    </div>

                                    <div class="action">
                                        <a href="/vendor/plan_subscription/{{$package['id']}}" class="btn btn-dark w-100 subscribe-pay">Subscribe</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse
                    {{-- <div class="col p-4">
                        <div class="card border">
                            <div class="card-body text-bg-light py-3 rounded">
                                <h5 class="text-center py-2 subscribe-title">Advanced</h5>

                                <div class="text-center py-2">$<b class="subscribe-price ">60</b>/mo</div>

                                <div class="details">
                                    <ul>
                                        <li>Unlimited Access to the platform</li>
                                        <li>No extra charges on product sale</li>
                                        <li>Access to updates</li>
                                    </ul>
                                </div>

                                <div class="action">
                                    <a class="btn btn-dark w-100 subscribe-pay">Subscribe</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col p-4">
                        <div class="card border">
                            <div class="card-body text-bg-light py-3 rounded">
                                <h5 class="text-center py-2 subscribe-title">Basic</h5>

                                <div class="text-center py-2">$<b class="subscribe-price ">30</b>/mo</div>

                                <div class="details">
                                    <ul>
                                        <li>100 posts per month</li>
                                        <li>3.5% charge on product sale</li>
                                        <li>Access to updates</li>
                                    </ul>
                                </div>

                                <div class="action">
                                    <a class="btn btn-dark w-100 subscribe-pay">Subscribe</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

</section>



@endsection
