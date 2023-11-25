<div>
    <div class="container-fluid h-100">
        <div class="row h-100 mt-3">
            <div class="col-lg-2 border border-left-0 border-top-0">
                <h4 class="sub-menu-title text-left">
                    Categories
                </h4>

                <div class="mt-3 product-wrapper d-flex justify-content-left">
                    <ul>
                        @if(count($categories) > 0)
                        @foreach ($categories as $cat)
                            <li class="p-1" onmouseover="getProducts({{$cat['id']}})">
                                <a class="category-link" href="/shop?cat_id={{$cat['id']}}">
                                    <span>{{ $cat['name'] }} ({{$cat['product_count']}})</span>
                                </a>
                            </li>
                        @endforeach
                        @endif
                        <hr>
                        <li>
                            <a class="category-link" href="/shop">View all</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="d-flex justify-content-end">
                    <div class="mr-2">
                        <div class="just-in"><b class="home-text">TODAY</b></div>
                        <h1 class="just-in-amount">{{ $today }}</h1>
                    </div>
                    <div>
                        <div class="just-in">Last <b class="home-text">7 days</b></div>
                        <h1 class="just-in-amount">{{ $last7days }}</h1>
                    </div>
                </div>
                <div class="product-wrapper">
                    <div class="mt-3 d-flex justify-content-left">
                        @forelse ($newProducts as $new)
                            <div class="block2 mr-2" style="width: 250px;">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ url('storage/products/'. json_decode($new->pics,true)[0]) }}" alt="IMG-PRODUCT" class="card-image">
                                </div>
                                <div class="p-2">
                                    <div class="d-flex justify-content-between">
                                       <div>
                                            <a href="/market/vendor/{{$new->vendor_id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2">
                                                {{ $new->vendorName() }}
                                            </a>
                                            <a href="/market/product/{{$new->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2">
                                                {{ substr($new->name,0,10) }}
                                            </a>
                                       </div>

                                       <div>
                                         <a href="/market/product/{{$new->id}}" class="btn btn-outline-dark btn-sm mt-3">View in Shop</a>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div>

                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
