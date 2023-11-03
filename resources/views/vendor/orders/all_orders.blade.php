@extends('layout.vendor_layout')

@section('pagetitle','All Orders')

@section('title', 'Vendor - All Orders')

@section('content')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product</th>
                    <th scope="col">Customer</th>
                     <th scope="col">Total Price</th>
                    <th scope="col">View Order</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                @if(!$orders->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($orders as $order)
                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->firstname . " " . $order->lastname }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td><a class='text-primary mx-2' href="/vendor/orders/show/{{$order->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order">{{ $order->order_number }}</a></td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Actions
                            </a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#">Delivered</a></li>
                              <li><a class="dropdown-item" href="#">Cancel</a></li>
                            </ul>
                        </div>
                    </td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @else
                    <tr> No Orders </tr>

                @endif
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>
@endsection
