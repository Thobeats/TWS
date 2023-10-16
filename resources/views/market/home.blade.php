@extends('layout.market_layout')

@section('title', 'Home')


@section('content')

<!-- Slider -->
<section class="section-slide container">
    <div class="wrap-slick1 rs1-slick1">
        <div class="slick1">
            @forelse ($topVendors as $tv)
            <div class="item-slick1" data-caption="{{$tv['business_name']}}" data-thumb="{{ url('storage/' . $tv['business_banner'])}}">
                <div class="container h-full">
                    {{-- Business Banner --}}
                    <a href="/market/vendor/{{$tv['vendor_id']}}">
                        <div class="h-50" style="background-image: url({{ 'storage/' . $tv['business_banner']}}); background-position: top center;">
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
    <div class="p-b-32">
        <h6 class="ltext-107 cl5 txt-left respon1">
            Top Categories
        </h6>
    </div>

    <div class="flex-w flex-c-m">

        @forelse ($banners as $banner)
        <div class="size-202 m-lr-auto respon4">
            <!-- Block1 -->
            <div class="block1 wrap-pic-w">
                <img src="{{'storage/slides/'.$banner->image}}" alt="IMG-BANNER">

                <a href="{{ route('shop',[$banner->slug]) }}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            {{$banner->title}}
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            {{$banner->subtitle}}
                        </span>
                    </div>

                    <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <div class="size-202 m-lr-auto respon4">
            <!-- Block1 -->
            <div class="block1 wrap-pic-w">
                <img src="images/banner-04.jpg" alt="IMG-BANNER">

                <a class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            Women
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            Coming Soon
                        </span>
                    </div>

                    {{-- <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div> --}}
                </a>
            </div>
        </div>
        @endforelse

        {{-- <div class="size-202 m-lr-auto respon4">
            <!-- Block1 -->
            <div class="block1 wrap-pic-w">
                <img src="images/banner-04.jpg" alt="IMG-BANNER">

                <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            Women
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            Spring 2018
                        </span>
                    </div>

                    <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="size-202 m-lr-auto respon4">
            <!-- Block1 -->
            <div class="block1 wrap-pic-w">
                <img src="images/banner-05.jpg" alt="IMG-BANNER">

                <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            Men
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            Spring 2018
                        </span>
                    </div>

                    <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="size-202 m-lr-auto respon4">
            <!-- Block1 -->
            <div class="block1 wrap-pic-w">
                <img src="images/banner-06.jpg" alt="IMG-BANNER">

                <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            Bags
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            New Trend
                        </span>
                    </div>

                    <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div>
                </a>
            </div>
        </div> --}}
    </div>
</div>

@if (count($adminSections) > 0)
@foreach ($adminSections as $section)

@if($section->adminSectionProducts()->count() > 0)
<section class="sec-product bg0 p-t-100 p-b-50">
    <div class="container">
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
                                <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>

                                <span class="mtext-101 cl2">
                                    ${{ $product->price }}
                                </span>
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
    </div>
</section>
@endif

@endforeach
@endif


@if (count($sections) > 0)
@foreach ( $sections as $section)

@if($section->products()->count() > 0)
<section class="sec-product bg0 p-b-50">
    <div class="container">
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
                                <a href="/market/product/{{$product->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>

                                <span class="mtext-101 cl2">
                                    ${{ $product->price }}
                                </span>
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
    </div>
</section>
@endif

@endforeach
@endif

@endsection
