@extends('layout.admin_layout')

@section('pagetitle','New Slide')

@section('title', 'Admin - New Slide')

@section('content')

<section class="section dashboard">
     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Slide</h5>

              <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="/admin/slide/store">
                  @csrf
                    <div class="col-md-12">
                        <div class="has-validation">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title" name='title' >
                            <div class="invalid-feedback">
                            @error('title') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="has-validation">
                            <label for="subtitle" class="form-label">SubTitle</label>
                            <input type="text" class="form-control  @error('subtitle') is-invalid @enderror" id="subtitle" name='subtitle' >
                            <div class="invalid-feedback">
                            @error('subtitle') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="tags" class="form-label">Tags</label>
                        <select id="tags" name='tags[]' class="js-example-basic-multiple @error('tags') is-invalid @enderror" multiple style="width: 100%">
                        @if(!empty($tags))
                            @foreach ($tags as $tag)
                                <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                            @endforeach
                        @endif

                        </select>
                        <div class="invalid-feedback">
                            @error('tags') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="image" class="form-label">Slide Image</label>
                        <input id='image' type="file" name="image" class="form-control @error('image') is-invalid @enderror">
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
