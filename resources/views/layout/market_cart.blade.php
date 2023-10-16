@auth
@php
    $cart = \App\Models\Cart::where('user_id', auth()->user()->id)->first();

    if($cart){
        $count = count(json_decode($cart->items,true));
        $sum = array_reduce(array_column(array_values(json_decode($cart->items,true)),'price'), function($v1, $v2){
            return $v1+$v2;
        });
    }else{
        $count = 0;
    }

@endphp
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Your Cart
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            @if ($count > 0)
            <ul class="header-cart-wrapitem w-full">
                @foreach (json_decode($cart->items,true) as $key => $item)
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

                            <span class="header-cart-item-info">
                                {{ $item['num_of_product'] }} x ${{$product->price}}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Total: ${{number_format($sum,2)}}
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    <a href="/cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        View Cart
                    </a>

                    <a href="/cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                        Check Out
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endauth

