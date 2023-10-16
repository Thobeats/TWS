@extends('layout.admin_layout')

@section('pagetitle','Edit Slide')

@section('title', 'Admin - Edit Slide')

@section('content')

<section class="section dashboard">
     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit {{ $slide->title}}</h5>

              <div class="text-end p-2">
                <a href="/admin/section/" class="btn btn-primary btn-sm">
                    <i class="bi bi-backspace"></i> Back to slides
                </a>
              </div>

              <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="/admin/slide/update">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $slide->id }}">

                @php
                    $image = $slide->image;
                @endphp

                <div class="col-md-12">
                    <div class="has-validation">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title" name='title' value="{{$slide->title}}">
                        <div class="invalid-feedback">
                        @error('title') {{ $message }} @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="has-validation">
                        <label for="subtitle" class="form-label">SubTitle</label>
                        <input type="text" class="form-control  @error('subtitle') is-invalid @enderror" id="subtitle" name='subtitle' value="{{$slide->subtitle}}">
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
                            <option {{in_array($tag['id'], json_decode($slide->tags,true)) ? 'selected' : ''}} value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
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
                        <input class="form-check-input js-switch" type="checkbox" id="status" value='1' name='status'  {{ $slide->status == 1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="status">
                        Status
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
