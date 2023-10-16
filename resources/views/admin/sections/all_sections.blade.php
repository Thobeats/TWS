@extends('layout.admin_layout')

@section('pagetitle','All Sections')

@section('title', 'Admin - All Sections')

@section('content')

 <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class='p-2 text-end'>
                <a class='btn btn-primary btn-sm' href='/admin/section/create'>Add New Section</a>
            </div>
          <div class="card">
            <div class="card-body pt-3">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">For</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                @if(isset($sections) && !$sections->isEmpty())
                @php
                    $index = 1;
                @endphp
                @foreach($sections as $section)
                @php $status = $section->status == 1 ? 0 : 1; $switch = $section->status == 1 ? "Off" : "On"; @endphp

                  <tr>
                    <th scope="row">{{ $index }}</th>
                    <td>{{ $section->name }}</td>
                    <td>{{ $section->description }}</td>
                    <td>{!! $section->status == 1 ? "<span class='text-success'>Active</span>" :  "<span class='text-danger'>Deactivated</span>" !!}</td>
                    <td>{{ $section->for }}</td>
                    <td>
                        <a class='text-info' href="/admin/section/edit/{{$section->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Section"><i class='bi bi-pencil-square'></i></a>
                        <a class='text-success mx-2' href="/admin/section/toggle_active/{{$section->id}}?status={{$status}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle {{$switch}}">{!! $section->status == 0 ? "<i class='bi bi-eye'></i>" : "<i class='bi bi-eye-slash'></i>" !!}</a>
                        {{-- <a class='text-danger' href="/admin/section/delete/{{$section->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Section"><i class='bi bi-trash'></i></a> --}}
                    </td>
                  </tr>
                  @php
                    $index++;
                    @endphp
                @endforeach
                @else
                    <tr> No Sections </tr>
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
