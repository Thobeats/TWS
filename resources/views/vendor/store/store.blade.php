@extends('layout.vendor_layout')

@section('pagetitle',$user->business_name)

@section('title', "Vendor - $user->business_name")

@section('content')

<section class="section profile">

  <div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-end" style="height:300px; background-image: url({{ file_exists(url('storage/' . $user->vendor()->business_banner)) ? url('storage/' . $user->vendor()->business_banner) : url('images/Welcome.png')}}); background-position: center center; background-size:cover;"></div>
    </div>
  </div>
  
  <div class="profile-overview" id="profile-overview">
    <h5 class="card-title">Business Details</h5>

    <h5 class="card-title">About {{ $user->business_name }}</h5>
    <p class="small fst-italic">
        {{ $user->vendor()->about }}
    </p>
    <div class="row">
      <div class="col-lg-3 col-md-4 label ">Business Name</div>
      <div class="col-lg-9 col-md-8">{{ $user->business_name }}</div>
    </div>


    <div class="row">
      <div class="col-lg-3 col-md-4 label">Country</div>
      <div class="col-lg-9 col-md-8">
        USA
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Business Address</div>
      <div class="col-lg-9 col-md-8">
        {{ $user->address()['address']}}
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Business Phone</div>
      <div class="col-lg-9 col-md-8">
        {{ $user->phone }}
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-4 label">Business Email</div>
      <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
    </div>

  </div>
  <hr>
  <div class="row">
    <div class="col-12">
      {{-- List of Categories with number of Products --}}
      <h5 class="card-title">Products</h5>

      <div>
        @foreach ($products as $product)
          <span class="badge bg-primary">{{ $product['name'] }}</span>
        @endforeach
      </div>
    </div>
  </div>

  <div class="text-end">
    <a href="/vendor/store/setup" class="btn btn-primary btn-sm ms-auto mt-3">
      <i class="bi bi-shop"></i>
      Edit Store</a>
  </div>
 
</section>
@endsection
