@extends('layout.vendor_layout')

@section('pagetitle','Verify Business')

@section('title', 'Verify Business')

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
                <div class="back pt-4 px-2">
                    <a href="/vendor/get_started" class="text-primary"><i class="bi bi-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Upload Docs </h5>

                      <!-- Bordered Tabs Justified -->
                      <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                          <button class="nav-link w-100 text-center {{ $step == 'ein' ? 'active' : '' }}" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">Verify EIN</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 text-center {{ $step == 'business' ? 'active' : '' }}" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Verify Proof of Business</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 text-center {{ $step == 'customer' ? 'active' : '' }}" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Verify Customer Review</button>
                        </li>
                      </ul>
                      <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                        <div class="tab-pane fade  {{ $step == 'ein' ? 'show active' : '' }}" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="container mt-4">
                                @if ($user->vendor()->verify_ein == 1)
                                    <form action="/vendor/verify/ein" method="POST" class="p-4">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="floatingName" placeholder="EIN Number" name="ein">
                                                    <label for="floatingName">EIN Number</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                @elseif($user->vendor()->verify_ein == 3)
                                    <div class="card">
                                        <div class="card-body text-center p-4">
                                            <div class="text-end">
                                                <span class="badge text-bg-success">success</span>
                                            </div>
                                        <p class="display-6 text-success">Verified!</p>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <div class="tab-pane fade {{ $step == 'business' ? 'show active' : '' }}" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">

                            @if ($user->vendor()->verify_business == 1)
                                <!-- Upload Business -->
                                <form class="row g-3 mt-4" method="POST" action="/vendor/verify/business" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="business_name" class="form-control" id="floatingName" placeholder="Business Name" value="{{$user->business_name}}">
                                            <label for="floatingName">Business Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="address" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                                            <label for="floatingTextarea">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="city" id="floatingCity" placeholder="City">
                                                <label for="floatingCity">City</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="floatingSelect" aria-label="State" name="state">

                                            </select>
                                            <label for="floatingSelect">State</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingZip" placeholder="Zip" name="zip">
                                            <label for="floatingZip">Zip</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Proof of Business</label>
                                        <input type="file" name="proof_of_bus" class="form-control" placeholder="Business Certificate" accept=".pdf,.doc,.docx">
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <!-- End floating Labels Form -->

                            @elseif ($user->vendor()->verify_business == 2)
                                <div class="card">
                                    <div class="card-body text-center p-4">
                                        <div class="text-end">
                                            <span class="badge text-bg-warning">pending</span>
                                        </div>
                                       <p class="ltext-105 text-warning">Awaiting Verification of Documents</p>
                                    </div>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-body text-center p-4">
                                        <div class="text-end">
                                            <span class="badge text-bg-success">success</span>
                                        </div>
                                    <p class="display-6 text-success">Verified!</p>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="tab-pane fade {{ $step == 'customer' ? 'show active' : '' }}" id="bordered-justified-contact" role="tabpanel" aria-labelledby="contact-tab">
                            @if ($user->vendor()->verify_customer_review == 1)
                                <form class="row g-3 mt-4" method="POST" action="/vendor/verify/customer_review" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        <input type="file" name="customer_review" class="form-control" placeholder="Business Certificate" accept=".pdf,.doc,.docx">
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            @elseif($user->vendor()->verify_customer_review == 2)
                                <div class="card">
                                    <div class="card-body text-center p-4">
                                        <div class="text-end">
                                            <span class="badge text-bg-warning">pending</span>
                                        </div>
                                    <p class="ltext-105 text-warning">Awaiting Verification of Documents</p>
                                    </div>
                                </div>
                            @elseif($user->vendor()->verify_customer_review == 3)
                                <div class="card">
                                    <div class="card-body text-center p-4">
                                        <div class="text-end">
                                            <span class="badge text-bg-success">success</span>
                                        </div>
                                    <p class="display-6 text-success">Verified!</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                      </div><!-- End Bordered Tabs Justified -->

                    </div>
                  </div>
            </div>
        </div>
    </section>

   <script>
    loadStates();


     function loadStates(){
        let select = document.getElementById('floatingSelect');
        let jsn = '/states.json';
        let option = '<option> Select State </option>';

        fetch(jsn)
            .then((response) => response.json())
            .then((json) => {
                for(let i = 0; i < json.length; i++){
                    option += `
                    <option value='${json[i]['name']}'>${json[i]['name']}</option>
                    `;
                }

                select.innerHTML = option;
            });



     }
   </script>
@endsection
