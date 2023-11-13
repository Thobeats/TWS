@extends('layout.admin_layout')

@section('pagetitle','New Subscription')

@section('title', 'Admin - New Subscription')

@section('content')

 <section class="section">
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add New Subscription</h5>

          <!-- Multi Columns Form -->
          <form class="row g-3" method="POST" action="/admin/subscription/store">
              @csrf
            <div class="col-md-6">
                <div class="has-validation">
                    <label for="package_name" class="form-label">Vendor</label>
                    <select id="vendor_name" name='vendor_name' class="form-select">
                        <option value="">Select Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{$vendor->account_id }}">{{ $vendor->business_name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                      @error('vendor_name') {{ $message }} @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="has-validation">
                    <label for="package_name" class="form-label">Package</label>
                    <select id="package_name" name='package_name' class="form-select" onchange="selectPackage(event)">
                        <option value="">Select Package</option>
                        @foreach ($packages as $package)
                            <option value="{{$package->id }}">{{ $package->package_name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                      @error('package_name') {{ $message }} @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="package_details border p-2 d-none">
                    <div class="row">
                        <div class="col">
                            <label for="">Package</label>
                            <h5 id="package">Premium</h5>
                        </div>
                        <div class="col">
                            <label for="">Price</label>
                            <h5 id="package">$100</h5>
                        </div>
                    </div>

                    <div class="row mt-3 p-2">
                        <div class="col d-flex">
                            <div class="p-2">
                                <button type="button" onclick="increase()" class="btn btn-dark text-light btn-text btn-sm"><i class="bi bi-plus-lg"></i></button>
                                <button type="button" onclick="decrease()" class="btn btn-dark text-light btn-text btn-sm"><i class="bi bi-dash-lg"></i></button>
                            </div>
                            <div class="text-end border border-dark p-2">
                                <input type="text" id="cycle" name="cycle" readonly class="ltext-102 text-dark border border-0 text-end" style="width: 40px;" value="1">
                                <span class="stext-301">Months</span>
                                <input type="hidden" value="100" id="multiplier">
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="p-2 bg-dark text-light">
                                Total: $<span id="total_price">100</span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
              <button type="submit" disabled class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form><!-- End Multi Columns Form -->

        </div>
      </div>
    </section>

    <script>
        function increase(){
            let cycle = document.getElementById('cycle').value;
            let price = document.getElementById('multiplier').value;
            let increment = parseInt(cycle)+1;
            let product = increment * price;

            document.getElementById('cycle').value = increment;
            document.getElementById('total_price').innerHTML = product;
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
            document.getElementById('total_price').innerHTML = product;
        }
    </script>


@endsection
