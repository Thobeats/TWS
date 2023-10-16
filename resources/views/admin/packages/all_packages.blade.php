@extends('layout.admin_layout')

@section('pagetitle','All Packages')

@section('title', 'Admin - All Packages')

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
                    <th scope="col">Package Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody style="font-size: 12px;">
                @if(!$packages->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($packages as $package)
                @php
                   $created_at = date_create($package->created_at);
                    $created = date_format($created_at,'Y-m-d');
                    $status = $package->status == 1 ? 0 : 1; $switch = $package->status == 1 ? "Off" : "On";
                @endphp
                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $package->package_name }}</td>
                    <td>{{ $package->package_price }}</td>
                    <td>{{ $package->description }}</td>
                    <td>{!! $package->status == 1 ? "<span class='text-success'>Active</span>" :  "<span class='text-danger'>Deactivated</span>" !!}</td>
                    <td>{{ $created }}</td>
                    <td>
                        <a class='text-info' href="/admin/package/edit/{{$package->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Package"><i class='bi bi-pencil-square'></i></a>
                        <a class='text-success mx-2' href="/admin/package/toggle_active/{{$package->id}}?status={{$status}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle {{$switch}}">{!! $package->status == 0 ? "<i class='bi bi-eye'></i>" : "<i class='bi bi-eye-slash'></i>" !!}</a>
                        {{-- <a class='text-danger' href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Package"><i class='bi bi-trash'></i></a> --}}
                    </td>
                  </tr>
                  @php
                    $index++;
                    @endphp
                @endforeach
                @else
                    <tr> <td colspan="5">No Packages</td>  </tr>

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
