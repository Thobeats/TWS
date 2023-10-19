@extends('layout.vendor_layout')

@section('pagetitle','Edit Business Details')

@section('title', 'Vendor - Edit Business Details')

@section('content')

<section class="section dashboard">
  <!-- Business Profile Edit Form -->

    <form id="logoForm" action="/vendor/profile/setLogo" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row mb-3">
            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Logo</label>
            <div class="col-md-8 col-lg-9">
                <img src="{{ $user->vendor()->business_logo() }}" alt="Profile" width="200px" id="busLogo">
                <div class="pt-2">
                    <label for="blogo" class="btn btn-primary btn-sm text-light" title="Upload logo"><i class="bi bi-upload"></i></label>
                    <input type="file" name="b_logo" id="blogo" class="d-none" onchange="uploadImage(event)" data-target="busLogo" accept=".jpg,.png,.jpeg">
                    <a href="#" class="btn btn-danger btn-sm" title="Remove logo"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <div class="col-12 text-end">
                <button class="btn btn-primary btn-sm">Save Logo</button>
            </div>
        </div>
    </form>
    <hr>
    <form id="bannerForm" action="/vendor/profile/setBanner" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row mb-3">
            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Banner</label>
            <div class="col-md-8 col-lg-9">
                <img width="600px" src="{{ $user->vendor()->business_banner() }}" alt="Profile" id="busBanner">
                <div class="pt-2">
                    <label for="banner" class="btn btn-primary btn-sm text-light" title="Upload banner"><i class="bi bi-upload"></i></label>
                    <input  type="file" name="banner" id="banner" class="d-none" onchange="uploadImage(event)" data-target="busBanner" accept=".jpg,.png,.jpeg">
                    <button type="button" onclick="resetForm('bannerForm')" class="btn btn-danger btn-sm" title="Remove banner"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <div class="col-12 text-end">
                <button class="btn btn-primary btn-sm">Save Banner</button>
            </div>
        </div>
    </form>

    <hr>
    <form method="POST" action="/vendor/profile/updateProfile">
        @method('PUT')
        @csrf

        <div class="row mb-3">
            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
            <div class="col-md-8 col-lg-9">
                <textarea name="about" class="form-control" id="about" style="height: 100px">{{ $user->vendor()->about }}</textarea>
            </div>

        </div>

        <div class="row mb-3">
          <label for="about" class="col-md-4 col-lg-3 col-form-label">Products</label>
          <div class="col-md-8 col-lg-9">
             <select name="products[]" class="js-example-basic-multiple" multiple style="width: 100%">
              @foreach ($products as $product)
                <option {{ in_array($product->id, json_decode($user->vendor()->products)) ? 'selected' : '' }} value="{{$product->id}}">{{$product->name}}</option>
              @endforeach
             </select>
          </div>

      </div>

        <div class="row mb-3">
        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Business Phone</label>
        <div class="col-md-8 col-lg-9">
            <input name="phone" type="tel" class="form-control" id="Bphone" value={{ $user->vendor()->bphone}}>
        </div>
        </div>

        <div class="row mb-3">
            <label for="website" class="col-md-4 col-lg-3 col-form-label">Website</label>
            <div class="col-md-8 col-lg-9">
            <input name="website" type="url" class="form-control" id="website" value="{{ $user->vendor()->business_website}}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
            <div class="col-md-8 col-lg-9">
            <input name="twitter" type="url" class="form-control" id="Twitter" value="{{ $user->vendor()->twitter}}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
            <div class="col-md-8 col-lg-9">
            <input name="facebook" type="url" class="form-control" id="Facebook" value="{{ $user->vendor()->facebook}}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
            <div class="col-md-8 col-lg-9">
            <input name="instagram" type="url" class="form-control" id="Instagram" value="{{ $user->vendor()->instagram}}">
            </div>
        </div>

        {{-- <div class="row mb-3">
            <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
            <div class="col-md-8 col-lg-9">
            <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
            </div>
        </div> --}}

        <div class="text-end">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form><!-- End Business Profile Edit Form -->


</section>

<script src="{{ asset('assets/js/apicalls.js')}}"></script>

@endsection
