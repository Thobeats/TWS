@extends('layout.admin_layout')

@section('pagetitle','All Tags')

@section('title', 'Admin - All Tags')

@section('content')

 <section class="section">
      <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body pt-3">
                <div class="p-2 text-end">
                    <a class='btn btn-primary btn-sm' href='/admin/tag/create'>Add New Tag</a>
                </div>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                @if(!$tags->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($tags as $tag)
                @php $status = $tag->status == 1 ? 0 : 1; $switch = $tag->status == 1 ? "Off" : "On"; @endphp

                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->description }}</td>
                    <td>{!! $tag->status == 1 ? "<span class='text-success'>Active</span>" :  "<span class='text-danger'>Deactivated</span>" !!}</td>
                    <td>
                        <a class='text-info' href="/admin/tag/edit/{{$tag->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category"><i class='bi bi-pencil-square'></i></a>
                        <a class='text-success mx-2' href="/admin/tag/toggle_active/{{$tag->id}}?status={{$status}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle {{$switch}}">{!! $tag->status == 0 ? "<i class='bi bi-eye'></i>" : "<i class='bi bi-eye-slash'></i>" !!}</a>
                        {{-- <a class='text-danger' href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category"><i class='bi bi-trash'></i></a> --}}
                    </td>
                  </tr>
                  @php
                    $index++;
                    @endphp
                @endforeach
                @else
                    <tr> No Tags </tr>

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
