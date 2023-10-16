@extends('layout.market_layout')

@section('title', 'Shipping Details')


@section('content')

<section class="container pt-5 my-4" style="min-height: 100vh">
    <h4 class="ltext-109 cl2 p-b-30">
        Shipping and Payment
    </h4>

    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                  <a class="nav-link {{ $data['stage'] == 1 ? 'home-active' : 'shipping-tab'}} mtext-106" href="#">Shipping Address</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ $data['stage'] == 2 ? 'home-active' : 'shipping-tab'}} mtext-106" href="#"> Review Payment</a>
                </li>
            </ul>

            <div class="nav-content p-3 mt-3">

                @if($data['stage'] == 1)
                {{-- Create the Shipping Form --}}
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <a href="?step=use_default"  class="text-dark">
                            <i class="zmdi zmdi-circle-o" style="font-size: 15px"></i>
                            Use Default Address
                        </a>
                        <hr>
                    </div>

                    <div class="col-lg-6 col-sm-12">

                    </div>

                    <div class="col-lg-6 col-sm-12 py-3">
                        <h3 class="mtext-104 mt-2 home-text">New Address</h3>
                        <form method="POST" action="/checkout" class="mt-3">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control @error('fname') is-invalid text-danger @enderror" value="@error('fname') {{ $message }}@enderror" id="fname" name="fname" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fname">Last Name</label>
                                    <input type="text" class="form-control @error('lname') is-invalid text-danger @enderror" value="@error('lname') {{ $message }}@enderror" id="lname" name="lname">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid text-danger @enderror" value="@error('phone') {{ $message }}@enderror" id="phone" name="phone">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="add_phone">Additional Phone number (optional)</label>
                                    <input type="tel" class="form-control @error('add_phone') is-invalid text-danger @enderror" id="add_phone" name="add_phone" value="@error('add_phone') {{ $message }}@enderror">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Delivery Address</label>
                                <input type="text" class="form-control @error('delivery_address') is-invalid text-danger @enderror" value="@error('delivery_address') {{ $message }}@enderror" name="delivery_address" placeholder="1234 Main St">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Additional Information</label>
                                <input type="text" class="form-control" name='add_info' placeholder="1234 Main St">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">Country</label>
                                    <select id="inputState" class="form-control crs-country" name="country" data-region-id="ABC">
                                        <option selected>Choose...</option>
                                    </select>
                                    @error('country')
                                        <p class='py-2 text-danger'>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Region</label>
                                    <select id="ABC" class="form-control" name="region">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                    @error('region')
                                        <p class='py-2 text-danger'>{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Zip</label>
                                    <input type="text" class="form-control @error('zip') is-invalid text-danger @enderror"  id="inputZip" name="zip">
                                    @error('zip')
                                        <p class='py-2 text-danger'>{{$message}}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" name='save' class="btn home-btn-outline">Save</button>
                        </form>
                    </div>
                </div>
                @endif

                @if($data['stage'] == 2)
                {{-- Create the Payment Review --}}
                <div class="row">
                    <div class="col-lg-6 col-sm-12"></div>
                    <div class="col-lg-6 col-sm-12">
                        <h4 class="stext-301">Payment Summary</h4>
                    </div>
                    <div class="col-lg-6 col-sm-12"></div>
                    <div class="col-lg-6 col-sm-12">

                        <div class="card card-body mt-4">
                            <div class="card-title">Delivery Address</div>
                            <address>
                                {{ $data['address']['fname'] . " " . $data['address']['lname'] }}<br>
                                {{ $data['address']['delivery_address'] }}<br>
                                {{ $data['address']['region'] . ", " . $data['address']['country'] }}<br>
                                {{ $data['address']['zip'] }}<br>
                                {{ $data['address']['phone'] }} {{ $data['address']['add_phone'] != null ? ', '. $data['address']['add_phone'] : '' }}<br>
                                {{ $data['address']['add_info'] != null ? $data['address']['add_info'] : ''}}
                            </address>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12"></div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="card-body mt-4">
                           <form action="/purchase" method="post">
                                @csrf
                                @php
                                    $items = session('cartItems');

                                    $shipping_total = $items['shipping_total'];
                                @endphp
                                <table class="table">
                                    <tr>
                                        <th>
                                            Total Amount
                                        </th>
                                        <td class="text-right">
                                            ${{ number_format($items['total'],2)}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Shipping Amount
                                        </th>
                                        <td class="text-right">
                                            ${{number_format($shipping_total)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Grand Total
                                        </th>
                                        <td class="text-right">
                                            ${{ number_format(($items['total'] + $shipping_total),2) }}
                                        </td>
                                    </tr>

                                </table>
                                <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                    Purchase
                                </button>
                           </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>



</section>



@endsection
