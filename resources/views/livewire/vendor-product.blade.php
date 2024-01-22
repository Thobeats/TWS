<div>

              <!-- Multi Columns Form -->
              <form id="editProduct"
              class="row g-3"
              {{-- method="POST" action="/vendor/products/update" --}}
              >
                @csrf
              <input type="hidden" name="product_id" value="{{$product->id}}">
              <div class="row mt-3">
                <div class="col-lg-12">
                  <div class="has-validation">
                        <label for="cat_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name='name' value="{{ $product->name }}">
                        <div id="name_error" class="invalid-feedback"></div>
                    </div>
                </div>
            </div>

            {{-- <div class="row mt-3">
               <div class="row col-12 categories">
                <div class="col-md-4">
                  <label for="category" class="form-label">Category</label>
                  <select id="category" name='category_id[]' class="form-select @error('category_id') is-invalid @enderror" onchange="getCategory(event)">
                    <option value="">Select Category</option>
                   @forelse ($categories as $category)
                     <option {{ in_array($category['id'], $cats) ? 'selected' : ''}}  value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                   @empty
                   @endforelse
                  </select>
                    <div class="invalid-feedback">
                        @error('category_id') {{ $message }} @enderror
                    </div>
                </div>
                <div class="col-md-4 {{ count($cats) > 1 ? '' : 'd-none' }} subcatwrapper">
                  <label for="category" id="sub_cat" class="form-label">Sub Category</label>
                  <select {{ count($cats) > 1 ? '' : 'disable' }} id="subcategory" name='category_id[]' class="form-select @error('category_id') is-invalid @enderror" onchange="getCategory(event, 2)">
                      {!! $subcatTemp !!}
                  </select>
                </div>
                <div class="col-md-4 {{ count($cats) > 2 ? '' : 'd-none' }} subsubcatwrapper">
                  <label for="category" id="sub_cat" class="form-label">Sub Category</label>
                  <select {{ count($cats) > 2 ? '' : 'disable' }} id="subsubcategory" name='category_id[]' class="form-select @error('category_id') is-invalid @enderror">
                    {!! $subcatTemp2 !!}
                  </select>
                </div>
               </div>
            </div> --}}

              <div class="row mt-3">
                  <div class="row col-12">
                  <div class="col-12">
                  <label for="category" class="form-label">Category</label>
                  <select id="category" name='category_id[]' class="@error('category_id') is-invalid @enderror" multiple style="width: 100%">
                      {!! $categoryTemp !!}
                  </select>
                  <div id="category_id_error" class="invalid-feedback"></div>
                  </div>
              </div>

            <div class="row mt-3">
              <div class="col-lg-6">
                <label for="tags" class="form-label">Tags</label>
                <select id="tags" name='tags[]' class="form-select @error('tags') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                  @if(!empty($tags))
                      @foreach($tags as $tag)
                      <option {{ in_array($tag['id'], $product_tags) ? 'selected' : '' }} value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                      @endforeach
                  @endif
                </select>
                <div id="tags_error" class="invalid-feedback"></div>
              </div>

              <div class="col-lg-6">
                <label for="tag" class="form-label">Product SKU (optional)</label>
                <input value="{{ $product->sku }}" type="text" name="sku" class="form-control @error('sku') is-invalid @enderror">
                <div id="sku_error" class="invalid-feedback"></div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-lg-6">
                    <label for="sections" class="form-label">Section</label>
                    <select id="sections" name='sections[]' class="form-select @error('sections') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                    @if(!empty($sections))
                        @foreach($sections as $section)
                        <option {{ $product->section_id && in_array($section['id'], $product_sections) ? 'selected' : '' }} value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                        @endforeach
                    @endif
                  </select>
                  <div id="sections_error" class="invalid-feedback"></div>
              </div>

              <div class="col-lg-3 mb-3">
                <label for="shipping_fee" class="form-label">Shipping Fee</label>
                    <input required type="number" value="{{$product->shipping_fee}}" id="shipping_fee" name='shipping_fee' class="form-control @error('shipping_fee') is-invalid @enderror">
                    <div id="shipping_fee_error" class="invalid-feedback"></div>
              </div>
              <div class="col-lg-3 mb-3">
                <label for="moq" class="form-label">Minimum Order Quantity</label>
                    <input required type="number" value="{{$product->moq}}"  id="moq" name='moq' class="form-control @error('moq') is-invalid @enderror">
                    <div id="moq_error" class="invalid-feedback"></div>
              </div>
            </div>

            <div class="row mt-3">
                @if(count($variants) > 0)
                <div class="col-12">
                    <h5 class='card-title'>Variants</h5>
                </div>
                <div class="col-12">
                    @foreach ($productVariants as $variant)
                    <div class='card'>
                        <div class='card-body pt-2'>
                            <div class='text-end'>
                                <span class='text-dark' style='font-size:14px;cursor:pointer;'>
                                    <i class="bi bi-pencil"></i> Edit
                                </span>
                            </div>
                            <h6>{{$variant['variant']}}</h6>
                            <div>
                                @foreach (explode(",",$variant['value']) as $value)
                                <span class='badge bg-secondary me-2'> {{$value}}</span>
                                @endforeach
                            </div>
                            <div class='d-block'>
                                <input wire:model="" type='hidden' value='{{$variant['variant']}}'>
                                <input wire:model="" type='hidden' value='{{$variant['value']}}'>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-12">
                    <table class="table table-borderless" id='table-variant'>
                        <colgroup>
                            <col span="1" style="width: 40%;">
                            <col span="1" style="width: 20%;">
                            <col span="1" style="width: 20%;">
                            <col span="1" style="width: 20%;">
                        </colgroup>
                        <thead class="border">
                            <tr>
                                <th>listings</th>
                                <th>no in stock</th>
                                <th>purchase limit</th>
                                <th>price</th>
                            </tr>
                        </thead>
                        <tbody id="variant-table">
                            @foreach ($variantListings as $index => $variantListing)
                            <tr>
                                <td>
                                    {{$variantListing["'listing_name'"]}}
                                    <input type='hidden' value=`{{$variantListing["'listing_name'"]}}`>
                                </td>
                                <td>
                                    <input type="number" class="" value="{{$variantListing["'listing_no_in_stock'"]}}">
                                </td>
                                <td>
                                    <input type="number" value="{{$variantListing["'listing_purchase_limit'"]}}">
                                </td>
                                <td>
                                    <input type="text" value="{{$variantListing["'listing_price'"]}}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                @endif
            </div>
            <div class="row mt-3">
              <div class="col-12">
                <label for="product_description" class="form-label">Description</label>
                <textarea name='description' rows="15" class="tinymce-editor form-control @error('description') is-invalid @enderror" id='product_description'>{{ $product->description}}</textarea>
                <div id="description_error" class="invalid-feedback"></div>

              </div>
            </div>

            <div class="row mt-3">
              <div class="col-lg-12">
                    <label for="pics" class="form-label">Product Pictures</label>
                    <input id='pics' type="file" name="pics[]" multiple class="form-control">
              </div>
              <div id="pics_error" class="invalid-feedback"></div>
            </div>

            <div class="text-end mt-3">
              <button name="save" id="editsubmitBtn" type="button" class="btn btn-success">Publish</button>
              <button name='draft' id="editdraftBtn" type="button" class="btn btn-primary">Add to Draft</button>
            </div>
            </form><!-- End Multi Columns Form -->

</div>
