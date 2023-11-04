@extends('layout.vendor_layout')

@section('pagetitle',"Customer")

@section('title', 'Vendor - Customer')

@section('content')

<section class="section dashboard">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="order-img w-100 mt-3">
            <img src="{{ url('storage/'. $customer['profile']) }}" class="img-fluid">
          </div>
          <h4 class="mt-2">
            {{ $customer['business_name']}}
          </h4>
          <div class="row mt-5">
            <div class="col-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Total Orders</h5>
        
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        {{ $customer['total_orders']}}
                      </h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Total Purchases</h5>
        
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3 text-bold">
                      <h6>
                       {{  number_format($customer['total_purchase'],2) }}
                      </h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="customer_details py-3">
            <h4 class="pt-2">Order Details</h4>
            <hr>
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Product</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total Price</th>
                  <th scope="col">Date Ordered</th>
                </tr>
              </thead>
              <tbody>
             
                @forelse ($customer['orders'] as $order)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      @php
                        $product = \App\Models\Product::find($order['product_id']);

                        echo $product->name;
                      @endphp
                    </td>
                    <td>{{ json_decode($order['order_details'], true)['quantity'] }}</td>
                    <td>${{ number_format($order['total_price'],2) }}</td>
                    <td>{{ date_format(date_create($order['created_at']),  "Y/m/d") }}</td>
                  </tr>
                @empty
                  
                @endforelse
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
