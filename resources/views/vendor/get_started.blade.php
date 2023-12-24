@extends('layout.vendor_layout')

@section('pagetitle','Get Started')

@section('title', 'Get Started')

@section('content')

<style>
    p{
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
    }
</style>
    <section class="section">
        <div class="row">
            <div class="col-3 p-2">
               <a href="/vendor/profile">
                    <div class="card">
                        <div class="card-body pb-4">
                            <div class="text-end {{($user->profile != null) ? 'text-success text-bold' : 'text-secondary' }} py-2"><i class="bi bi-check-circle-fill"></i></div>
                            <h3 class="text-center display-5 text-dark"><i class="bi bi-person-fill"></i></h3>
                            <p class="text-secondary d-block text-small text-center">Set Profile</p>
                        </div>
                    </div>
               </a>
            </div>
            <div class="col-3 p-2">
                <a href="/vendor/store/setup">
                     <div class="card">
                         <div class="card-body pb-4">
                             <div class="text-end {{($user->vendor()->business_banner != null) ? 'text-success text-bold' : 'text-secondary' }} py-2"><i class="bi bi-check-circle-fill"></i></div>
                             <h3 class="text-center display-5 text-dark"><i class="bi bi-shop"></i></h3>
                             <p class="text-secondary d-block text-small text-center">Setup Store</p>
                         </div>
                     </div>
                </a>
            </div>
            <div class="col-3 p-2">
                <a href='/vendor/verify_business'>
                     <div class="card">
                         <div class="card-body pb-4">
                            <div class="text-end {{$user->vendor()->verify_business == 3 ? 'text-success' : 'text-secondary' }} py-2"><i class="bi bi-check-circle-fill"></i></div>
                            <h3 class="text-center display-5 text-dark"><i class="bi bi-building-check"></i></h3>
                            <p class="text-secondary d-block text-small text-center">Verify Business</p>
                         </div>
                     </div>
                </a>
            </div>
            <div class="col-3 p-2">
                <a href="/vendor/account/setup">
                     <div class="card">
                         <div class="card-body pb-4">
                             <div class="text-end {{ $user->vendor()->payment_setup ? 'text-success' : 'text-secondary' }} py-2"><i class="bi bi-check-circle-fill"></i></div>
                             <h3 class="text-center display-5 text-dark"><i class="bi bi-credit-card"></i></h3>
                             <p class="text-secondary d-block text-small text-center">Payment Setup</p>
                         </div>
                     </div>
                </a>
            </div>
            <div class="col-3 p-2">
                <a href='/vendor/subscribe'>
                     <div class="card">
                         <div class="card-body pb-4">
                            <div class="text-end {{ $user->vendor()->subscribed ? 'text-success' : 'text-secondary' }} py-2"><i class="bi bi-check-circle-fill"></i></div>
                             <h3 class="text-center display-5 text-dark"><i class="bi bi-arrow-repeat"></i></h3>
                             <p class="text-secondary d-block text-small text-center">Subscribe Plan</p>
                         </div>
                     </div>
                </a>
            </div>
            <div class="col-3 p-2">
                <a id='take-a-tour' href="#">
                     <div class="card">
                         <div class="card-body pb-4">
                             <div class="text-end text-secondary py-2"><i class="bi bi-check-circle-fill"></i></div>
                             <h3 class="text-center display-5 text-dark"><i class="bi bi-map"></i></h3>
                             <p class="text-secondary d-block text-small text-center">Take a Tour</p>
                         </div>
                     </div>
                </a>
             </div>
             <div class="col-3 p-2">
                 <a href="">
                      <div class="card">
                          <div class="card-body pb-4">
                             <div class="text-end text-secondary py-2"><i class="bi bi-check-circle-fill"></i></div>
                              <h3 class="text-center display-5 text-dark"><i class="bi bi-info-circle"></i></h3>
                              <p class="text-secondary d-block text-small text-center">FAQ</p>
                          </div>
                      </div>
                 </a>
             </div>

        </div>

    </section>
@endsection
