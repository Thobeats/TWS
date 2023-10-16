@extends('layout.admin_layout')

@section('pagetitle','New Category')

@section('title', 'Admin - New Category')

@section('content')

<section class="section dashboard">
     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Category</h5>

              <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="/admin/categories/store">
                  @csrf
                <div class="col-md-6">
                    <div class="has-validation">
                        <label for="cat_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="cat_name" name='name' >
                        <div class="invalid-feedback">
                          @error('name') {{ $message }} @enderror
                        </div>
                     </div>

                </div>
                <div class="col-lg-6">
                    <label for="parent" class="form-label">Parent</label>
                    <select id="parent" name='parent_id' class="form-select @error('parent_id') is-invalid @enderror">
                      <option value='0'>No Parent</option>
                      @if($parent->count() > 0)
                          @foreach($parent as $p)
                              <option value="{{$p->id }}">{{ $p->name }}</option>
                          @endforeach
                      @endif
                    </select>
                      <div class="invalid-feedback">
                          @error('parent_id') {{ $message }} @enderror
                      </div>
                  </div>
                <div class="col-md-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea name='description' class="form-control @error('description') is-invalid @enderror" rows="5" id='description'></textarea>
                   <div class="invalid-feedback">
                        @error('description') {{ $message }} @enderror
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="form-check">
                    <input class="form-check-input js-switch" type="checkbox" id="status" value='1' name='status' checked>
                    <label class="form-check-label" for="status">
                      Activate Status
                    </label>
                </div>
                </div>
                <div class="text-end">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
</section>

@endsection
