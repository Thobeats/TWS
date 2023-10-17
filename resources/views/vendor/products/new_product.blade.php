@extends('layout.vendor_layout')

@section('pagetitle','New Product')

@section('title', 'Vendor - New Product')

@section('content')

<section class="section dashboard">
     <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Product</h5>

              <!-- Multi Columns Form -->
              <form class="row mt-3 p-2" method="POST" action="/vendor/products/store">
                  @csrf

                <div class="row mt-3">
                    <div class="col-lg-6">
                      <div class="has-validation">
                            <label for="cat_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name='name' >
                            <div class="invalid-feedback">
                              @error('name') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                          <label for="price" class="form-label">Price</label>
                          <input type="number" name="price" class="form-control @error('price') is-invalid @enderror">
                          <div class="invalid-feedback">
                            @error('price') {{ $message }} @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                   <div class="row col-12 categories">
                    <div class="col-md-4">
                      <label for="category" class="form-label">Category</label>
                      <select id="category" name='category_id[]' class="form-select @error('category_id') is-invalid @enderror" onchange="getCategory(event)">
                        <option value="">Select Category</option>
                       @forelse ($categories as $category)
                         <option value="{{$category['id']}}">{{ $category['name'] }}</option>
                       @empty
                       @endforelse
                      </select>
                        <div class="invalid-feedback">
                            @error('category_id') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="col-md-4 d-none subcatwrapper">
                      <label for="category" id="sub_cat" class="form-label">Sub Category</label>
                      <select id="subcategory" name='category_id[]' class="form-select @error('category_id') is-invalid @enderror" onchange="getCategory(event, 2)">
                      
                      </select>
                    </div>
                    <div class="col-md-4 d-none subsubcatwrapper">
                      <label for="category" id="sub_cat" class="form-label">Sub Category</label>
                      <select id="subsubcategory" name='category_id[]' class="form-select @error('category_id') is-invalid @enderror">
                      </select>
                    </div> 
                   </div>
                </div>

                <div class="row mt-3">
                  <div class="col-lg-6">
                    <label for="tags" class="form-label">Tags</label>
                    <select id="tags" name='tags[]' class="form-select @error('tags') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                      @if(!empty($tags))
                          @foreach($tags as $tag)
                          <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                          @endforeach
                      @endif
                    </select>
                      <div class="invalid-feedback">
                          @error('tags') {{ $message }} @enderror
                      </div>
                  </div>

                  <div class="col-lg-6">
                    <label for="tag" class="form-label">Product SKU (optional)</label>
                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror">
                      <div class="invalid-feedback">
                          @error('sku') {{ $message }} @enderror
                      </div>
                  </div>

                  {{-- <div class="col-lg-6">
                    <label for="tag" class="form-label">Sizes</label>
                   
                      <div class="invalid-feedback">
                          @error('sizes') {{ $message }} @enderror
                      </div>
                  </div> --}}
                </div>

                <div class="row mt-3">
                  <div class="col-lg-6">
                        <label for="sections" class="form-label">Section</label>
                        <select id="sections" name='sections[]' class="form-select @error('sections') is-invalid @enderror js-example-basic-multiple" multiple style="width: 100%">
                        @if(!empty($sections))
                            @foreach($sections as $section)
                            <option value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                            @endforeach
                        @endif
                      </select>
                      <div class="invalid-feedback">
                        @error('sections') {{ $message }} @enderror
                    </div>
                  </div>

                  <div class="col-lg-6 mb-3">
                    <label for="shipping_fee" class="form-label">Shipping Fee</label>
                        <input required type="number" id="shipping_fee" name='shipping_fee' class="form-control @error('shipping_fee') is-invalid @enderror">
                        <div class="invalid-feedback">
                            @error('shipping_fee') {{ $message }} @enderror
                        </div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-12">
                    <h4>Item Inventory</h4>
                  </div>

                  <div class="col-12">
                    <table class="table table-bordered">
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
                            <select id="colors" name='colors[]' required class="form-select @error('colors') is-invalid @enderror"style="width: 100%">
                              <option value="">Select Color</option>
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
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody id="record0">
                                <tr>
                                  <td>
                                    <input type="number" name="no_in_stock[0][]" required class="form-control @error('no_in_stock') is-invalid @enderror">
                                  </td>
                                  <td>
                                    <select id="sizes" name='sizes[0][]' class="form-select @error('sizes') is-invalid @enderror" style="width: 100%">
                                      <option value="">Select Size</option>
                                      @if(!empty($sizes))
                                          @foreach($sizes as $size)
                                          <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
                                          @endforeach
                                      @endif
                                    </select>
                                  </td>
                                  <td></td>
                                </tr>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th colspan="3" class="text-end">
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
                  </div>

                  {{-- <div >
                    <div class="row mt-2">
                      <div class="col-6">
                        <label for="tag" class="form-label">Colors</label>
                        <select id="colors" name='colors[]' required class="form-select @error('colors') is-invalid @enderror"style="width: 100%">
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
                        <input type="number" name="no_in_stock[]" required class="form-control @error('no_in_stock') is-invalid @enderror">
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
                    <textarea name='description' rows="15" class="tinymce-editor form-control @error('description') is-invalid @enderror" id='product_description'></textarea>
                     <div class="invalid-feedback">
                          @error('description') {{ $message }} @enderror
                      </div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-lg-12">
                        <label for="pics" class="form-label">Product Pictures</label>
                        <input id='pics' type="file" name="pics[]" multiple class="form-control @error('pics') is-invalid @enderror">
                  </div>
                </div>

                <div class="text-end mt-3">
                  <button type="submit" name="save" class="btn btn-success">Publish</button>
                  <button name='draft' type="submit" class="btn btn-primary">Add to Draft</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
</section>


<script>
  function getCategory(e,step=1){
    const id = e.target.value;

    fetch(`/api/getCategory/${id}`, {
            method: "GET"
          }).then(res => res.json())
            .then(json => {
              let subcategories = document.querySelector(".subcatwrapper");
              let subsubcategories = document.querySelector(".subsubcatwrapper");
                if(json.length > 0){
                  // create new form element
          
                  if(step == 1){
                    if(subcategories.classList.contains('d-none')){
                      subcategories.classList.remove('d-none');
                    }
                    
                    if(!subsubcategories.classList.contains('d-none')){
                      subsubcategories.classList.add('d-none');
                    }
                    let subcat = document.querySelector("#subcategory");
                    let options = "<option>Select</option>";
                    for(let i in json){
                      options += `<option value="${json[i].id}">${json[i].name}</option>`;
                    }

                    subcat.innerHTML = options;

                  }else if(step == 2){
                    if(subsubcategories.classList.contains('d-none')){
                      subsubcategories.classList.remove('d-none');
                    }
                  
                    let subcat = document.querySelector("#subsubcategory");
                    let options = "<option>Select</option>";

                    for(let i in json){
                      options += `<option value="${json[i].id}">${json[i].name}</option>`;
                    }

                    subcat.innerHTML = options;
                  }

                }else{
                  if(step == 1){
                    if(!subsubcategories.classList.contains('d-none')){
                      subsubcategories.classList.add('d-none');
                  }

                  if(!subcategories.classList.contains('d-none')){
                      subcategories.classList.add('d-none');
                    }

                  }else if(step == 2){
                    if(!subsubcategories.classList.contains('d-none')){
                      subsubcategories.classList.add('d-none');
                  }
                  }
                 
                }
            });
  }

  function addInventory(){
    let inventory = document.getElementById('inventory');

    let id = inventory.children.length;

    let row = document.createElement('tr');
    row.setAttribute('id',id);
    row.innerHTML = `
        <td scope="row">
          <button class='btn btn-danger btn-sm' type='button' onclick="removeInventory(${id})"><i class='bi bi-trash'></i></button>
        </td>
        <td>
          <select id="colors" name='colors[]' required class="form-select @error('colors') is-invalid @enderror"style="width: 100%">
            <option value="">Select Color</option>
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
                <th></th>
              </tr>
            </thead>
            <tbody id="record${id}">
              <tr>
                <td>
                  <input type="number" name="no_in_stock[${id}][]" required class="form-control @error('no_in_stock') is-invalid @enderror">
                </td>
                <td>
                  <select id="sizes" name='sizes[${id}][]' class="form-select @error('sizes') is-invalid @enderror" style="width: 100%">
                    <option value="">Select Size</option>
                    @if(!empty($sizes))
                        @foreach($sizes as $size)
                        <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
                        @endforeach
                    @endif
                  </select>
                </td>
                <td></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3" class="text-end">
                  <button type="button" onclick="addNewRecord(${id})" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle-fill"></i> Add
                  </button>
                </th>
              </tr>
            </tfoot>
          </table>
        </td>
    `;

    inventory.appendChild(row);
  }

  function removeInventory(id){
    let inventory = document.getElementById('inventory');
    inventory.removeChild(inventory.children.namedItem(`${id}`));
  }

  function addNewRecord(recordID){
    let record = document.getElementById(`record${recordID}`);
    let id = record.children.length;
    let tr = document.createElement('tr');
    tr.setAttribute('id', `record${recordID}${id}`);

    tr.innerHTML = `
    <td>
      <input type="number" name="no_in_stock[${recordID}][]" required class="form-control @error('no_in_stock') is-invalid @enderror">
    </td>
    <td>
      <select id="sizes" name='sizes[${recordID}][]' class="form-select @error('sizes') is-invalid @enderror" style="width: 100%">
        <option value="">Select Size</option>
        @if(!empty($sizes))
            @foreach($sizes as $size)
            <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
            @endforeach
        @endif
      </select>
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
