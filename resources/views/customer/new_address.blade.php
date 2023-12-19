@extends('layout.customer_new_layout')

@section('title', 'Address Book')

@section('pagetitle', 'Add New Shipping Address')

@section('content')
<hr>

<style>
    label{
        text-transform: capitalize;
        font-size: 17px;
        font-weight: 600;
        color: #012970;
    }
</style>

<div>
    <div class="p-2">
        <form method="POST" action="{{ route('customer_save_address') }}">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control @error('fname') is-invalid @enderror" value="@error('fname') {{ $message }}@enderror" id="fname" name="fname" >
                </div>
                <div class="form-group col-md-6">
                    <label for="fname">Last Name</label>
                    <input type="text" class="form-control @error('lname') is-invalid @enderror" value="@error('lname') {{ $message }}@enderror" id="lname" name="lname">
                </div>
            </div>

            <div class="row mt-3">
                <div class="form-group col-md-6">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" value="@error('phone') {{ $message }}@enderror" id="phone" name="phone">
                </div>
                <div class="form-group col-md-6">
                    <label for="add_phone">Additional Phone number (optional)</label>
                    <input type="tel" class="form-control @error('add_phone') is-invalid @enderror" value="@error('add_phone') {{ $message }}@enderror" id="add_phone" name="add_phone">
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="inputAddress">Delivery Address</label>
                <input id="address" type="text" class="form-control @error('delivery_address') is-invalid @enderror" value="@error('delivery_address') {{ $message }}@enderror" name="delivery_address" placeholder="1234 Main St" oninput="getAddress(event)">
                <div class="address_card">
                    <div class="address_listing list-group">

                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="inputAddress">Additional Information</label>
                <textarea name="add_info" class="form-control" cols="10" rows="10"></textarea>
            </div>
            {{-- <div class="row mt-3">
                <div class="form-group col-md-6">
                    <label for="inputCity">Country</label>
                    <select id="inputState" class="form-control crs-country" name="country" data-region-id="ABC">
                        <option selected>Choose...</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState">Region</label>
                    <select id="ABC" class="form-control" name="region">
                        <option selected>Choose...</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="number" class="form-control" id="inputZip" name="zip">
                </div>
            </div> --}}

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

