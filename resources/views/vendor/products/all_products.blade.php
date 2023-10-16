@extends('layout.vendor_layout')

@section('pagetitle','All Products')

@section('title', 'Vendor - All Products')

@section('content')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class='p-2 text-end'>
                <a class='btn btn-primary btn-sm' href='/vendor/products/create'>Add New Product</a>
            </div>
          <div class="card">
            <div class="card-body pt-3">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                     <th scope="col">Price</th>
                    <th scope="col">No in Stock</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                @if(!$products->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($products as $product)
                    @php $status = $product->publish_status == 1 ? 0 : 1; $switch = $product->publish_status == 1 ? "Off" : "On"; @endphp
                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->no_in_stock }}</td>
                    <td>{!! $product->publish_status == 1 ? "<span class='text-success'>Published</span>" :  "<span class='text-danger'>Not Published</span>" !!}</td>
                    <td>
                        <a class='text-info' href="/vendor/products/edit/{{$product->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit product"><i class='bi bi-pencil-square'></i></a>
                        <a class='text-success mx-2' href="/vendor/products/toggle_active/{{$product->id}}?status={{$status}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle {{$switch}}">{!! $product->publish_status == 0 ? "<i class='bi bi-eye'></i>" : "<i class='bi bi-eye-slash'></i>" !!}</a>
                        <a class='text-danger' href="/vendor/products/delete/{{$product->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete product"><i class='bi bi-trash'></i></a>
                    </td>
                  </tr>
                  @php
                    $index++;
                  @endphp
                @endforeach
                @else
                    <tr> No products </tr>

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
