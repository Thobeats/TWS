<div class="p-3">
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="container-fluid h-100">
        <div class="row h-100 mt-3">
            <div class="col-lg-2">
                <ul>
                    @if(count($categories) > 0)
                    @foreach ($categories as $cat)
                        <li class="p-1">
                            <a class="category-link {{ $active == $cat['id'] ? 'cat_active' : ''}}" href="#" onmouseover="getSubcategories({{$cat['id']}}, '1')">
                                <span>{{ $cat['name'] }}</span>
                                @if(in_array($cat['id'],array_column($hasChildren,'parent_id')))
                                    <span style="position: absolute; right:4px;"><i class="zmdi zmdi-chevron-right"></i></span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <div class="col-lg-2">
                <ul>
                    @forelse ($sub_categories as $scat)
                    <li class="p-1">
                        <a class="category-link {{ $active2 == $scat['id'] ? 'cat_active' : ''}}" href="#" onmouseover="getSubcategories({{$scat['id']}}, '2')">
                            <span>{{ $scat['name'] }}</span>
                            @if(in_array($scat['id'],array_column($hasChildren,'parent_id')))
                                <span style="position: absolute; right:4px;"><i class="zmdi zmdi-chevron-right"></i></span>
                            @endif
                        </a>
                    </li>
                    @empty
                    @endforelse
                </ul>
            </div>
            <div class="col-lg-2">
                <ul>
                    @forelse ($sub_categories2 as $scat2)
                    <li class="p-1">
                        <a class="category-link" href="#">
                            <span>{{ $scat2['name'] }}</span>
                        </a>
                    </li>
                    @empty
                    @endforelse
                </ul>
            </div>
            <div class="col-lg-6">
                <h4 class="sub-menu-title border border-top-0 border-left-0 border-right-0 border-left border-3 border-dark">
                    New Arrivals
                </h4>
                <div class="mt-3 product-wrapper d-flex">
                    @forelse ($new_arrivals as $new)
                        <div class="card mx-2" style="height: 400px; width: 220px;">
                            <div class="img-wrapper" style="height: 90%;">
                                <img src="{{ url('storage/products/'. json_decode($new->pics,true)[0]) }}" class="card-img-top h-100" alt="...">
                            </div>
                            <div class="row p-2 new_arrival">
                                <div class="col-7">
                                    <h6>{{ substr($new->name,0,10)."...." }}</h6>
                                    <h4 class="mt-1">${{ $new->price}}</h6>
                                </div>
                                <div class="col-5">
                                    <a class="btn btn-outline-dark btn-sm" href="/market/product/{{$new->id}}">View</a>
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse
                </div>
                <div class="text-right mt-2">
                    <a style="text-decoration: underline;" href="/shop">View More</a>
                </div>
            </div>
        </div>
    </div>
</div>
