@extends('layout.market_layout')

@section('title', 'Home')


@section('content')

<!-- Slider -->
<section class="section-slide bg-light m-0">
    <div class="wrap-slick1 rs1-slick1">
        <div class="slick1">
            @forelse ($topVendors as $tv)
            <div class="item-slick1" data-caption="{{$tv['business_name']}}" data-thumb="{{ $tv['business_banner'] != "" ? url('storage/' . $tv['business_banner']) : url('images/Welcome.png')}}">
                <div class="container h-full">
                    {{-- Business Banner --}}
                    <a href="/market/vendor/{{$tv['vendor_id']}}">
                        <div class="h-50" style="background-image: url('{{ $tv['business_banner'] != "" ? url('storage/' . $tv['business_banner']) : url('images/Welcome.png')}}'); background-size:cover; background-position: left center;">
                        </div>
                    </a>
                    <div class="wrap-slick2">
                        <div class="slick2">
                            @foreach ($tv['products'] as $product)
                                <a href="/market/product/{{$product['id']}}">
                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block3-pic hov-img3">
                                                <img src="{{ json_decode($product['pics'],true) != [] ? url('storage/products/'. json_decode($product['pics'],true)[0]) : '' }}" alt="IMG-PRODUCT">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="item-slick1" style="background-image: url(images/slide-03.jpg);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30">
                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                            <span class="ltext-202 cl2 respon2">
                                Men Collection 2018
                            </span>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                            <h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
                                New arrivals
                            </h2>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                            <a href="{{ route('shop') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @endforelse

            {{-- <div class="item-slick1" style="background-image: url(images/slide-02.jpg);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30">
                        <div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
                            <span class="ltext-202 cl2 respon2">
                                Men New-Season
                            </span>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
                            <h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
                                Jackets & Coats
                            </h2>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
                            <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item-slick1" style="background-image: url(images/slide-04.jpg);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30">
                        <div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
                            <span class="ltext-202 cl2 respon2">
                                Women Collection 2018
                            </span>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
                            <h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
                                NEW SEASON
                            </h2>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
                            <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="wrap-slick1-dots"></div>
    </div>
</section>

<!-- Banner -->
<div class="sec-banner bg0 p-b-40 mt-5">
   <div class="container-">
        <div class="p-b-32">
            <h6 class="ltext-107 cl5 txt-left respon1">
                Trending Categories
            </h6>
        </div>

        <div class="wrap-slick">
        <ul class="trending_categories">
                @forelse ($categories as $category)
                    <li>
                        <a href="/shop?query={{$category->id}}" class="trending_badge">
                            {{ $category->name }}
                        </a>
                    </li>
                @empty
                    <li>
                        <a href="" class="trending_badge">
                            Women
                        </a>
                    </li>
                @endforelse
            </ul>
        </div>
   </div>
</div>

@if (count($adminSections) > 0)
@foreach ($adminSections as $section)

@if($section->adminSectionProducts()->count() > 0)
<section class="sec-product bg0 p-b-50">
    <div class="container-fluid">
        <div class="p-b-32">
            <h6 class="ltext-107 cl5 txt-left respon1">
                {{$section['name']}}
            </h6>
        </div>

        <div class="wrap-slick2">
            <div class="slick2">
            @foreach ($section->adminSectionProducts() as $product)
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG-PRODUCT">

                            <a href="/market/product/{{$product->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" data-product="{{$product->id}}">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="/market/vendor/{{$product->vendor_id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->vendorName() }}
                                </a>

                                <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>
                            </div>

                            @auth
                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 mtext-101" data-product="{{$product->id}}">
                                    <i class="zmdi {{ $product->inWishList() ? "zmdi-favorite" : "zmdi-favorite-outline" }} icon-heart1 dis-block trans-04"></i>
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="my-2 p-2 text-right">
            <a class="home-view-more" href="/shop">View More</a>
        </div>
    </div>
</section>
@endif

@endforeach
@endif


@if (count($sections) > 0)
@foreach ( $sections as $section)

@if($section->products()->count() > 0)
<section class="sec-product bg0 p-b-50">
    <div class="container-fluid">
        <div class="p-b-32">
            <h6 class="ltext-107 cl5 txt-left respon1">
                {{$section['name']}}
            </h6>
        </div>

        <div class="wrap-slick2">
            <div class="slick2">
                @foreach ($section->products() as $product)
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG-PRODUCT">

                            <a href="/market/product/{{$product->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product="{{$product->id}}">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="/market/vendor/{{$product->vendor_id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->vendorName() }}
                                </a>

                                <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>
                            </div>

                            @auth
                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 mtext-101" data-product="{{$product->id}}">
                                    <i class="zmdi {{ $product->inWishList() ? "zmdi-favorite" : "zmdi-favorite-outline" }} icon-heart1 dis-block trans-04"></i>
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <div class="my-2 p-2 text-right">
            <a class="home-view-more" href="/shop">View More</a>
        </div>
    </div>
</section>
@endif

@endforeach
@endif

{{-- Spotlight --}}
{{-- <section class="section-slide container-fluid mb-4 bg-light">
    <div class="p-b-32">
        <h6 class="ltext-107 cl5 txt-left respon1">
            Spotlight
        </h6>
    </div>
    <div class="wrap-slick1 rs1-slick1">
        <div class="slick1">
            @forelse ($topVendors as $tv)
            <div class="item-slick1" data-caption="{{$tv['business_name']}}" data-thumb="{{ file_exists(url('storage/' . $tv['business_banner'])) ? url('storage/' . $tv['business_banner']) : url('images/Welcome.png')}}">
                <div class="container h-full">
                    {{-- Business Banner
                    <a href="/market/vendor/{{$tv['vendor_id']}}">
                        <div class="h-50" style="background-image: url({{ file_exists(url('storage/' . $tv['business_banner'])) ? url('storage/' . $tv['business_banner']) : url('images/Welcome.png')}}); background-size:cover; background-position: left center;">
                        </div>
                    </a>
                    <div class="wrap-slick2">
                        <div class="slick2">
                        @foreach ($tv['products'] as $product)
                           <a href="/market/product/{{$product['id']}}">
                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block3-pic hov-img3">
                                            <img src="{{ url('storage/products/'. json_decode($product['pics'],true)[0]) }}" alt="IMG-PRODUCT">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="item-slick1" style="background-image: url(images/slide-03.jpg);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30">
                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                            <span class="ltext-202 cl2 respon2">
                                Men Collection 2018
                            </span>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                            <h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
                                New arrivals
                            </h2>
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                            <a href="{{ route('shop') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @endforelse
        </div>
        <div class="wrap-slick1-dots"></div>
    </div>
</section> --}}


<section class="sec-product bg0 p-b-50">
    <div class="container-fluid">
        <div class="p-b-32">
            <h6 class="ltext-107 cl5 txt-left respon1">
                First-Time Buyer Deals
            </h6>
        </div>

        <div class="wrap-slick2">
            <div class="slick2">

                @foreach ($firstTimeBuyers as $product)
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG-PRODUCT">

                            <a href="/market/product/{{$product->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product="{{$product->id}}">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="/market/vendor/{{$product->vendor_id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->vendorName() }}
                                </a>

                                <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>
                            </div>

                            @auth
                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 mtext-101" data-product="{{$product->id}}">
                                    <i class="zmdi {{ $product->inWishList() ? "zmdi-favorite" : "zmdi-favorite-outline" }} icon-heart1 dis-block trans-04"></i>
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <div class="my-2 p-2 text-right">
            <a class="home-view-more" href="/shop">View More</a>
        </div>
    </div>
</section>

<section class="sec-product bg0 p-b-50">
    <div class="container-fluid">
        <div class="p-b-32">
            <h6 class="ltext-107 cl5 txt-left respon1">
                Top Selling Products
            </h6>
        </div>

        <div class="wrap-slick2">
            <div class="slick2">

                @forelse ($freeShipping as $product)
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG-PRODUCT">

                            <a href="/market/product/{{$product->id}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product="{{$product->id}}">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="/market/vendor/{{$product->vendor_id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->vendorName() }}
                                </a>

                                <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>
                            </div>

                            @auth
                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 mtext-101" data-product="{{$product->id}}">
                                    <i class="zmdi {{ $product->inWishList() ? "zmdi-favorite" : "zmdi-favorite-outline" }} icon-heart1 dis-block trans-04"></i>
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                @endforelse

            </div>
        </div>
        <div class="my-2 p-2 text-right">
            <a class="home-view-more" href="/shop">View More</a>
        </div>
    </div>
</section>

<section class="sec-product bg0 p-b-50">
    <div class="container-fluid">
        <div class="p-b-32">
            <h6 class="ltext-107 cl5 txt-left respon1">
                New Vendors
            </h6>
        </div>

        <div class="wrap-slick2">
            <div class="slick2">

                @forelse ($newVendors as $vendor)
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ $vendor->profileImg() }}" alt="TWSL-VENDOR">
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14 border p-3">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="/market/vendor/{{$vendor->id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $vendor->business_name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse

            </div>
        </div>

        <div class="my-2 p-2 text-right">
            <a class="home-view-more" href="/market/vendors">View All Vendors</a>
        </div>
    </div>
</section>

@endsection
