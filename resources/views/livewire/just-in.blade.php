<div>
    <div class="container-fluid h-100">
        <div class="row h-100 mt-3">
            <div class="col-lg-2 border border-left-0 border-top-0">
                <hr>
                <div class="just-in">JUST IN <b class="home-text">TODAY</b></div>
                <h1 class="just-in-amount">{{ $today }}</h1>
                <hr>
                <div class="just-in">Last <b class="home-text">7 days</b></div>
                <h1 class="just-in-amount">{{ $last7days }}</h1>
                <hr>

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
                    </ul>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="product-wrapper h-75">
                    <div class="mt-3 d-flex justify-content-left">
                        @forelse ($newProducts as $new)
                            <div class="card mx-2" style="height: 400px; width: 220px;">
                                <div class="img-wrapper" style="height: 90%;">
                                    <img src="{{ url('storage/products/'. json_decode($new->pics,true)[0]) }}" class="card-img-top h-100" alt="...">
                                </div>
                                <div class="p-2 new_arrival">
                                    <a href="/market/vendor/{{$new->vendor_id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2">
                                        {{ $new->vendorName() }}
                                    </a> 
                                    <a class="stext-104 cl4 hov-cl1 trans-04 js-name-b2" href="/market/product/{{$new->id}}">
                                        {{ $new->name }}  
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div>

                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="view_all p-3 text-right">
                    <a class="btn btn-home" href="/shop">View all</a>
                </div>
            </div>
        </div>
    </div>
</div>