@extends('layout.admin_layout')

@section('pagetitle','All Vendors')

@section('title', 'Admin - All Vendors')

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
                    <th scope="col">Business Name</th>
                    <th scope="col">Joined at</th>
                    <th scope="col">Action</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody style="font-size: 12px;">
                @if(!$vendors->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($vendors as $vendor)
                @php
                   $created_at = date_create($vendor->created_at);
                    $joined_at = date_format($created_at,'Y-m-d');
                @endphp
                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>
                        <a  href="/admin/vendors/view/{{$vendor->id}}"  data-bs-toggle="view vendor">
                            {{ $vendor->fullname() }}
                        </a>
                    </td>
                    <td>{{ $vendor->email }}</td>
                    <td>{{ $vendor->business_name }}</td>
                    <td>{{ $joined_at }}</td>
                    <td>
                        <a href="/admin/vendors/toggle/{{ $vendor->id }}" class='badge bg-primary' data-bs-placement="top">
                            {!! $vendor->account_status == 0 ? "Activate <i class='bi bi-eye-fill'></i>" : "Deactivate <i class='bi bi-eye'></i>" !!}
                        </a>
                    </td>
                    <td>
                        {!! $vendor->account_status == 0 ? "<span class='badge bg-danger'>Deactivated</span>" : "<span class='badge bg-success'>Active</span>" !!}
                    </td>

                    <!--<td>-->
                    <!--    <a class='text-info' href="/admin/customer/edit/{{$vendor->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><i class='bi bi-pencil-square'></i></a>-->
                    <!--    <a class='text-success mx-2' href="/admin/customer/toggle_active/{{$vendor->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle Active Status"><i class='bi bi-eye'></i></a>-->
                    <!--    <a class='text-danger' href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category"><i class='bi bi-trash'></i></a>-->
                    <!--</td>-->
                  </tr>
                  @php
                    $index++;
                    @endphp
                @endforeach
                @else
                    <tr> No Vendors </tr>

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
