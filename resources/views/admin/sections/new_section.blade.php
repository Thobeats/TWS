@extends('layout.admin_layout')

@section('pagetitle','New Section')

@section('title', 'Admin - New Section')

@section('content')

<section class="section dashboard">
     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Section</h5>

              <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="/admin/section/store">
                  @csrf
                <div class="col-md-12">
                    <div class="has-validation">
                        <label for="cat_name" class="form-label">Section Name</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="cat_name" name='name' >
                        <div class="invalid-feedback">
                          @error('name') {{ $message }} @enderror
                        </div>
                     </div>

                </div>
                <div class="col-lg-6">
                    <label for="for" class="form-label">For</label>
                    <select id="for" name='for' class="form-select @error('for') is-invalid @enderror">
                      <option>Select User Type</option>
                      @if(!empty($user_types))
                          @foreach ($user_types as $user)
                              <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                          @endforeach
                      @endif

                    </select>
                      <div class="invalid-feedback">
                          @error('for') {{ $message }} @enderror
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="has-validation">
                          <label for="cat_name" class="form-label">Position</label>
                          <input type="number" class="form-control  @error('position') is-invalid @enderror" id="position" name='position' >
                          <div class="invalid-feedback">
                            @error('position') {{ $message }} @enderror
                          </div>
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
                      Status
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
