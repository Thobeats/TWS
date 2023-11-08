@extends('layout.admin_layout')

@section('pagetitle','All Customers')

@section('title', 'Admin - All Customers')

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
                    <th scope="col">Fullname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Business Name</th>
                    <th scope="col">Account Status</th>
                    <th scope="col">Joined at</th>
                  </tr>
                </thead>
                <tbody style="font-size: 12px;">
                @if(!$customers->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($customers as $customer)
                @php
                   $created_at = date_create($customer->created_at);
                    $joined_at = date_format($created_at,'Y-m-d');
                @endphp
                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $customer->fullname() }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->business_name }}</td>
                    <td>{{ $customer->account_status }}</td>
                    <td>{{ $joined_at }}</td>
                    
                    <!--<td>-->
                    <!--    <a class='text-info' href="/admin/customer/edit/{{$customer->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><i class='bi bi-pencil-square'></i></a>-->
                    <!--    <a class='text-success mx-2' href="/admin/customer/toggle_active/{{$customer->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle Active Status"><i class='bi bi-eye'></i></a>-->
                    <!--    <a class='text-danger' href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category"><i class='bi bi-trash'></i></a>-->
                    <!--</td>-->
                  </tr>
                  @php
                    $index++;
                    @endphp
                @endforeach
                @else
                    <tr> No Customers </tr>
                
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