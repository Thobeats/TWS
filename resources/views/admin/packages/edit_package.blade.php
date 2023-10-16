@extends('layout.admin_layout')

@section('pagetitle','New Package')

@section('title', 'Admin - New Package')

@section('content')

<section class="section dashboard">
     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit {{ $package->package_name}}</h5>

              <div class="text-end p-2">
                <a href="/admin/package/" class="btn btn-primary btn-sm">
                    <i class="bi bi-backspace"></i> Back to Packages
                </a>
              </div>

             <!-- Multi Columns Form -->
            <form class="row g-3" method="POST" action="/admin/package/update">
                @csrf
                @method('PUT')

                <input type="hidden" value="{{$package->id}}" name="id">
            <div class="col-lg-6">
                <div class="has-validation">
                    <label for="package_name" class="form-label">Package Name</label>
                    <input type="text" value="{{ $package->package_name}}" class="form-control  @error('package_name') is-invalid @enderror" id="package_name" name='package_name' >
                    <div class="invalid-feedback">
                        @error('package_name') {{ $message }} @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="has-validation">
                    <label for="package_price" class="form-label">Amount Per Month</label>
                    <input value="{{ $package->package_price}}" type="number" class="form-control  @error('package_price') is-invalid @enderror" id="package_price" name='package_price' >
                    <div class="invalid-feedback">
                        @error('package_price') {{ $message }} @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <label for="description" class="form-label">Description</label>
                <input type="text" value="{{ $package->description }}" name='description' class="form-control @error('description') is-invalid @enderror" id='description'>
                <div class="invalid-feedback">
                        @error('description') {{ $message }} @enderror
                </div>
            </div>
            <div class="col-12">
                <label for="details" class="form-label">Package Details</label>
                <textarea name='details'  class="form-control @error('details') is-invalid @enderror" rows="7" id='details'>{{ $package->details}}</textarea>
                    <div class="invalid-feedback">
                        @error('details') {{ $message }} @enderror
                    </div>
            </div>
            <div class="col-md-12">
                <div class="form-check">
                <input class="form-check-input js-switch" type="checkbox" id="status" value='1' name='status' {{ $package->status == 1 ? 'checked' : ''}}>
                <label class="form-check-label" for="status">
                    Status
                </label>
            </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form><!-- End Multi Columns Form -->


            </div>
          </div>
</section>

@endsection
