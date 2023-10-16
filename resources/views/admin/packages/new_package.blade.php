@extends('layout.admin_layout')

@section('pagetitle','New Package')

@section('title', 'Admin - New Package')

@section('content')

 <section class="section">
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add New Package</h5>

          <!-- Multi Columns Form -->
          <form class="row g-3" method="POST" action="/admin/package/store">
              @csrf
            <div class="col-lg-6">
                <div class="has-validation">
                    <label for="package_name" class="form-label">Package Name</label>
                    <input type="text" class="form-control  @error('package_name') is-invalid @enderror" id="package_name" name='package_name' >
                    <div class="invalid-feedback">
                      @error('package_name') {{ $message }} @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="has-validation">
                    <label for="package_price" class="form-label">Amount Per Month</label>
                    <input type="number" class="form-control  @error('package_price') is-invalid @enderror" id="package_price" name='package_price' >
                    <div class="invalid-feedback">
                      @error('package_price') {{ $message }} @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <label for="description" class="form-label">Description</label>
                <input type="text" name='description' class="form-control @error('description') is-invalid @enderror" id='description'>
                 <div class="invalid-feedback">
                      @error('description') {{ $message }} @enderror
                 </div>
            </div>
            <div class="col-12">
                <label for="details" class="form-label">Package Details</label>
                <textarea name='details' class="form-control @error('details') is-invalid @enderror" rows="7" id='details'></textarea>
                    <div class="invalid-feedback">
                        @error('details') {{ $message }} @enderror
                    </div>
            </div>
            <div class="col-md-12">
              <div class="form-check">
                <input class="form-check-input js-switch" type="checkbox" id="status" value='1' name='status' checked>
                <label class="form-check-label" for="status">
                  Status
                </label>
            </div>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form><!-- End Multi Columns Form -->

        </div>
      </div>
    </section>

@endsection
