@extends('layout.vendor_layout')

@section('pagetitle','All Customers')

@section('title', 'Vendor - All Customers')

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
                    <th scope="col">Customer</th>
                    <th scope="col">Total No of Orders</th>
                    <th scope="col">Total Purchase</th>
                    <th scope="col">View</th>
                  </tr>
                </thead>
                <tbody>
                @if(!$customers->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($customers as $customer)
                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $customer->business_name }}</td>
                    <td>{{ $customer->total_orders }}</td>
                    <td>${{ number_format($customer->total_price,2) }}</td>
                    <td align="center">
                        <a class="btn btn-primary btn-sm" href="/vendor/customer/view/{{$customer->id}}">View Customer</a>
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
