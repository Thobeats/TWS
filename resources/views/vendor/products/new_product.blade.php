@extends('layout.vendor_layout')

@section('pagetitle','New Product')

@section('title', 'Vendor - New Product')

@section('content')
<style>
    td select{
        padding: 5px;
        font-size: 12px;
    }

    td input {
        padding: 5px;
        font-size: 12px;
    }
</style>

<section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <div class="mt-3 text-center">
          <span>You can upload</span>
          <a class="ml-3 btn btn-outline-primary btn-sm" href="uploadFile">Upload Products</a>
        </div>
      </div>
    </div>

     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Product</h5>

              <!-- Multi Columns Form -->
              <form
                {{-- method="POST" action="/vendor/products/store" --}}
              class="row mt-3 p-2" id="newProductForm">
              {{-- action="/vendor/products/store"> --}}
                  @csrf

                <div class="row mt-3">
                    <div class="col-lg-12">
                      <div class="has-validation">
                            <label for="cat_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name='name'>
                            <div id="name_error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                   <div class="row col-12">
                    <div class="col-12">
                      <label for="category" class="form-label">Category</label>
                      <select id="category" name='category_id[]' multiple style="width: 100%">
                        {!! $categoryTemp !!}
                      </select>
                        <div id="category_id_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mt-3">
                  <div class="col-lg-6">
                    <label for="tags" class="form-label">Tags</label>
                    <select name='tags[]' class="product-tags" multiple style="width: 100%">
                      @if(!empty($tags))
                          @foreach($tags as $tag)
                          <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                          @endforeach
                      @endif
                    </select>
                      <div id="tags_error" class="invalid-feedback"></div>
                  </div>

                  <div class="col-lg-6">
                    <label for="tag" class="form-label">Product SKU (optional)</label>
                    <input type="text" name="sku" class="form-control">
                      <div id="sku_error" class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-lg-6">
                        <label for="sections" class="form-label">Section</label>
                        <select id="sections" name='sections[]' class="form-select js-example-basic-multiple" multiple style="width: 100%">
                        @if(!empty($sections))
                            @foreach($sections as $section)
                            <option value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                            @endforeach
                        @endif
                      </select>
                      <div id="sections_error" class="invalid-feedback"></div>
                  </div>

                  <div class="col-lg-3 mb-3">
                    <label for="shipping_fee" class="form-label">Shipping Fee</label>
                        <input type="text" id="shipping_fee" name='shipping_fee' class="form-control">
                        <div id="shipping_fee_error" class="invalid-feedback"></div>
                  </div>
                  <div class="col-lg-3 mb-3">
                    <label for="moq" class="form-label">Minimum Order Quantity</label>
                        <input   type="number" id="moq" name='moq' class="form-control">
                        <div id="moq_error" class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-12">
                    <h4>Item Inventory</h4>
                    <hr>
                  </div>

                  <div class="col-12" style="overflow-x:auto">
                    <table class="table table-borderless border">
                     <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col">Colors</th>
                          <th scope="col" colspan="2"></th>
                        </tr>
                      </thead>
                      <tbody id="inventory">
                        <tr>
                          <td></td>
                          <td>
                            <select id="colors" name='colors[]' class="color-select" style="width: 100%">
                              <option value="no_color">No Color</option>
                              @if(!empty($colors))
                                  @foreach($colors as $color)
                                  <option value="{{ $color['id'] }}">{{ $color['name'] }}</option>
                                  @endforeach
                              @endif
                            </select>

                          </td>
                         <td>
                            <table class="table table-borderless">
                                <colgroup>
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 10%;">
                                </colgroup>
                              <thead class="border">
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
                                    <input type="number" name="no_in_stock[0][]"   class="@error('no_in_stock') is-invalid @enderror">
                                  </td>
                                  <td>
                                    <select id="sizes" name='sizes[0][]' class="@error('sizes') is-invalid @enderror" style="width: 100%">
                                        <option value="">Select Size</option>
                                        @if(!empty($sizes))
                                            @foreach($sizes as $size)
                                            <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" name="p_price[0][]" id="">
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

                  {{-- <div >
                    <div class="row mt-2">
                      <div class="col-6">
                        <label for="tag" class="form-label">Colors</label>
                        <select id="colors" name='colors[]'   class="form-select @error('colors') is-invalid @enderror"style="width: 100%">
                          @if(!empty($colors))
                              @foreach($colors as $color)
                              <option value="{{ $color['id'] }}">{{ $color['name'] }}</option>
                              @endforeach
                          @endif
                        </select>
                          <div class="invalid-feedback">
                              @error('colors') {{ $message }} @enderror
                          </div>
                      </div>
                      <div class="col-6">
                        <label for="no_in_stock" class="form-label">No in Stock</label>
                        <input type="number" name="no_in_stock[]"   class="form-control @error('no_in_stock') is-invalid @enderror">
                        <div class="invalid-feedback">
                          @error('no_in_stock') {{ $message }} @enderror
                        </div>
                      </div>
                    </div>
                  </div> --}}

                  <div class="col-12 my-2 text-end">
                    <button type="button" onclick="addInventory()" class="btn btn-primary btn-sm">Add Inventory</button>
                  </div>


                </div>

                <div class="row mt-3">
                  <div class="col-12">
                    <label for="product_description" class="form-label">Description</label>
                    <textarea name='description' rows="15" class="tinymce-editor form-control" id='product_description'></textarea>
                     <div id="description_error" class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <label for="pics" class="form-label">Product Pictures</label>
                        <input id='pics' type="file"   name="pics[]" multiple class="form-control">
                        <div id="pics_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="text-end mt-3">
                  <button name="save" id="submitBtn" type="button" class="btn btn-success">Publish</button>
                  <button name='draft' id="draftBtn" type="button" class="btn btn-primary">Add to Draft</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
     </div>

</section>


<script>
  function addNewRecord(recordID){
    let record = document.getElementById(`record${recordID}`);
    let id = record.children.length;
    let tr = document.createElement('tr');
    tr.setAttribute('id', `record${recordID}${id}`);

    tr.innerHTML = `
    <td>
      <input type="number" name="no_in_stock[${recordID}][]"   class="@error('no_in_stock') is-invalid @enderror">
    </td>
    <td>
      <select id="sizes" name='sizes[${recordID}][]' class="@error('sizes') is-invalid @enderror" style="width: 100%">
        <option value="">Select Size</option>
        @if(!empty($sizes))
            @foreach($sizes as $size)
            <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
            @endforeach
        @endif
      </select>
    </td>
    <td>
        <input type="text" name="p_price[${recordID}][]" id="">
    </td>
    <td scope="row">
      <button class='btn btn-danger btn-sm' onclick="removeRecord(${`record${recordID}${id}`},record${recordID})"><i class='bi bi-trash'></i></button>
    </td>
    `;

    record.appendChild(tr);

  }


  function removeRecord(id,refID){
    refID.removeChild(id);
  }

</script>


@endsection
