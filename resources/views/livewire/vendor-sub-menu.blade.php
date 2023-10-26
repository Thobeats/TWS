<div>
    {{-- Stop trying to control. --}}
    <div class="container-fluid h-100">
        <div class="row h-100 mt-3">
            <div class="col-lg-6 border border-left-0 border-top-0">
                <h4 class="sub-menu-title text-left">
                    Top Selling Vendors
                </h4>

                <div class="mt-3 product-wrapper d-flex justify-content-left">
                    @forelse ($vendors as $vendor)
                        <div class="block2">
                            <div class="block3-pic hov-img0">
                                <img src="{{ $vendor->profile != null ? url('storage/'. $vendor->profile)  : asset('images/blank.jpg') }}" alt="TWSL-VENDDOR">
    
                                <a href="/market/vendor/{{$vendor->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                    Quick View
                                </a>
                            </div>
    
                            <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                                <div class="block2-txt-child1 flex-col-l">
                                    <a href="/market/vendor/{{$vendor->id}}">
                                        <h6 class="my-2">{{ $vendor->business_name }}</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card my-3" style="height: auto; width: 200px;">
                            <div class="img-wrapper" style="height: 90%;">
                                <img src="{{  asset('assets/img/who.png') }}" class="card-img-top h-100" alt="...">
                            </div>
                        </div>

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
                                <img src="{{ $votw->profile != null ? url('storage/'. $votw->profile)  : asset('images/blank.jpg') }}" alt="TWSL-VENDDOR">
    
                                <a href="/market/vendor/{{$votw->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                    Quick View
                                </a>
                            </div>
    
                            <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                                <div class="block2-txt-child1 flex-col-l">
                                    <a href="/market/vendor/{{$votw->id}}">
                                        <h6 class="my-2">{{ $votw->business_name }}</h6>
                                    </a>
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
                        <a class="btn btn-home text-light align-item-right" href="{{ url('/seller_signup')}}">
                            Become a vendor
                            <span class="ml-2"><i class="zmdi zmdi-chevron-right"></i></span>
                        </a>
                    @endguest
                </div>

            </div>

        </div>
    </div>
</div>
