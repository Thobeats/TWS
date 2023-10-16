@extends('layout.admin_layout')

@section('pagetitle','All Banners')

@section('title', 'Admin - All Banners')

@section('content')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class='p-2 text-end'>
                <a class='btn btn-primary btn-sm' href='/admin/banner/create'>Add New Banner</a>
            </div>
          <div class="card">
            <div class="card-body pt-3">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Banner Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Subtitle</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                @if(isset($banners) && !$banners->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($banners as $banner)
                @php $status = $banner->status == 1 ? 0 : 1; $switch = $banner->status == 1 ? "Off" : "On"; @endphp

                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>
                        <img src="{{ url('storage/slides/'. $banner->image) }}" alt="Banner Image" width="150px">
                    </td>
                    <td>{{ $banner->title }}</td>
                    <td>{{ $banner->subtitle }}</td>
                    <td>{{ implode(", ",$banner->tags()) }}</td>
                    <td>{!! $banner->status == 1 ? "<span class='text-success'>Active</span>" :  "<span class='text-danger'>Deactivated</span>" !!}</td>
                    <td>
                        <a class='text-info' href="/admin/banner/edit/{{$banner->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Banner"><i class='bi bi-pencil-square'></i></a>
                        <a class='text-success mx-2' href="/admin/banner/toggle_active/{{$banner->id}}?status={{$status}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle {{$switch}}">{!! $banner->status == 0 ? "<i class='bi bi-eye'></i>" : "<i class='bi bi-eye-slash'></i>" !!}</a>
                    </td>
                  </tr>
                  @php
                    $index++;
                    @endphp
                @endforeach
                @else
                    <tr> <td colspan="7" class="text-center">No Banners</td> </tr>
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
