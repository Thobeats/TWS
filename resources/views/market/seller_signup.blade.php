@extends('layout.market_auth')

@section('title', 'Seller - Sign Up')

@section('form')
@if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endforeach
@endif
    <form action="{{ route('sellerSignup') }}" method="POST" class='w-50 p-4 bg-white border rounded' enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
        {{-- <div class="form-group">
            <label for="ein">EIN <span class='text-danger'>*</span> </label>
            <input type="text" name="ein" value="{{ old('ein') }} @error('ein') {{ $message }} @enderror" required class="form-control @error('ein') is-invalid text-danger @enderror">
        </div> --}}
        <div class="form-group">
            <label for="address">Address <span class='text-danger'>*</span> </label>
            <input name="address" id="address" value="{{ old('address') }} @error('address') {{ $message }} @enderror" required class="form-control @error('address') is-invalid text-danger @enderror" oninput="getAddress(event)">
            <div class="address_card">
                <ul class="address_listing">
            
                </ul>
            </div>
        </div>
        {{-- <div class="form-group">
            <label for="zip_code">Zip Code <span class='text-danger'>*</span> </label>
            <input type="number" name="zip_code" value="{{ old('zip_code') }} @error('zip_code') {{ $message }} @enderror" required class="form-control @error('zip_code') is-invalid text-danger @enderror">
        </div>

        
        <div class="form-group">
            <label for="city">City <span class='text-danger'>*</span> </label>
            <input id="city" type="number" name="city" value="{{ old('city') }} @error('city') {{ $message }} @enderror" required class="form-control @error('city') is-invalid text-danger @enderror">
        </div>
        <div class="form-group">
            <label for="state">State <span class='text-danger'>*</span> </label>
            <input id="state" name="state"  value="{{ old('state') }} @error('state') {{ $message }} @enderror" required class="form-control @error('state') is-invalid text-danger @enderror" id="location-input">
        </div> --}}
{{--     
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="country">State <span class='text-danger'>*</span> </label>
                    <select name="state" id="state" class="js-example-basic-multiple form-control" onchange="selectCity(event)">

                    </select>
                    @error('state')
                        <p class='py-2 text-danger'>{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="country">City <span class='text-danger'>*</span> </label>
                    <select name="city" id="city" class="js-example-basic-multiple form-control">

                    </select>
                    @error('city')
                        <p class='py-2 text-danger'>{{$message}}</p>
                    @enderror
                </div>
            </div>
        </div> --}}

        <div class="form-group">
            <label for="products">What kind of products do you offer? <span class='text-danger'>*</span> </label>
            <select class="js-example-basic-multiple" name="products[]" multiple="multiple" style="width: 100%">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            Any electronic signature of a party to this Agreement and of a party to take any action related to this Agreement or any agreement entered into by the Partnership shall be valid as an original signature and shall be effective and binding. Any such electronic signature (including the signature(s) to this Agreement) shall be deemed (i) to be “written” or “in writing,” (ii) to have been signed and (iii) to constitute a record established and maintained in the ordinary course of business and an original written record when printed from electronic files.
        </div>
       <div class="form-group">
            By providing your name below you agree and understand that all electronic signatures are the legal equivalent of your handwritten signature and consent to be legally bound to this agreement.
       </div>
       <div class="form-group">
            <input type="text" name="consent" placeholder="Enter your first and last name" id="" class="form-control @error('consent') is-invalid text-danger @enderror" required>
       </div>

       <div class="form-group">
        This form is to be completed in its entirety before submitting. This form is to prove you are a legal business and can be trusted to be a vendor on The Wholesale Lounge website and can provide quality products to buyers. By submitting this form you agree that the name listed above is the rightful owner of the business. You are agreeing to sell ONLY in the United States and to abide by all other polices set in your storefront. Seller is in charge of making any further policies in their storefront. If you do not follow these rules, The Wholesale Lounge has the rights to deactivate your account.
       </div>

        <div class="form-group mt-2">
            <button class="btn btn-home w-100">Register</button>
        </div>


    </form>

    <script>var selectedStateValue = "" </script>

    <script src="{{asset('assets/js/apicalls.js')}}"></script>
@endsection
