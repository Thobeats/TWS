
<header class="header-v2">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03" style="border:1px solid #0000">
        <div class="wrap-menu-desktop d-flex">
            <!-- Logo desktop -->
            <div class="w-12">
                <a href="{{ route('home') }}" class="logo">
                    <img src="/images/logo.png" alt="IMG-LOGO">
                </a>
            </div>
            <div class='d-flex flex-column pt-3 flex-even'>
                <nav class="navbar justify-content-center p-l-45 top-nav">
                    <form class="form-inline" style="width: 500px">
                      <input class="form-control mr-sm-2" style="width:450px"  type="search" placeholder="Search" aria-label="Search">
                      <button class="btn home-btn-outline my-2 my-sm-0" type="submit"><i class="zmdi zmdi-search"></i></button>
                    </form>
                    @php
                        $vendors = \App\Models\User::where('role',2)->get();
                    @endphp

                    @guest
                    <div class="wrap-icon-header flex-w flex-r-m h-full">
                        <div class="flex-c-m h-full p-r-24">
                            <a class="cl2 hov-cl1 trans-04 p-lr-11 auth-buttons home-text" href="{{ route('login') }}">
                                Log In <i class="zmdi zmdi-sign-in"></i>
                            </a>
                        </div>

                        <div class="flex-c-m h-full p-r-24">
                            <a class="cl2 hov-cl1 trans-04 p-lr-11 auth-buttons home-bg-color text-light" href="/register">
                                Register <i class="zmdi zmdi-account-add"></i>
                            </a>
                        </div>
                    </div>
                    @endguest
                    @auth
                    <div class="wrap-icon-header flex-w flex-r-m h-full">
                        <div class="flex-c-m h-full p-l-18 p-r-25">

                            <div class="dropdown">
                                <a class="profile-nav dropdown-toggle border-none p-2" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                  <i class="zmdi zmdi-account"></i> Hi, {{ Auth::user()->firstname }}
                                </a>

                                {{-- Drop Down For Customers --}}
                                @if (Auth::user()->role == 1)
                                    <div class="dropdown-menu p-2">
                                        <a class="dropdown-item p-2" href="{{ route('customer_profile')}}"><i class="zmdi zmdi-account"></i> My Account</a>
                                        <a class="dropdown-item p-2" href="/customer/orders"><i class="zmdi zmdi-card-giftcard"></i> Orders</a>
                                        <a id="inbox" class="dropdown-item p-2" href="/customer/chat"><i class="zmdi zmdi-inbox"></i> Inbox </a>
                                        <a class="dropdown-item p-2" href="/customer/wishlists"><i class="zmdi zmdi-favorite-outline"></i> Saved Items</a>
                                    </div>
                                @endif

                                {{-- DropDown For Vendors --}}
                                @if (Auth::user()->role == 2)
                                    <div class="dropdown-menu p-2">
                                        <a class="dropdown-item p-2" href="/vendor/profile"><i class="zmdi zmdi-account"></i> My Profile</a>
                                        <a class="dropdown-item p-2" href="/vendor/store"><i class="zmdi zmdi-store"></i> My Store</a>
                                        <a class="dropdown-item p-2" href="/vendor/chat"><i class="zmdi zmdi-inbox"></i> Inbox</a>
                                    </div>
                                @endif

                                 {{-- DropDown For Admin --}}
                                 @if (Auth::user()->role == 3)
                                 <div class="dropdown-menu p-2">
                                     <a class="dropdown-item p-2" href="/admin"><i class="zmdi zmdi-account"></i> Dashboard </a>
                                 </div>
                             @endif


                                </div>
                            <!-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-cart">

                            </div> -->
                        </div>

                        <div class="flex-c-m h-full p-l-18 p-r-25">
                            {{-- <div id="cartCount" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 {{ $count > 0 ? "icon-header-noti" : '' }} js-show-msg" {{ $count > 0 ? "data-notify='$count'" : '' }}>
                                <i class="zmdi zmdi-comment-outline"></i>
                            </div> --}}

                            <div id="cartCount" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 {{ $count > 0 ? "icon-header-noti" : '' }}  js-show-cart" {{ $count > 0 ? "data-notify='$count'" : '' }}>
                                <i class="zmdi zmdi-shopping-cart"></i>
                            </div>

                            <div id="wishList" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 {{ $wcount > 0 ? "icon-header-noti" : '' }}  js-show-wishlist" {{ $wcount > 0 ? "data-notify='$wcount'" : '' }}>
                                <i class="zmdi zmdi-favorite-outline"></i>
                            </div>
                        </div>

                        {{-- <div class="flex-c-m h-full p-lr-19">
                            <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                                <i class="zmdi zmdi-menu"></i>
                            </div>
                        </div> --}}
                    </div>
                    @endauth



                </nav>
                <nav class="limiter-menu-desktop p-l-45 w-100">
                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li class="active-menu">
                                <a href="#">Categories</a>
                                <div class="sub-menu">
                                    @livewire('category-sub-menu')
                                </div>
                            </li>
                            <li>
                                <a href="#">Vendors</a>
                                <div class="sub-menu">
                                    @livewire('vendor-sub-menu')
                                </div>
                            </li>
                            {{-- <li>
                                <a href="#">Spotlight</a>
                            </li> --}}

                            <li>
                                <a href="#">Just in </a>
                                <div class="sub-menu">
                                    @livewire('just-in')
                                </div>
                            </li>

                            {{-- <li>
                                <a href="#">Pre Orders</a>
                            </li>
                            <li>
                                <a href="#">On Sale</a>
                            </li> --}}


                        </ul>
                    </div>
                    <div class="flex-c-m h-full p-lr-19 ml-auto">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                            <i class="zmdi zmdi-menu"></i>
                        </div>
                    </div>
                </nav>
            </div>
             <!-- Icon header -->

        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="{{ route('home') }}" class="logo">
                <img src="/images/logo.png" alt="IMG-LOGO">
            </a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
            <div class="flex-c-m h-full p-r-24">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-log-in">
                    <i class="zmdi zmdi-sign-in"></i>
                </div>
            </div>

            <div class="flex-c-m h-full p-r-10 bor20">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>
            </div>

            <div class="flex-c-m h-full p-lr-10 bor5">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
            </div>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>
                <ul class="sub-menu-m">
                    <li><a href="index.html">Homepage 1</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="product.html">Shop</a>
            </li>

            <li>
                <a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
            </li>

            <li>
                <a href="blog.html">Blog</a>
            </li>

            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal-log-in-header flex-c-m trans-04 js-hide-modal-search ">
        <div class="container-search-header">
            <div class="h3">Login</div>
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-log-in">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form action="{{ route('login') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <input type="text" name='email' class="form-control" placeholder="email">
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="" class="form-control" placeholder="password">
                </div>

                <button class='btn btn-home form-control'>Log In</button>
            </form>
            <div class="mt-3">
                Don't have an account?
                <button class='btn home-btn-outline js-show-modal-sign-up'>
                    <i class="zmdi zmdi-account-add"></i>
                    Sign Up
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Sign Up -->
    <div class="modal-sign-up-header trans-04 js-hide-modal-search">
        <button class="btn-hide-modal-sign-up js-hide-modal-sign-up">
            <img src="images/icons/icon-close2.png" alt="CLOSE">
        </button>

        <div class="container text-dark">
            {{-- <section class="my-3 p-3">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="display-4 p-2">
                            New Here?
                        </p>
                        <p class="p-2" style="font-size: 18px;">
                            You can register as a buyer or a seller on our platform....content needed here
                        </p>
                    </div>
                </div>
            </section> --}}

            <section class="my-3 p-3">
                <div class="register-cards mx-auto text-light">
                    <div class="card flex-even mt-4">
                        <div class="card-body card-buyer">
                            <div class="card_title">
                                <span class="text-light">Register as a Buyer</span>
                            </div>

                            <div class="card_action">
                                <a href="{{ route('buyerSignup') }}" class="card_action_text text-light">Register now</a>
                            </div>
                        </div>
                    </div>

                    <div class="card flex-even mt-4 ">
                        <div class="card-body card-seller">
                            <div class="card_title">
                                <span class="text-light">Register as a Seller</span>
                            </div>

                            <div class="card_action">
                                <a href="{{ route('sellerSignup') }}" class="card_action_text text-light">Register now</a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-dark">
                                Register as a buyer
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-dark">
                                Register as a seller
                            </div>
                        </div>
                    </div> --}}
                </div>
            </section>
        </div>
    </div>
</header>
