<div>
    <div class="row isotope-grid">
        @forelse ($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
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
        @empty

        @endforelse
    </div>

    <!-- Load more -->
    <div class="flex-c-m flex-w w-full p-t-45">
        @if ($productCount > $products->count())
            <a href="#" wire:click='products({{$limit}})' class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                Load More
            </a>
        @endif
    </div>
</div>
