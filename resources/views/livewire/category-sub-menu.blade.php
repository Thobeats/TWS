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
            @if (!empty($sub_categories))
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
            @endif

            @if (!empty($sub_categories2))
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
            @endif

            <div class="{{ $col_lg }}">
                <div class="mt-3 product-wrapper d-flex">
                    @forelse ($new_arrivals as $new)
                        @php
                            $pic = isset(json_decode($new->pics,true)[0]) ? json_decode($new->pics,true)[0] : ""
                        @endphp
                        <div class="block2 mr-2" style="width: 300px;">
                            <div class="block2-pic hov-img0">
                                <img src="{{ url('storage/products/'. $pic) }}" alt="IMG-PRODUCT" class="card-image">
                            </div>
                            <div class="p-2">
                                <div class="d-flex justify-content-between">
                                   <div>
                                        <a href="/market/vendor/{{$new->vendor_id}}" class="mtext-101 text-dark cl4 hov-cl1 trans-04 js-name-b2">
                                            {{ $new->vendorName() }}
                                        </a>
                                        <a href="/market/product/{{$new->id}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2">
                                            {{ $new->name }}
                                        </a>
                                   </div>

                                   <div>
                                     <a href="/market/product/{{$new->id}}" class="btn btn-outline-dark btn-sm mt-3">View in Shop</a>
                                   </div>
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
