@auth
<div class="wrap-header-cart js-panel-wishlist">
    <div class="s-full js-hide-wishlist"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Your Saved Items
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-wishlist">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
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

        </div>
    </div>
</div>

@endauth

