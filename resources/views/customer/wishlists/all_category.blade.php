@extends('layout.customer_new_layout')

@section('pagetitle','All Wishlist Categories')

@section('title', 'Customer - All Wishlist Categories')

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
                    <th scope="col">Category Name</th>
                    {{-- <th scope="col">Category</th>
                    <th scope="col">Manage</th> --}}
                  </tr>
                </thead>
                <tbody>
                    @forelse ($allCategories as $cat)
                        <tr>
                            <th>{{ $loop->index + 1 }}</th>
                            <th>{{ ucwords($cat['category_name']) }}</th>
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
