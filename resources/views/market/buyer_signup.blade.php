@extends('layout.market_auth')

@section('title', 'Buyer - Sign Up')

@section('form')
    <form action="{{ route('saveBuyer') }}" method="POST" class='w-50 p-4 bg-white rounded' enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="d-flex my-4">
            <div class='d-flex flex-even align-items-center'>
                <p class='auth_title'>Sign Up</p>
            </div>
        </div>
        <div class="form-group">
            <label for="firstname">First Name <span class='text-danger'>*</span> </label>
            <input type="text" value="{{ old('firstname') }} @error('firstname') {{ $message }} @enderror" required name="firstname" class="form-control @error('firstname') is-invalid text-danger @enderror">
        </div>
        <div class="form-group">
            <label for="lastname">Last Name <span class='text-danger'>*</span> </label>
            <input type="text" name="lastname" value="{{ old('lastname') }} @error('lastname') {{ $message }} @enderror" required class="form-control @error('lastname') is-invalid text-danger @enderror">
        </div>
        <div class="form-group">
            <label for="email">Email <span class='text-danger'>*</span> </label>
            <input type="email" name="email" value="{{ old('email') }} @error('email') {{ $message }} @enderror" required class="form-control @error('email') is-invalid text-danger @enderror">
        </div>
        <div class="form-group">
            <label for="password">Password <span class='text-danger'>*</span> </label>
            <input type="password" name="password" required class="form-control @error('password') is-invalid text-danger @enderror" data-toggle="password">
            @error('password')
                <p class='py-2 text-danger'>{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="business_name">Business Name <span class='text-danger'>*</span> </label>
            <input type="text" name="business_name" value="{{ old('business_name') }} @error('business_name') {{ $message }} @enderror" required class="form-control @error('business_name') is-invalid text-danger @enderror">
        </div>
        <div class="form-group">
            <label for="zip_code">Zip Code <span class='text-danger'>*</span> </label>
            <input type="number" name="zip_code" value="{{ old('zip_code') }} @error('zip_code') {{ $message }} @enderror" required class="form-control @error('zip_code') is-invalid text-danger @enderror">
        </div>
        <div class="form-group">
            <label for="address">Address <span class='text-danger'>*</span> </label>
            <textarea name="address" value="{{ old('address') }} @error('address') {{ $message }} @enderror" required class="form-control @error('address') is-invalid text-danger @enderror" rows="5"></textarea>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                    <label> Reseller Certificate <span class='text-danger'>*</span> </label>
                    <div class="custom-file">
                        <input name='cert' type="file" class="custom-file-input" id="certFile"/>
                        <label class="custom-file-label" for="certFile">Choose file</label>
                        @error('cert')
                            <p class="py-2 text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    {{-- <div class="custom-file">
                        <input name="cert" type="file" >
                        {{-- <label class="custom-file-label" for="cert">Choose file</label>

                    </div> --}}
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                    <label> Additional Files </label>
                    <div class="custom-file">
                        <input name="add_cert" type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        @error('add_cert')
                            <p class="py-2 text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            Checking "Yes" below means you agree that any product/goods bought from The Wholesale Lounge and any of its vendors within the site are considered as tax-exempt purchases of property that you intend to resell or that you will incorporate into a product for sale.
        </div>
       <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input name="yes" value="1" type="checkbox" required class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Yes</label>
            </div>
       </div>

        <div class="form-group mt-2">
            <button class="btn btn-home w-100">Register</button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


    </form>
@endsection
