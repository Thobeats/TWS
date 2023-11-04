@extends('layout.vendor_layout')

@section('pagetitle',"Reports")

@section('title', 'Vendor - Reports')

@section('content')

<section class="section dashboard">
  <div class="card">
    <div class="card-body">
      <form action="/vendor/report" method="POST" class="p-3">
        @csrf
       <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <label for="from">From</label>
                <input type="date" name="from" id="from" value="{{$from}}" min="{{ date_format(date_create($user->created_at), 'Y-m-d') }}" class="form-control mt-2">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="to">To</label>
                <input type="date" name="to" id="to" value="{{$to}}" max="{{ date_format(date_create(now()), 'Y-m-d') }}" class="form-control mt-2">
            </div>
        </div>
       </div>
       <div class="mt-3 text-end">
        <button type="submit" class="btn btn-primary">Generate</button>
       </div>
      </form>
    </div>
  </div>

  @if(count($orders) > 0)
  <div class="card mt-3">
    <div class="card-body">
        <table class="table datatable">
            <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Product</th>
                  <th scope="col">Customer</th>
                   <th scope="col">Total Price</th>
                  <th scope="col">Order Number</th>
                  <th scope="col">Order Status</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Size</th>
                  <th scope="col">Color</th>
                  <th scope="col">Ordered Date</th>
                  <th scope="col">Delivery Date</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 1;
                @endphp
                @foreach($orders as $order)
                <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->firstname . " " . $order->lastname }}</td>
                    <td>${{ number_format($order->total_price,2) }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->size }}</td>
                    <td>{{ $order->color }}</td>
                    <td>{{ $order->ordered_date }}</td>
                    <td>{{ $order->delivery_date }}</td>
                </tr>
                @php
                    $index++;
                @endphp
                @endforeach
               
            </tbody>
        </table>
    </div>
  </div>
  @endif
</section>
@endsection
