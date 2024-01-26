<div >
    @if ($page == 'new_product')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Product</h5>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mt-3 text-center">
                    <span>You can upload a csv file</span>
                    <a class="ml-3 btn btn-outline-primary btn-sm" href="uploadFile">Upload Products</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="has-validation">
                            <label for="cat_name" class="form-label">Product Name </label>
                            <input type="text" class="form-control" wire:model="product.productName">
                            @if ($myErrorBag != null && array_key_exists('product.productName', $myErrorBag))
                                <div class="d-block invalid-feedback">
                                    {{ $myErrorBag['product.productName'][0] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-12">
                        <div wire:ignore>
                            <label for="category" class="form-label">Category</label>
                            <select id="category" class='form-select' wire:model="product.category" multiple
                                style="width: 100%">
                                {!! $categoryTemp !!}
                            </select>
                        </div>
                        @if ($myErrorBag != null && array_key_exists('product.category', $myErrorBag))
                        <div class="d-block invalid-feedback">
                            {{ $myErrorBag['product.category'][0] }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div wire:ignore>
                            <label for="tags" class="form-label">Tags</label>
                            <select name='tags[]' wire:model="product.tags" class="product-tags form-select" multiple
                                style="width: 100%">
                                @if (!empty($tags))
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($myErrorBag != null && array_key_exists('product.tags', $myErrorBag))
                        <div class="d-block invalid-feedback">
                            {{ $myErrorBag['product.tags'][0] }}
                        </div>
                        @endif
                    </div>

                    <div class="col-lg-6">
                        <label for="tag" class="form-label">Product SKU (optional)</label>
                        <input type="text" name="sku" class="form-control" wire:model="product.sku">
                        @if ($myErrorBag != null && array_key_exists('product.sku', $myErrorBag))
                        <div class="d-block invalid-feedback">
                            {{ $myErrorBag['product.sku'][0] }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div wire:ignore>
                            <label for="sections" class="form-label">Section</label>
                            <select id="sections" wire:model="product.section"
                                class="form-select product_section" multiple style="width: 100%">
                                @if (!empty($sections))
                                    @foreach ($sections as $section)
                                        <option value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @if ($myErrorBag != null && array_key_exists('product.sections', $myErrorBag))
                        <div class="d-block invalid-feedback">
                            {{ $myErrorBag['product.sections'][0] }}
                        </div>
                        @endif
                    </div>

                    <div class="col-lg-3 mb-3">
                        <label for="shipping_fee" class="form-label">Shipping Fee</label>
                        <input type="text" id="shipping_fee" wire:model="product.shipping_fee" name='shipping_fee'
                            class="form-control">
                        @if ($myErrorBag != null && array_key_exists('product.shipping_fee', $myErrorBag))
                            <div class="d-block invalid-feedback">
                                {{ $myErrorBag['product.shipping_fee'][0] }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label for="moq" class="form-label">Minimum Order Quantity</label>
                        <input type="number" id="moq" name='moq' wire:model="product.moq"
                            class="form-control">
                        @if ($myErrorBag != null && array_key_exists('product.moq', $myErrorBag))
                        <div class="d-block invalid-feedback">
                            {{ $myErrorBag['product.moq'][0] }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-12">
                        <div wire:ignore>
                            <label for="product_description" class="form-label">Description</label>
                            <textarea name='description' rows="15" class="tinymce-editor form-control" wire:model="product.description"
                                id='product_description'></textarea>
                        </div>
                        @if ($myErrorBag != null && array_key_exists('product.description', $myErrorBag))
                            <div class="d-block invalid-feedback">
                                {{ $myErrorBag['product.description'][0] }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"  {{ $hasVariant == true ? 'checked' : '' }} wire:click='switchVariant'>
                <label class="form-check-label" for="flexSwitchCheckChecked">{{ $hasVariant == false ? 'variants off' : 'variants on' }}</label>
            </div>
        </div>

        @if ($hasVariant == true)
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5 class='card-title'>Variants</h5>
                        </div>

                        <div class="col-12" wire:ignore>
                            <div class="p-3 my-3 border">
                                <div id="variants-form" class='mb-2'>

                                </div>
                                <div class="form-group text-end">
                                    <button type="button" onclick="addNewVariant()" class="btn btn-dark btn-sm">
                                        <i class="bi bi-plus-circle-fill"></i> Add Variant
                                    </button>
                                </div>
                            </div>
                        </div>


                        @if ($tableTemplate != "")
                            <div class="col-12" style="overflow-x:auto">
                                <div class='p-2'>
                                    <table class="table table-borderless" id='table-variant'>
                                        <colgroup>
                                            <col span="1" style="width: 20%;">
                                            <col span="1" style="width: 20%;">
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
                                                <th>images</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="variant-table">
                                            @foreach ($tableTemplate as $index => $tableTemp)
                                                <tr>
                                                    <td>
                                                        {{ implode("/", $tableTemp) }}

                                                    </td>
                                                    <td>
                                                        <input type="number" wire:model='variants.{{$index}}.no_in_stock'>
                                                    </td>
                                                    <td>
                                                        <input type="number" wire:model='variants.{{$index}}.purchase_limit'>
                                                    </td>
                                                    <td>
                                                        <input type="number" wire:model='variants.{{$index}}.price'>
                                                    </td>
                                                    <td>
                                                        <input type="number" wire:model='variants.{{$index}}.imagesCount'>
                                                    </td>
                                                    <td>
                                                        <input class='d-none' type="file" multiple wire:model='variants.{{$index}}.images' id="{{$index}}upload">
                                                        <label for="{{$index}}upload" class='btn btn-primary btn-sm'>Upload</label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        {{-- <div class="col-12" style="overflow-x:auto">
                            <table class="table table-borderless border">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Colors (optional)</th>
                                        <th scope="col" colspan="2"></th>
                                    </tr>
                                </thead>
                                <tbody id="inventory">
                                    <tr>
                                        <td></td>
                                        <td>

                                            <div class="form-group">
                                                <select id="colors" name='colors[]' class="color-select form-select p-2">
                                                    <option value="no_color">No Color</option>
                                                    @if (!empty($colors))
                                                    @foreach ($colors as $color)
                                                    <option value="{{ $color['id'] }}">{{ $color['name'] }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>

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
                                                            <input type="number" name="no_in_stock[0][]"
                                                                class="@error('no_in_stock') is-invalid @enderror">
                                                        </td>
                                                        <td>
                                                            <select id="sizes" name='sizes[0][]'
                                                                class="@error('sizes') is-invalid @enderror"
                                                                style="width: 100%">
                                                                <option value="">Select Size</option>
                                                                @if (!empty($sizes))
                                                                @foreach ($sizes as $size)
                                                                <option value="{{ $size['id'] }}">{{ $size['size_code'] }}
                                                                </option>
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
                                                            <button type="button" onclick="addNewRecord(0)"
                                                                class="btn btn-primary btn-sm">
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

                        <div class="col-12 my-2 text-end">
                            <button type="button" onclick="addInventory()" class="btn btn-primary btn-sm">Add Inventory</button>
                        </div> --}}


                    </div>
                </div>
            </div>
        @endif

        @if ($hasVariant == false)

            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="has-validation">
                                <label for="cat_name" class="form-label">Product Price </label>
                                <input type="number" class="form-control" wire:model="price">
                                @if ($myErrorBag != null && array_key_exists('price', $myErrorBag))
                                    <div class="d-block invalid-feedback">
                                        {{ $myErrorBag['price'][0] }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            {{-- <div wire:ignore>
                                <label for="pics" class="form-label">Product Pictures</label>
                                <input id='pics' type="file" wire:model="product.pics" name="pics[]"
                                    multiple class="form-control">
                            </div> --}}
                            <div class="form-group">
                                <label>Product Pictures</label>
                                <input id="uploadPicture" class="d-none" type="file" wire:model='pictures'>
                            </div>
                            <div class='mt-3 row'>
                               @if($uploadedPictures != [])
                                    @foreach ($uploadedPictures as $index => $pic)
                                        <div class="col-2">
                                            <div class="img-con">
                                                <img src="{{url('storage' . $pic)}}" alt="" height="150px" class="img-fluid">
                                            </div>
                                            <div class="text-danger mt-2">
                                                <span wire:click='removeImg({{$index}})'><i class="bi bi-trash3"></i></span>
                                            </div>
                                        </div>
                                    @endforeach
                               @endif
                                <div class="col-3">
                                    <label for="uploadPicture" style="font-size:50px; cursor: pointer;" class="border p-5 text-secondary">
                                        <i class="bi bi-plus-lg"></i>
                                    </label>
                                </div>
                            </div>
                            <div wire:loading wire:target="pictures">Uploading...</div>
                            @if ($myErrorBag != null && array_key_exists('pictures', $myErrorBag))
                                <div id="pics_error" class="invalid-feedback d-block">{{ $myErrorBag['pictures'][0] }}</div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endif



        <div class="card">
            <div class="card-body">
                <div class="text-end mt-3">
                    <button wire:click='publishProduct' type="button" class="btn btn-success">Publish</button>
                    <button wire:click="saveToDraft" type="button" class="btn btn-primary">Add to Draft</button>
                </div>
            </div>
        </div>
    @endif
    </form>
</div>
