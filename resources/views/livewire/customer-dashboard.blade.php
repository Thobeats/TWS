<div>
    {{-- All Orders, No of Saved Items, No of Subscribed Vendors --}}
    <div class="row">
        <div class="col">
            <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li > <a class="dropdown-item" wire:click="filterOrders('all')">All</a></li>
                    <li><a class="dropdown-item" wire:click="filterOrders('this month')">This Month</a></li>
                    <li><a class="dropdown-item" wire:click="filterOrders('today')">Today</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Orders <span>| {{ $orderTag }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $orders }}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
                    </div>
                  </div>
                </div>

            </div>
        </div>

        <div class="col">
            <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Saved Items</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-heart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $savedItems }}</h6>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">My Subscriptions</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ "2" }}</h6>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Recent Orders</h5>
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">No of items</th>
                            <th scope="col">Price</th>
                            <th scope="col">Vendor</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody style="font-size: 14px;">
                            @forelse ($recentOrders as $recentOrder)
                                <tr>
                                    <th>{{$loop->index + 1}}</th>
                                    <td align="center"><a href="/market/product/{{$recentOrder['prodID']}}" target="_blank"><img src="{{ url('storage/products/'. json_decode($recentOrder['pics'],true)[0]) }}" width="40px" alt=""></a></td>
                                    <td align="center">{{ $recentOrder['num_products'] }}</td>
                                    <td class="fw-bold">${{ number_format($recentOrder['total_price'],2) }}</td>
                                    <td><a href="#" class="text-primary fw-bold">{{ $recentOrder['firstname'] . " " . $recentOrder['lastname'] }}</a></td>
                                    <td>
                                        <span class='badge {{
                                                        ($recentOrder["status_id"] == 1 ? "bg-warning" :
                                                        ($recentOrder["status_id"] == 2 ? "bg-success" :
                                                        "bg-danger"))
                                                    }}'>
                                                {{ $recentOrder['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No Orders</td>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                    <hr>
                    <a class="btn text-primary btn-sm float-end" href="/customer/orders">View More</a>
                </div>
            </div>
        </div>
    </div>

</div>
