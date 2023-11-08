<div>
    {{-- Stop trying to control. --}}
    <div class="container-fluid h-100">
        <div class="row h-100 mt-3">
            <div class="col-lg-6 border border-left-0 border-top-0">
                <h4 class="sub-menu-title text-left">
                    Top Selling Vendors
                </h4>

                <div class="mt-3 product-wrapper d-flex justify-content-around">
                    @forelse ($vendors as $vendor)
                        <div class="block2" style="width: 260px;">
                            <div class="block2-pic hov-img0">
                                <img src="{{ $vendor->profile != null ? url('storage/'. $vendor->profile)  : asset('images/blank.jpg') }}" alt="TWSL-VENDOR">
                            </div>
                            <div class="p-2">
                                <div class="d-flex justify-content-between">
                                   <div>
                                        <a href="/market/vendor/{{$vendor->id}}">
                                            <h6 class="my-2">{{ $vendor->business_name }}</h6>
                                        </a>
                                   </div>

                                   <div>
                                     <a href="/market/vendor/{{$vendor->id}}" class="btn btn-outline-dark btn-sm">View</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                    @empty
                      
                    @endforelse
                </div>
            </div>

            <div class="col-lg-3">
                <div class="top_selling_vendors">
                    <h4 class="sub-menu-title">
                        New Vendors
                    </h4>
                    <ul class="mt-2 p-2">
                        @foreach ($new_vendors as $new_vendor)
                            <li>
                                <a href="/market/vendor/{{ $new_vendor->id }}">{{ $new_vendor->business_name }}</a>
                            </li>
                        @endforeach
                    </ul>


                </div>
                <hr>
                <div class="view-all text-right">
                    <a class="text-underline" href="/market/vendors">View all</a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="container">
                    <h4 class="sub-menu-title">
                        Vendor of the week
                    </h4>
                    @if ($votw)
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ $votw->profile != null ? url('storage/'. $votw->profile)  : asset('images/blank.jpg') }}" alt="TWSL-VENDOR">
                            </div>
                            <div class="p-2">
                                <div class="d-flex justify-content-between">
                                   <div>
                                        <a href="/market/vendor/{{$votw->id}}">
                                            <h6 class="my-2">{{ $votw->business_name }}</h6>
                                        </a>
                                   </div>

                                   <div>
                                     <a href="/market/vendor/{{$votw->id}}" class="btn btn-outline-dark btn-sm">View</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card my-3" style="height: auto;">
                            <div class="img-wrapper" style="height: 90%;">
                                <img src="{{  asset('assets/img/who.png') }}" class="card-img-top h-100" alt="...">
                            </div>
                        </div>
                    @endif


                    @guest
                        <a class="btn home-btn-outline align-item-right mt-5" href="{{ url('/seller_signup')}}">
                            Become a vendor
                            <span class="ml-2"><i class="zmdi zmdi-chevron-right"></i></span>
                        </a>
                    @endguest
                </div>

            </div>

        </div>
    </div>
</div>
