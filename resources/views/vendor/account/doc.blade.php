@extends('layout.vendor_layout')

@section('pagetitle','Upload Document')

@section('title', 'Upload Document')

@section('content')

<section class="section dashboard">
    <div class="card">
        <div class="card-body">
             <h5 class="card-title">Upload Business Documents</h5>

             <!-- Proof Of Business -->
             <form class="row g-3" method="POST" action="/vendor/account/saveDoc" enctype="multipart/form-data">
                 @csrf
                <div class="col-lg-12 text-end">
                    <div class="form-group">
                        <input type="hidden" name="type" value="proof_of_bus">
                        <input id='proof_of_bus' type="file" name="doc" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Upload</button>
                </div>
             </form>

           </div>
    </div>

    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Upload Customer Review</h5>

          <!-- Proof Of Business -->
          <form class="row g-3" method="POST" action="/vendor/account/saveDoc" enctype="multipart/form-data">
              @csrf
             <div class="col-lg-12 text-end">
                 <div class="form-group">
                    <input type="hidden" name="type" value="customer_review">
                     <input id="customer_review" type="file" name="doc" class="form-control @error('customer_review') is-invalid @enderror">
                 </div>
                 <button type="submit" class="btn btn-primary mt-3">Upload</button>
             </div>
          </form>

        </div>
 </div>
</section>
@endsection
