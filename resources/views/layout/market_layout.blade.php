<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title')</title>
	<meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="Wholesale clothes, trade show, wholesale fashion, wholesale apparel, sell wholesale apparel, buy clothes wholesale, boutique, clothing distributors, FashionGo, Fashiongo week, fashion week, online trade show, wholesale new collection, promotion, wholesale, Wholesale USA, United States, America, United States Wholesale">
    <meta name="description" content="One-stop Wholesale Platform for Clothing, Shoes, Accessories, Home decor, and more, Jewelries, Wholesale Clothing">

	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/linearicons-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/slick/slick.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/MagnificPopup/magnific-popup.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL('css/sub-menu.css') }}"> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<!--===============================================================================================-->
@livewireStyles

</head>
<body class="animsition">

<!-- Header -->
@include('layout.market_header')

<!-- Sidebar -->
@include('layout.market_sidebar')


<!-- Cart -->
@include('layout.market_cart')

<!-- WishList -->
@include('layout.market_wishlist')

<section class='container-fluid'>
    @yield('content')
</section>




<!-- Footer -->
@include('layout.market_footer')
@livewireScripts

<script>
	function getSubcategories(id,step){
		Livewire.emit('get_subcategories',id,step);
	}

    function getProducts(id){
        Livewire.emit('get_products',id);
    }
</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('js/slick-custom.js') }}"></script>
    <script src="{{ asset('js/crs.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/parallax100/parallax100.js') }}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            var productId = $(this).attr('data-product');
			$(this).on('click', function(){
                var children = $(this).children();
                $.get(`/addWishList/${productId}`,function(res){
                    if(res.code == 1){
                        swal(nameProduct, "product no longer in stock!", "error");
                    }else if(res.code == 0){
                        if (children.hasClass('zmdi-favorite-outline')){
                            children.removeClass('zmdi-favorite-outline').addClass('zmdi-favorite');
                        }else if (children.hasClass('zmdi-favorite')){
                            children.removeClass('zmdi-favorite').addClass('zmdi-favorite-outline');
                        }
                        loadWishList();
                        swal(nameProduct, res.body, "success");
                    }else{
                        swal(nameProduct, res.body, "error");
                    }

                    if (res.count == 0){
                        $("#wishList").removeClass("icon-header-noti");
                        $("#wishList").removeAttr('data-notify');
                    }else{
                        //Add Count to the Wishlist Badge
                        $("#wishList").addClass("icon-header-noti");
                        $("#wishList").attr('data-notify',res.count);
                    }

                });

			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

	</script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    @auth
        <script>
            const socket = new WebSocket("ws://localhost:8080?userID={{ Auth::id()}}");

            socket.onopen = function(e) {
                console.log("[open] Connection established");
            };

            socket.onmessage = (event) => {
                document.getElementById('inbox').innerHTML += '<span class="badge badge-danger">new</span>';

                if (typeof incomingMessage != "undefined" && typeof incomingMessage == "function"){
                    let data = JSON.parse(event.data)
                    incomingMessage(data);
                }
            };

            loadWishList();
            function loadWishList()
            {
                let wishlists = `
                @if ($wcount > 0)
                    <ul class="header-cart-wrapitem w-full">
                        @forelse ($wishlists as $key => $item)
                            @php
                                $product = \App\Models\Product::find($item['product_id']);
                            @endphp
                            <li class="header-cart-item flex-w flex-t m-b-12">
                                <div class="header-cart-item-img">
                                    <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG">
                                </div>

                                <div class="header-cart-item-txt p-t-8">
                                    <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                        {{$product->name}}
                                    </a>
                                </div>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                @endif
                `;

                document.getElementById('wishlist-bucket').innerHTML = wishlists;
            }

        </script>
    @endauth
    <script src="{{asset('assets/js/apicalls.js')}}"></script>
</body>
</html>
