<div>
    <div class="row">
        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            @forelse ($items as $item)
                <form method="POST" action="/setCartSession" class="bg0 p-t-75 p-b-85">
                    @csrf
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <h3 class="mb-3 border border-bottom p-3">{{ $item['vendor_name'] }}</h3>
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Quantity</th>
                                    <th class="column-4">Total</th>
                                    <th class="column-5">Action</th>
                                </tr>

                                @if(count($item['cartItems']) > 0)
                                    @foreach ($item['cartItems'] as $key => $cartItem)
                                    @php
                                        $product = \App\Models\Product::find($cartItem['product_id']);
                                    @endphp
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                {{-- Attach Vendor ID and Product ID --}}
                                                <input type="hidden" value="{{ (int) $cartItem['id']}}" name="cartId[]">
                                                <img src="{{ url('storage/products/'. json_decode($product->pics,true)[0]) }}" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">{{ $product->name }}</td>
                                        {{-- <td class="column-3">$ {{ number_format($product->price,2) }}</td> --}}
                                        <td class="column-3">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" wire:click="Decrease({{$cartItem['id']}})">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number" name="num_product[]" value="{{ $cartItem['quantity'] }}">

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" wire:click="Increase({{$cartItem['id']}})">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-4" data-price="{{$product->name}}">
                                            $ {{ number_format($cartItem['price'],2) }}
                                        </td>
                                        <td class="column-5">
                                            <a wire:click='remove({{$cartItem['id']}})' class="text-danger ltext-102 mt-4 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Remove from cart">
                                                <i class="zmdi zmdi-delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            {{-- <div class="flex-w flex-m m-r-20 m-tb-5">
                                <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">

                                <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    Apply coupon
                                </div>
                            </div> --}}

                            {{-- <div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Update Cart
                            </div> --}}
                            <button type="submit" class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Checkout Vendor
                            </button>
                        </div>
                    </div>
                </form>
                @empty
            
                @endforelse
        </div>
        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                <h4 class="mtext-109 cl2 p-b-30">
                    Cart Totals
                </h4>

                <div class="flex-w flex-t bor12 p-b-13">
                    <div class="size-208">
                        <span class="stext-110 cl2">
                            Subtotal:
                        </span>
                    </div>

                    <div class="size-209">
                        <span class="mtext-110 cl2">
                            ${{ number_format($sum,2) }}
                        </span>
                    </div>
                </div>

                <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                    <div class="size-208 w-full-ssm">
                        <span class="stext-110 cl2">
                            Shipping:
                        </span>
                    </div>

                    <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">

                        <div class="p-t-15">
                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    ${{ number_format($shipping_fee,2) }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="flex-w flex-t p-t-27 p-b-33">
                    <div class="size-208">
                        <span class="mtext-101 cl2">
                            Total:
                        </span>
                    </div>

                    <div class="size-209 p-t-1">
                        <span class="mtext-110 cl2">
                            ${{ number_format(($sum + $shipping_fee),2) }}
                        </span>
                    </div>
                </div>

                <form method="POST" action="/setCartSession">
                    @csrf
                    <input type="hidden" name="cartId" value="{{ $cart_id }}">
                    <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        Proceed to Checkout
                    </button>
                </form>
                
            </div>
        </div>
    </div>
   
</div>
