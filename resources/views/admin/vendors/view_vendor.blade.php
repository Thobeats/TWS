@extends('layout.admin_layout')

@section('pagetitle','All Vendors')

@section('title', 'Admin - All Vendors')

@section('content')

 <section class="section">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="{{ $vendor->profileImg() }}" alt="Profile" class="rounded img-fluid" width="150px">
                <h5 class="mt-3">{{ $vendor->fullname() }}</h5>
              </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profile Details</h5>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                        <div class="col-lg-9 col-md-8">{{ $vendor->fullname() }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label">Country</div>
                        <div class="col-lg-9 col-md-8">
                          USA
                        </div>
                      </div>

                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label">Address</div>
                        <div class="col-lg-9 col-md-8">
                            {{ $vendor->address()['address']}}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label">Email</div>
                        <div class="col-lg-9 col-md-8">{{ $vendor->email }}</div>
                    </div>

                      <hr>
                    <h5 class="card-title">Business Details</h5>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Business Name</div>
                        <div class="col-lg-9 col-md-8">{{ $vendor->business_name }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label ">EIN</div>
                        <div class="col-lg-9 col-md-8">{{ $vendor->ein }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
      @if (file_exists(url("/storage/public/" . $vendor->proof_of_bus)))
        <div class="col-xl-6">
          @if ($vendor->verify_business == 3)
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h5 class="card-title">Proof Of Business</h5>
                <iframe src="{{ url('/storage/public/' . $vendor->proof_of_bus) }}" frameborder="0" height="500px"></iframe>
              </div>
              <div class="p-2 text-end">
                <span class="badge bg-success">Verified <i class="bi bi-check2-circle"></i></span>
              </div>
            </div>
          @else
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h5 class="card-title">Proof Of Business</h5>
                <iframe src="{{ url("/storage/public/" . $vendor->proof_of_bus) }}" frameborder="0" height="500px"></iframe>
              </div>
              <div class="p-2 text-end">
                <a class="btn btn-primary btn-sm me-2" href="/admin/vendors/verifyBusiness/1/{{$vendor->user_id}}">Verify</a>
                <a class="btn btn-dark btn-sm" href="/admin/vendors/verifyBusiness/2/{{$vendor->user_id}}">Reject</a>
              </div>
            </div>
          @endif
        </div>        
      @endif

      @if (file_exists(url("/storage/public/" . $vendor->customer_review)))
        <div class="col-xl-6">
          @if ($vendor->verify_customer_review == 3)
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h5 class="card-title">Customer Review</h5>
                <iframe src="{{url('/storage/public/' . $vendor->customer_review)}}" frameborder="0" height="500px"></iframe>
              </div>
              <div class="p-2 text-end">
                <span class="badge bg-success">Verified <i class="bi bi-check2-circle"></i></span>
              </div>
            </div>
          @else
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h5 class="card-title">Customer Review</h5>
                <iframe src="{{url('/storage/public/' . $vendor->customer_review)}}" frameborder="0" height="500px"></iframe>
              </div>
              <div class="p-2 text-end">
                <a class="btn btn-primary btn-sm me-2" href="/admin/vendors/verifyCustomerReview/1/{{$vendor->user_id}}">Verify</a>
                <a class="btn btn-dark btn-sm" href="/admin/vendors/verifyCustomerReview/2/{{$vendor->user_id}}">Reject</a>
              </div>
            </div>
          @endif
        </div>     
      @endif
    </div>

 </section>

@endsection
