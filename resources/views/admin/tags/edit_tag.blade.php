@extends('layout.admin_layout')

@section('pagetitle','Edit Tag')

@section('title', 'Admin - Edit Tag')

@section('content')

<section class="section dashboard">
     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit {{ $tag->name }}</h5>

              <div class="text-end p-2">
                <a href="/admin/tag/" class="btn btn-primary btn-sm">
                    <i class="bi bi-backspace"></i> Back to Tags
                </a>
              </div>

              <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="/admin/tag/update">
                  @csrf
                  @method('PUT')

                  <input type="hidden" name="id" value="{{ $tag->id }}">
                <div class="col-md-12">
                    <div class="has-validation">
                        <label for="cat_name" class="form-label">Tag Name</label>
                        <input type="text" value="{{$tag->name}}" class="form-control  @error('name') is-invalid @enderror" id="cat_name" name='name' >
                        <div class="invalid-feedback">
                          @error('name') {{ $message }} @enderror
                        </div>
                     </div>

                </div>
                <div class="col-md-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea name='description' class="form-control @error('description') is-invalid @enderror" rows="5" id='description'>{{$tag->description}}</textarea>
                   <div class="invalid-feedback">
                        @error('description') {{ $message }} @enderror
                    </div>
                </div>
                <div class="col-md-12">
                  <div class="form-check">
                    <input class="form-check-input js-switch" type="checkbox" id="status" value='1' name='status' {{ $tag->status == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="status">
                      Activate Status
                    </label>
                </div>
                </div>
                <div class="text-end">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
</section>

@endsection
