@extends('layout.customer_new_layout')

@section('title', 'My Account')

@section('pagetitle', 'Addresses')

@section('content')

<section class="section">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <a href="{{ route('customer_new_address')}}" class="btn btn-primary btn-sm">Add New Address</a>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Set Default</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (json_decode($user->address,true) as $key => $addr)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('make_default', $key) }}"  class="text-success {{ $key == 0 ? 'disabled' : '' }}">
                                            <i class="bi {{ $key == 0 ? 'bi-circle-fill' : 'bi-circle' }}" style="font-size: 20px"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $addr['fname'] . " " . $addr['lname'] }}
                                    </td>
                                    <td>
                                        {{ isset($addr['phone']) ? $addr['phone'] : "" }}
                                    </td>
                                    <td>
                                        {{ $addr['delivery_address'] }}
                                    </td>
                                    <td>
                                        <a href="{{ route('edit_address', $key)}}" class="text-primary">
                                            <i class="bi bi-pencil-square" style="font-size: 20px"></i>
                                        </a>
                                        <a href="{{ route('delete_address', $key)}}" class="text-danger">
                                            <i class="bi bi-trash" style="font-size: 20px"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>
        </div>
    </div>
  </section>

@endsection

