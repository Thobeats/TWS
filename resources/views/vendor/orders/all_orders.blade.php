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
                    <th scope="col">Order Number</th>
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
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->description }}</td>
                    <td>{{ $order->price }}</td>
                    <td><a class='text-success mx-2' href="/vendor/orders/show/{{$order->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order"><i class='bi bi-eye'></i></a></td>
                    <td>{!! $order->status == 1 ? "<span class='text-success'>Active</span>" :  "<span class='text-danger'>Deactivated</span>" !!}</td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
