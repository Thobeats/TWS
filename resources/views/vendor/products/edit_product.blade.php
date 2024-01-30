@extends('layout.vendor_layout')

@section('pagetitle', 'Edit Product')

@section('title', 'Vendor - Edit Product')

@section('content')

    <style>
        td select {
            padding: 5px;
            font-size: 12px;
        }

        td input {
            padding: 5px;
            font-size: 12px;
        }
        label{
            font-size: 13px;
            font-weight: 600;
        }
        a:active{
            font-size: 13px;
        }
    </style>

    <section class="section dashboard">

        <div class="d-flex justify-content-between mb-3">
            <a href="/vendor/products/" class="btn btn-primary btn-sm">
                <i class="bi bi-backspace"></i> Back to products
            </a>
            @if ($product->hasVariant == true)
                <a href="{{"/vendor/products/editVariant/$product->id?lctn=rteslctn"}}" class="btn btn-primary btn-sm">Edit Variants <i class="bi bi-backspace-reverse"></i></a>
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit {{ $product->name }}</h5>
            </div>
        </div>
        <!-- Multi Columns Form -->
        <form id="editProduct" class="row g-3" {{-- method="POST" action="/vendor/products/update" --}}>
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="has-validation">
                                <label for="cat_name"  >Product Name</label>
                                <input type="text" class="form-control" id="name" name='name'
                                    value="{{ $product->name }}">
                                <div id="name_error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="row col-12">
                            <div class="col-12">
                                <label for="category"  >Category</label>
                                <select id="category" name='category_id[]'
                                    class="@error('category_id') is-invalid @enderror" multiple style="width: 100%">
                                    {!! $categoryTemp !!}
                                </select>
                                <div id="category_id_error" class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <label for="tags"  >Tags</label>
                                <select id="tags" name='tags[]'
                                    class="form-select @error('tags') is-invalid @enderror js-example-basic-multiple"
                                    multiple style="width: 100%">
                                    @if (!empty($tags))
                                        @foreach ($tags as $tag)
                                            <option {{ in_array($tag['id'], $product_tags) ? 'selected' : '' }}
                                                value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="tags_error" class="invalid-feedback"></div>
                            </div>

                            <div class="col-lg-6">
                                <label for="tag"  >Product SKU (optional)</label>
                                <input value="{{ $product->sku }}" type="text" name="sku"
                                    class="form-control @error('sku') is-invalid @enderror">
                                <div id="sku_error" class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <label for="sections"  >Section</label>
                                <select id="sections" name='sections[]'
                                    class="form-select @error('sections') is-invalid @enderror js-example-basic-multiple"
                                    multiple style="width: 100%">
                                    @if (!empty($sections))
                                        @foreach ($sections as $section)
                                            <option
                                                {{ $product->section_id && in_array($section['id'], $product_sections) ? 'selected' : '' }}
                                                value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="sections_error" class="invalid-feedback"></div>
                            </div>

                            <div class="col-lg-3 mb-3">
                                <label for="shipping_fee"  >Shipping Fee</label>
                                <input required type="number" value="{{ $product->shipping_fee }}" id="shipping_fee"
                                    name='shipping_fee' class="form-control @error('shipping_fee') is-invalid @enderror">
                                <div id="shipping_fee_error" class="invalid-feedback"></div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="moq"  >Minimum Order Quantity</label>
                                <input required type="number" value="{{ $product->moq }}" id="moq" name='moq'
                                    class="form-control @error('moq') is-invalid @enderror">
                                <div id="moq_error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="product_description"  >Description</label>
                            <textarea name='description' rows="15"
                                class="tinymce-editor form-control @error('description') is-invalid @enderror" id='product_description'>{{ $product->description }}</textarea>
                            <div id="description_error" class="invalid-feedback"></div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($product->hasVariant == false)
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label for="pics">Price Per Item</label>
                                <input type="number" value="{{$product->price}}" name="price" class="form-control">
                                <div id="pics_error" class="invalid-feedback"></div>
                            </div>
                        </div>
                    @endif
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <label for="pics">Display Pictures</label>
                        <input id='pics' type="file" name="pics[]" multiple class="form-control">
                    </div>
                    <div id="pics_error" class="invalid-feedback"></div>
                </div>

                <div class="text-end mt-3">
                    <button name="save" id="editsubmitBtn" type="button"
                        class="btn btn-success">Publish</button>
                    <button name='draft' id="editdraftBtn" type="button" class="btn btn-primary">Add to
                        Draft</button>
                </div>
                </div>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>

    <script>
        function getCategory(e, step = 1) {
            const id = e.target.value;

            fetch(`/api/getCategory/${id}`, {
                    method: "GET"
                }).then(res => res.json())
                .then(json => {
                    let subcategories = document.querySelector(".subcatwrapper");
                    let subsubcategories = document.querySelector(".subsubcatwrapper");
                    if (json.length > 0) {
                        // create new form element

                        if (step == 1) {
                            if (subcategories.classList.contains('d-none')) {
                                subcategories.classList.remove('d-none');
                            }

                            if (!subsubcategories.classList.contains('d-none')) {
                                subsubcategories.classList.add('d-none');
                            }
                            let subcat = document.querySelector("#subcategory");
                            let options = "<option>Select</option>";
                            for (let i in json) {
                                options += `<option value="${json[i].id}">${json[i].name}</option>`;
                            }

                            subcat.innerHTML = options;

                        } else if (step == 2) {
                            if (subsubcategories.classList.contains('d-none')) {
                                subsubcategories.classList.remove('d-none');
                            }

                            let subcat = document.querySelector("#subsubcategory");
                            let options = "<option>Select</option>";

                            for (let i in json) {
                                options += `<option value="${json[i].id}">${json[i].name}</option>`;
                            }

                            subcat.innerHTML = options;
                        }

                    } else {
                        if (step == 1) {
                            if (!subsubcategories.classList.contains('d-none')) {
                                subsubcategories.classList.add('d-none');
                            }

                            if (!subcategories.classList.contains('d-none')) {
                                subcategories.classList.add('d-none');
                            }

                        } else if (step == 2) {
                            if (!subsubcategories.classList.contains('d-none')) {
                                subsubcategories.classList.add('d-none');
                            }
                        }

                    }
                });
        }

        //   function addInventory(){
        //     let inventory = document.getElementById('inventory');

        //     let id = inventory.children.length;

        //     let row = document.createElement('tr');
        //     row.setAttribute('id',id);
        //     row.innerHTML = `
    //         <td scope="row">
    //           <button class='btn btn-danger btn-sm' type='button' onclick="removeInventory(${id})"><i class='bi bi-trash'></i></button>
    //         </td>
    //         <td>
    //           <select id="colors" name='colors[]' required class="@error('colors') is-invalid @enderror"style="width: 100%">
    //             <option value="">Select Color</option>
    //             @if (!empty($colors))
    //                 @foreach ($colors as $color)
    //                 <option value="{{ $color['id'] }}">{{ $color['name'] }}</option>
    //                 @endforeach
    //             @endif
    //           </select>
    //         </td>
    //         <td>
    //           <table class="table table-bordered">
    //             <colgroup>
    //                 <col span="1" style="width: 30%;">
    //                 <col span="1" style="width: 30%;">
    //                 <col span="1" style="width: 30%;">
    //                 <col span="1" style="width: 10%;">
    //             </colgroup>
    //             <thead>
    //               <tr>
    //                 <th>no in stock</th>
    //                 <th>Size</th>
    //                 <th>Price</th>
    //                 <th>Action</th>
    //               </tr>
    //             </thead>
    //             <tbody id="record${id}">
    //               <tr>
    //                 <td>
    //                   <input type="number" name="no_in_stock[${id}][]" required class="@error('no_in_stock') is-invalid @enderror">
    //                 </td>
    //                 <td>
    //                   <select id="sizes" name='sizes[${id}][]' class="@error('sizes') is-invalid @enderror" style="width: 100%">
    //                     <option value="">Select Size</option>
    //                     @if (!empty($sizes))
    //                         @foreach ($sizes as $size)
    //                         <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
    //                         @endforeach
    //                     @endif
    //                   </select>
    //                 </td>
    //                 <td>
    //                     <input type="text" name="p_price[${id}][]" id="">
    //                 </td>
    //                 <td></td>
    //               </tr>
    //             </tbody>
    //             <tfoot>
    //               <tr>
    //                 <th colspan="4" class="text-end">
    //                   <button type="button" onclick="addNewRecord(${id})" class="btn btn-primary btn-sm">
    //                     <i class="bi bi-plus-circle-fill"></i> Add
    //                   </button>
    //                 </th>
    //               </tr>
    //             </tfoot>
    //           </table>
    //         </td>
    //     `;

        //     inventory.appendChild(row);
        //   }

        //   function removeInventory(id){
        //     let inventory = document.getElementById('inventory');
        //     inventory.removeChild(inventory.children.namedItem(`${id}`));
        //   }

        function addNewRecord(recordID) {
            let record = document.getElementById(`record${recordID}`);
            let id = record.children.length;
            let tr = document.createElement('tr');
            tr.setAttribute('id', `record${recordID}${id}`);

            tr.innerHTML = `
    <td>
      <input type="number" name="no_in_stock[${recordID}][]" required class="@error('no_in_stock') is-invalid @enderror">
    </td>
    <td>
      <select id="sizes" name='sizes[${recordID}][]' class="@error('sizes') is-invalid @enderror" style="width: 100%">
        <option value="">Select Size</option>
        @if (!empty($sizes))
            @foreach ($sizes as $size)
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

        function removeRecord(id, refID) {
            refID.removeChild(id);
        }
    </script>

@endsection
