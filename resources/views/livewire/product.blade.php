<div class="col-md-6 col-lg-5 p-b-30">
    <div class="p-r-50 p-t-5 p-lr-0-lg">
        <div class="d-flex justify-content-between">
            <h4 class="mtext-106 cl2 js-name-detail p-b-14" id="product_modal_name">
                {{$productName}}
            </h4>
            <div>
                <a href="#" class="ltext-102 mt-4 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                    <i class="zmdi zmdi-favorite-outline"></i>
                </a>
            </div>
        </div>
        <span class="ltext-108 cl2" id="product_modal_price">
            ${{$price}}
        </span>
        <!-- Cart Form  -->
        <form action="/addCart" method="post" class='mt-4'>
            @csrf
            <input type="hidden" name="product_id" value="{{$productId}}">
            @forelse ($productVariants as $index => $variant)
                <div class="flex-w flex-r-m p-b-10">
                    <div class="size-203 flex-c-m respon6">
                        {{ $variant['variant'] }}
                    </div>
                    <div class="size-204 respon6-next">
                        @foreach ($variant['values'] as $key => $variantValue)
                            @if($variantValue != "")
                                <a href="#" class='badge btn {{ in_array($variantValue, $selectedVariantValues) ? 'btn-home' : 'home-btn-outline' }} p-2' wire:click="chooseVariants({{$index}}, '{{$variantValue}}')">{{$variantValue}}</a>
                            @endif
                        @endforeach
                    </div>

                </div>
            @empty

            @endforelse

            <div class="p-t-33">
                <div class="flex-w flex-r-m p-b-10">
                    <div class="size-204 flex-w flex-m respon6-next">
                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                            <button type="button" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" wire:click="decrement">
                                <i class="fs-16 zmdi zmdi-minus"></i>
                            </button>
                            <input max="{{$limit}}" class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" id="product_modal_description" value="{{$productCount}}">
                            <button type="button" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" wire:click="increment">
                                <i class="fs-16 zmdi zmdi-plus"  id="product_modal_stock"></i>
                            </button>
                        </div>

                        <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                            Add to cart
                        </button>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
