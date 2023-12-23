<header class="header-v2" style="height: 100px;">
  <div class="twls-header">
      <div class="container-fluid border">
          <div class="row">
              <div class="col-2">
                <a href="{{ route('home') }}" class="logo">
                    <img src="/images/logo.png" alt="IMG-LOGO" width="100px">
                </a>
              </div>
              <div class="col-10">
                <nav class="navbar justify-content-center p-l-45 top-nav h-100 w-100">
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
                                        <a class="dropdown-item p-2" href="#"><i class="zmdi zmdi-favorite-outline"></i> Saved Items</a>
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
              </div>
          </div>
      </div>

  </div>
</header>
