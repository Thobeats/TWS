@extends('layout.vendor_layout')

@section('pagetitle',"Create customer profile")

@section('title', 'Vendor - switch to customer')

@section('content')

<section class="section dashboard">
  <div class="card">
    <div class="card-body">
     @if($hasUploaded)
      <div class="mt-3 p-3 text-center">
        <h5 class="text-primary">Document Uploaded for Approval</h5>
      </div>
     @else
      <form action="/vendor/customer/switch" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mt-4">
          <label for="" class="text-bold">Upload Reseller Certificate</label>
          <input type="file" name="reseller_cert" class="form-control mt-2" accept=".pdf,.doc,.docx">
        </div>
        <div class="form-group text-end mt-3">
          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>

      </form>
     @endif
    </div>
  </div>
</section>
@endsection
