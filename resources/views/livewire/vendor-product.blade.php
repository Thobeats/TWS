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
                <div class="col-12">
                    <h5 class='card-title'>Variants</h5>
                </div>

              <div class="col-12">
                <table class="table table-bordered">

                  <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Colors (optional)</th>
                      <th scope="col" colspan="2"></th>
                    </tr>
                  </thead>
                  <tbody id="inventory">
                    @php
                      $index = 0;
                    @endphp
                    @if($product->item_listing)
                    @forelse (json_decode($product->item_listing, true) as $key => $item)
                    <tr id="{{$index}}">
                      <td>
                         <button class='btn btn-danger btn-sm' type='button' onclick=removeInventory({{$index}})><i class='bi bi-trash'></i></button>
                      </td>
                      <td>
                          <select id="colors" name='colors[]' class="color-select" style="width: 100%">
                              <option value="no_color">No Color</option>
                              @if(!empty($colors))
                                  @foreach($colors as $color)
                                  <option {{ $color['id'] == $key ? 'selected' : '' }} value="{{ $color['id'] }}">{{ $color['name'] }}</option>
                                  @endforeach
                              @endif
                          </select>
                      </td>
                     <td>
                        <table class="table table-bordered">
                          <colgroup>
                              <col span="1" style="width: 30%;">
                              <col span="1" style="width: 30%;">
                              <col span="1" style="width: 30%;">
                              <col span="1" style="width: 10%;">
                          </colgroup>
                          <thead>
                            <tr>
                              <th>no in stock</th>
                              <th>Size</th>
                              <th>Price</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="record{{$index}}">
                            @php
                              $index2 = 0;
                              $rows = [];

                              foreach($item as $key => $rec)
                              {
                                  $i = 0;
                                  foreach($rec as $val){
                                      $rows[$i][$key] = $val;
                                      $i++;
                                  }
                              }

                            @endphp
                            @foreach ($rows as $key => $itemRecord)
                            <tr id="record{{$index.$index2}}">
                              <td>
                                <input type="number" value="{{ isset($itemRecord[1]) ? $itemRecord[1] : ''}}" name="no_in_stock[{{$index}}][]" required class="@error('no_in_stock') is-invalid @enderror">
                              </td>
                              <td>
                                <select id="sizes" name='sizes[{{$index}}][]' class="@error('sizes') is-invalid @enderror" style="width: 100%">
                                  <option value="">Select Size</option>
                                  @if(!empty($sizes))
                                      @foreach($sizes as $size)
                                      <option {{ isset($itemRecord[0]) && $itemRecord[0] == $size['id'] ? 'selected' : '' }} value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
                                      @endforeach
                                  @endif
                                </select>
                              </td>
                              <td>
                                  <input type="text" value="{{ isset($itemRecord[2]) ? $itemRecord[2] : '' }}" name="p_price[{{$index}}][]" required id="">
                              </td>
                              <td>
                                <button class='btn btn-danger btn-sm' onclick=removeRecord(record{{$index.$index2}},record{{$index}})><i class='bi bi-trash'></i></button>
                              </td>
                            </tr>
                            @php
                              $index2++;
                            @endphp
                            @endforeach
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" class="text-end">
                                <button type="button" onclick="addNewRecord({{$index}})" class="btn btn-primary btn-sm">
                                  <i class="bi bi-plus-circle-fill"></i> Add
                                </button>
                              </th>
                            </tr>
                          </tfoot>
                        </table>
                     </td>
                    </tr>
                    @php
                      $index++;
                    @endphp
                    @empty
                    <tr>
                      <td></td>
                      <td>
                          <select id="colors" name='colors[0][]' class="color-select" style="width: 100%">
                              <option value="no_color">No Color</option>
                              @if(!empty($colors))
                                  @foreach($colors as $color)
                                  <option value="{{ $color['id'] }}">{{ $color['name'] }}</option>
                                  @endforeach
                              @endif
                          </select>
                      </td>
                     <td>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>no in stock</th>
                              <th>Size</th>
                              <th>Price</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="record0">
                            <tr>
                              <td>
                                <input type="number" name="no_in_stock[0][0][]" required class="form-control @error('no_in_stock') is-invalid @enderror">
                              </td>
                              <td>
                                <select id="sizes" name='sizes[0][0][]' class="form-select @error('sizes') is-invalid @enderror" style="width: 100%">
                                  <option value="">Select Size</option>
                                  @if(!empty($sizes))
                                      @foreach($sizes as $size)
                                      <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
                                      @endforeach
                                  @endif
                                </select>
                              </td>
                              <td>
                                  <input type="text" name="p_price[0][0][]" required id="">
                              </td>
                              <td></td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" class="text-end">
                                <button type="button" onclick="addNewRecord(0)" class="btn btn-primary btn-sm">
                                  <i class="bi bi-plus-circle-fill"></i> Add
                                </button>
                              </th>
                            </tr>
                          </tfoot>
                        </table>
                     </td>
                    </tr>
                    @endforelse
                    @endif

                  </tbody>
                </table>
                <table class="table table-borderless">
                  <tfoot>
                      <tr>
                          <th>
                              <div id="colors_error" class="invalid-feedback"></div>
                          </th>
                          <th>
                              <div id="no_in_stock_error" class="invalid-feedback"></div>
                          </th>
                          <th>
                              <div id="sizes_error" class="invalid-feedback"></div>
                          </th>
                          <th>
                              <div id="p_price_error" class="invalid-feedback"></div>
                          </th>
                      </tr>
                  </tfoot>
              </table>
              </div>
              <div class="col-12 my-2 text-end">
                <button type="button" onclick="addInventory()" class="btn btn-primary btn-sm">Add Inventory</button>
              </div>
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
