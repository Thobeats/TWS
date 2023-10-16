@extends('layout.vendor_layout')

@section('pagetitle','Edit Product')

@section('title', 'Vendor - Edit Product')

@section('content')

<section class="section dashboard">

     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit {{ $product->name }}</h5>

              <div class="text-end p-2">
                <a href="/vendor/products/" class="btn btn-primary btn-sm">
                    <i class="bi bi-backspace"></i> Back to products
                </a>
              </div>

              <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="/vendor/products/update">
                  @csrf
                  @method('PUT')

                <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class="col-md-6">
                    <div class="has-validation">
                        <label for="cat_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name='name' value="{{ $product->name }}">
                        <div class="invalid-feedback">
                          @error('name') {{ $message }} @enderror
                        </div>
                     </div>

                </div>
                <div class="col-md-6">
                  <label for="category" class="form-label">Category</label>
                  <select id="category" name='category_id[]' class="form-select @error('category_id') is-invalid @enderror js-example-basic-multiple" multiple>
                    @if($category_template != "")
                        {!! $category_template !!}
                    @endif
                  </select>
                    <div class="invalid-feedback">
                        @error('category_id') {{ $message }} @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                  <label for="tag" class="form-label">Tags</label>
                  <select id="tag" name='tags[]' class="form-select @error('tag') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                    @if(!empty($tags))
                        @foreach($tags as $tag)
                            <option {{ in_array($tag['id'], json_decode($product->tags, true)) ? 'selected' : ''  }} value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                        @endforeach
                    @endif
                  </select>
                    <div class="invalid-feedback">
                        @error('tags') {{ $message }} @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                  <label for="tag" class="form-label">Sizes</label>
                  <select id="sizes" name='sizes[]' class="form-select @error('tag') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                    @if(!empty($sizes))
                        @foreach($sizes as $size)
                        <option {{ in_array($size['id'], json_decode($product->sizes, true)) ? 'selected' : ''  }}  value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
                        @endforeach
                    @endif
                  </select>
                    <div class="invalid-feedback">
                        @error('sizes') {{ $message }} @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                  <label for="tag" class="form-label">Colors</label>
                  <select id="colors" name='colors[]' class="form-select @error('tag') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                    @if(!empty($colors))
                        @foreach($colors as $color)
                        <option {{ in_array($color['id'], json_decode($product->colors, true)) ? 'selected' : ''  }}  value="{{ $color['id'] }}">{{ $color['name'] }}</option>
                        @endforeach
                    @endif
                  </select>
                    <div class="invalid-feedback">
                        @error('colors') {{ $message }} @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                     <label for="price" class="form-label">Price</label>
                     <input type="number" value="{{ $product->price }}" name="price" class="form-control @error('price') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('price') {{ $message }} @enderror
                    </div>
                </div>
                 <div class="col-lg-4">
                     <label for="no_in_stock" class="form-label">No in Stock</label>
                     <input type="number" value="{{ $product->no_in_stock }}" name="no_in_stock" class="form-control @error('no_in_stock') is-invalid @enderror">
                     <div class="invalid-feedback">
                        @error('no_in_stock') {{ $message }} @enderror
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="tag" class="form-label">Product SKU</label>
                    <input type="text" name="sku" value="{{ $product->sku}}" class="form-control @error('sku') is-invalid @enderror">
                      <div class="invalid-feedback">
                          @error('sku') {{ $message }} @enderror
                      </div>
                  </div>
                  <div class="col-lg-4">
                       <label for="sections" class="form-label">Section</label>
                       <select id="sections" name='sections[]' class="form-select @error('sections') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                        @if(!empty($sections))
                            @foreach($sections as $section)
                            <option {{ in_array($section['id'], json_decode($product->section_id, true)) ? 'selected' : ''}} value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                            @endforeach
                        @endif
                      </select>
                      <div class="invalid-feedback">
                        @error('sections') {{ $message }} @enderror
                    </div>
                  </div>
                   <div class="col-lg-4">
                       <label for="shipping_typ" class="form-label">Shipping Type</label>
                       <select onchange="setShipCharge(event)" id="shipping_type" name='shipping_type' class="form-select @error('sections') is-invalid @enderror" data-ref="shipping_fee">
                        <option>Select Shipping Type</option>
                        @if(!empty($shipping))
                            @foreach($shipping as $ship)
                            <option {{ $product->shipping_type == $ship['id'] ? 'selected' : '' }} value="{{ $ship['id'] }}">{{ $ship['name'] }}</option>
                            @endforeach
                        @endif
                      </select>
                      <div class="invalid-feedback">
                        @error('shipping_type') {{ $message }} @enderror
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label for="shipping_fee" class="form-label">Shipping Fee</label>
                        <input required type="number" value="{{ $product->shipping_fee}}" id="shipping_fee" name='shipping_fee' class="form-control @error('shipping_fee') is-invalid @enderror">
                        <div class="invalid-feedback">
                            @error('shipping_fee') {{ $message }} @enderror
                        </div>
                  </div>
                  <div class="col-lg-3 p-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="status" value='1' name='publish_status' {{ $product->publish_status ? 'checked' : ''}} >
                      <label class="form-check-label" for="status">
                        Publish
                      </label>
                      </div>
                  </div>

                  <div class="col-lg-3 p-2">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ready_to_ship" value='1' name='ready_to_ship' {{ $product->ready_to_ship ? 'checked' : ''}}>
                        <label class="form-check-label" for="status">
                          Ready To Ship
                      </label>
                      </div>
                  </div>
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name='description' rows="15" class="tinymce-editor form-control @error('description') is-invalid @enderror" id='product_description'>{!! $product->description !!}</textarea>
                    <div class="invalid-feedback">
                        @error('description') {{ $message }} @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <label for="no_in_stock" class="form-label">Product Pictures</label>
                    <input id='pics' type="file" name="pics[]" multiple class="form-control @error('pics') is-invalid @enderror">
               </div>
                <div class="text-end">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
</section>

@endsection
