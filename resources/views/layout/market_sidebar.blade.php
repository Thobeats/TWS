<aside class="wrap-sidebar js-sidebar">
    <div class="s-full js-hide-sidebar"></div>

    <div class="sidebar flex-col-l p-t-22 p-b-25">
        <div class="flex-r w-full p-b-30 p-r-27">
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
            <ul class="sidebar-link w-full">
                <li class="p-b-13">
                    <a href="{{url('/')}}" class="stext-102 cl2 hov-cl1 trans-04">
                        Home
                    </a>
                </li>
                <li class="p-b-13">
                    <a href="{{ route('customer_profile')}}" class="stext-102 cl2 hov-cl1 trans-04">
                        My Account
                    </a>
                </li>
{{--
                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        Track Oder
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        Refunds
                    </a>
                </li> --}}

                <li class="p-b-13">
                    <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                        Help & FAQs
                    </a>
                </li>
                @auth
                <li class="p-b-13">
                    <a class='btn home-bg-color text-light js-show-modal-sign-up' {{ route('customer_profile') }}>
                        <i class="zmdi zmdi-account"></i>
                        View Profile
                    </a>

                    <a class='btn btn-light' href="{{ route('logout') }}">
                        <i class="zmdi zmdi-sign-in"></i>
                        Log Out
                    </a>
                </li>
                @endauth

                @guest
                    <li class="p-b-13">
                        <button class='btn home-bg-color js-show-modal-log-in'>
                            <i class="zmdi zmdi-sign-in"></i>
                            Log In
                        </button>

                        <button class='btn btn-light home-text js-show-modal-sign-up'>
                            <i class="zmdi zmdi-account-add"></i>
                            Sign Up
                        </button>
                    </li>
                @endguest


                </li>
            </ul>

            <div class="sidebar-gallery w-full p-tb-30">
                <span class="mtext-101 cl5">
                    @ The Wholesale Lounge
                </span>

                <div class="flex-w flex-sb p-t-36 gallery-lb">


                    @foreach ($galleries as $gallery)

                    <div class="wrap-item-gallery m-b-10">
                        <a class="item-gallery bg-img1" href="{{ url('storage/products/'. json_decode($gallery->pics,true)[0]) }}" data-lightbox="gallery"
                        style="background-image: url('{{ url('storage/products/'. json_decode($gallery->pics,true)[0]) }}');"></a>
                    </div>

                    @endforeach
                </div>
            </div>

            <div class="sidebar-gallery w-full">
                <span class="mtext-101 cl5">
                    About Us
                </span>

                <p class="stext-108 cl6 p-t-27">
                    Welcome to The Wholesale Lounge where we understand the value of small businesses– the dreams, the hard work, and the unique stories behind every venture. Our journey began with a pledge to empower small businesses, a commitment that threads through every aspect of our marketplace. We're more than a platform – we're a catalyst for collaboration and growth. Become a part of our community and connect with our network of reputable and verified business owners, forming valuable relationships across a diverse spectrum of suppliers and buyers. Here at The Wholesale Lounge, we believe in more than just transactions; we believe in relationships.                </p>
            </div>
        </div>
    </div>
</aside>
