<!DOCTYPE html>
<html lang="en">
@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="Vendors selling products" name="description">
  <meta content="products wholesale new shoe" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Work+Sans:wght@100;200;300;400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" integrity="sha512-arEjGlJIdHpZzNfZD2IidQjDZ+QY9r4VFJIm2M/DhXLjvvPyXFj+cIotmo0DLgvL3/DOlIaEDwzEiClEPQaAFQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" integrity="sha512-uyGg6dZr3cE1PxtKOCGqKGTiZybe5iSq3LsqOolABqAWlIRLo/HKyrMMD8drX+gls3twJdpYX0gDKEdtf2dpmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  {{-- FilePond --}}
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link
        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet"
    />
    <link
        href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css"
        rel="stylesheet"
    />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" integrity="sha512-uyGg6dZr3cE1PxtKOCGqKGTiZybe5iSq3LsqOolABqAWlIRLo/HKyrMMD8drX+gls3twJdpYX0gDKEdtf2dpmw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput-rtl.min.css">
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  {{-- <link href="{{ asset('css/main.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('css/bs5-intro-tour.css')}}" rel="stylesheet" />

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>

    <style>
        .select2-container--default .select2-selection--multiple{
            border-color: #dee2e6;
        }
        .home-input{
            padding: 5px;
            border:1px solid #ccc;
            outline: none;
            width: 100%;
            border-radius: 10px;
        }
    </style>

 <script>

    tinymce.init({
        selector: "textarea#product_description",
        theme: "modern",
        height: 500,
        plugins: [
            "advlist autolink link lists charmap preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
            "table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink| preview fullpage | forecolor backcolor emoticons",
    });

    const socket = new WebSocket("ws://localhost:8080?userID={{ $user->id }}");

    socket.onmessage = (event) => {
        let data = JSON.parse(event.data);
        Livewire.emit('incoming-message', event.data);
    };
  </script>
@livewireStyles
</head>

<body>
  <!-- ======= Header ======= -->
  @include('layout.vendor_header')

  <!-- ======= Sidebar ======= -->
 @include('layout.vendor_sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>@yield('pagetitle')</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/vendor/dashboard">Home</a></li>
          <li class="breadcrumb-item active">@yield('pagetitle')</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  @include('layout.vendor_footer')
  <script src="{{ asset('js/crs.min.js') }}"></script>
  <script src="{{ asset('js/bs5-intro-tour.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
  @include('layout.filepond')
@livewireScripts


<script>
        // Get a file input reference
        const pics = document.querySelector('#pics');
        const business = document.querySelector('#business');
         $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('.color-select').select2({
                tags : true
            });

            $('.product-tags').select2({
                tags : true
            });

            $('#category').select2();

            const steps = [
                {
                    title: "Hello",
                    content: "<p> Welcome to The Wholesale Lounge, Let's show you around</p>"
                }, {
                    id: "first",
                    title: "Products",
                    content: "<p>Add new products and view all added products</p>"
                },{
                    id: "second",
                    title: "Orders",
                    content: "<p>View all orders from customers</p>"
                }
            ];

            const tour = new Tour(steps);

            document.getElementById('take-a-tour').addEventListener('click', function(){
                tour.show();
            });
        });


        //Register FilePond functions
        FilePond.registerPlugin(
          FilePondPluginImagePreview,
          FilePondPluginFileValidateSize,
          FilePondPluginFileValidateType
        );

        // Create a FilePond instance
        FilePond.create(pics, {
            storeAsFile: true,
            acceptedFileTypes: ['image/png','image/jpg','image/jpeg'],
            allowImageValidateSize: true,
            imagePreviewHeight: 170,
            maxFileSize : "3mb",
            maxFiles : 3,
          //  required : true,
            files : [
            <?php
            if(isset($images)):
                foreach($images as $image){
            ?>
                {
                    source : "/storage/products/{{$image}}"
                },
            <?php } endif; ?>
            ],
            labelMaxFileSize: "Maximum file size is {filesize}",
            server : {
                process : "/api/saveImage/products",
                revert : (fileName)=>{
                    fetch(`/api/deleteImage/products?fileName=${fileName}`, {
                          method: "DELETE"
                        }).then(res => res.text())
                          .then(text => {
                              console.log(text)
                          });
                },
                headers:{
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                }
            }
        });

        var elems = Array.prototype.slice.call(document.querySelectorAll('input[type="checkbox"]'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html,{size: 'small'});
        });

        $('#category').on('select2:select', function(e){
            let selected = $("#category").select2('data');
            let mapped = selected.map(function(item){
                            return item.id;
                        });
            if (e.params.data.element.dataset.parent)
            {
                let parentId = e.params.data.element.dataset.parent;
                let parentName = e.params.data.element.dataset.parentname;
                if (!mapped.includes(parentId)){
                    var newOption = new Option(parentName, parentId, true, true);
                    $('#category').append(newOption).trigger('change');
                }
            }
        });

        // Handle New Product Form
        var action;
        function validationHandler(target, value){
            let input = document.getElementById(`${target}_error`);
            for (c in value){
                input.innerHTML +=  `<span class='text-danger'>${value[c]}</span> <br><br>`;
            }

            input.style.display = 'block';
        }
        $("#submitBtn").on('click', function(){
            action = "&save=1";
            $("#newProductForm").submit();
        });
        $("#draftBtn").on('click', function(){
            action = "";
            $("#newProductForm").submit();
        });

        $("#editsubmitBtn").on('click', function(){
            action = "&save=1";
            $("#editProduct").submit();
        });
        $("#editdraftBtn").on('click', function(){
            action = "";
            $("#editProduct").submit();
        });

        $("#newProductForm").on('submit',(e)=>{
            e.preventDefault();
            tinymce.triggerSave();
            let formData = $("#newProductForm").serialize();
            formData += action;
            fetch("{{ url('/vendor/products/store') }}", {
                method : "POST",
                headers : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
                },
                body : formData
            })
            .then(response => response.json())
            .then(json => {
                console.log(json)
                return;
               $(".invalid-feedback").html('');

                if (json.code == 2){
                    // Validation Error
                    for(x in json.body){
                        let inputError = x.split(".");
                        validationHandler(inputError[0], json.body[x]);
                    }
                }

                if (json.code == 1){
                    alert(json.body);
                }

                if (json.code == 0 && json.type == 'draft'){
                    location.href = '/vendor/products/drafts';
                }

                if (json.code == 0 && json.type == 'published'){
                    location.href = '/vendor/products';
                }
            });
        });

        $("#editProduct").on('submit',(e)=>{
            e.preventDefault();
            tinymce.triggerSave();
            let formData = $("#editProduct").serialize();
            formData += action;

            fetch("{{ url('/vendor/products/update') }}", {
                method : "PUT",
                headers : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
                },
                body : formData
            })
            .then(response => response.json())
            .then(json => {
               $(".invalid-feedback").html('');

                if (json.code == 2){
                    // Validation Error
                    for(x in json.body){
                        let inputError = x.split(".");
                        validationHandler(inputError[0], json.body[x]);
                    }
                }

                if (json.code == 1){
                    alert(json.body);
                }

                if (json.code == 0 && json.type == 'draft'){
                    location.href = '/vendor/products/drafts';
                }

                if (json.code == 0 && json.type == 'published'){
                    location.href = '/vendor/products';
                }
            });
        });

</script>

<script>
    var variantListings = [];
    var selectedVariants = [];

    function addNewVariant(){
        let variantForm = document.getElementById('variants-form');
        let id = variantForm.children.length;
        let newVariantRecord = document.createElement('div');
        newVariantRecord.setAttribute('id', 'record'+id);
        let variants = {!! $variants !!}
        let variant_temp = '';
        for(i in variants){
            let slct = Object.values(selectedVariants).includes(variants[i]['name']) ? 'disabled' : '';
            variant_temp += `
            <option value='${variants[i]['id']}' data-value='${variants[i]['name']}' ${slct} data-placeholder='${variants[i]['placeholder']}'>${variants[i]['name']}</option>
            `;
        }

        newVariantRecord.innerHTML = `
            <div class='form-group mb-4' style='font-size:12px !important;'>
                <div class='border my-2 p-2'>
                    <div class='text-end'>
                        <span class='text-danger' onclick='removeParentRecord("record${id}", "variants-form")' style='font-size:14px;cursor:pointer;'>
                            <i class="bi bi-dash-circle"></i>
                        </span>
                    </div>
                    <select id="variants${id}" name='variant[${id}][]' style="width: 400px" class='p-2' onchange='createVariantValue(event, ${id})'>
                        <option value="">Select Variant</option>
                        ${variant_temp}
                    </select>

                    <table style='width: 400px' class='table table-borderless'>
                        <colgroup>
                            <col span="1" style="width: 85%;">
                            <col span="1" style="width: 15%;">
                        </colgroup>
                        <tbody id='variant-value${id}'>
                        </tbody>
                    </table>
                </div>
                <div id='add-variant-value${id}' class='text-end'>
                </div>
            </div>
        `;
        variantForm.appendChild(newVariantRecord);
    }

    function createVariantValue(event,id){
        let selectedIndex = event.target.selectedIndex;
        let selectedOption = event.target.options[selectedIndex];
        let placeHolder = selectedOption.dataset.placeholder;
        let selectedValue = selectedOption.dataset.value;
        let variantValueContainer = document.getElementById("variant-value"+id);
        variantValueContainer.innerHTML = '';
        let valueId = variantValueContainer.children.length;
        let newValueRecord = document.createElement('tr');
        newValueRecord.setAttribute('id',`${event.target.value}_${valueId}`)
        newValueRecord.innerHTML = `
            <td>
                <input type='text' name='variantValue[${event.target.value}][]' class='home-input inputClass${id}' placeholder='${placeHolder}'>
            </td>
            <td style='vertical-align:middle;'>
                <span class='text-danger' onclick='removeRecord("${event.target.value}_${valueId}", "variant-value${id}")' style='font-size:15px; cursor:pointer;'>
                    <i class="bi bi-dash-circle"></i>
                </span>
            </td>
        `;


        if(Object.values(selectedVariants).includes(selectedOption.dataset.value))
        {
            alert(`${selectedOption.dataset.value} is selected`);
            return;
        }

        selectedVariants[`record${id}`] = selectedOption.dataset.value;
        variantValueContainer.appendChild(newValueRecord);
        document.getElementById('add-variant-value'+id).innerHTML = `
            <button type="button" onclick="saveVariantValue('${id}', '${selectedValue}', 'inputClass${id}')" class="btn btn-success btn-sm" style='font-size:10px'>
                <i class="bi bi-check-circle"></i> Done
            </button>
            <button type="button" onclick="addVariantValue('${event.target.value}', '${id}', '${placeHolder}')" class="btn btn-primary btn-sm me-1" style='font-size:10px'>
                <i class="bi bi-plus-circle-fill"></i> Add Value
            </button>
        `;
    }

    function addVariantValue(type, id, placeholder){
        let variantValueContainer = document.getElementById("variant-value"+id);
        let valueId = variantValueContainer.children.length;
        let newValueRecord = document.createElement('tr');
        newValueRecord.setAttribute('id',`${type}_${valueId}`)
        newValueRecord.innerHTML = `
            <td>
                <input type='text' name='variantValue${type}[]' class='home-input inputClass${id}' placeholder='${placeholder}'>
            </td>
            <td style='vertical-align:middle;'>
                <span onclick='removeRecord("${type}_${valueId}", "variant-value${id}")' class='text-danger' style='font-size:15px;cursor:pointer;'>
                    <i class="bi bi-dash-circle"></i>
                </span>
            </td>
        `;
        variantValueContainer.appendChild(newValueRecord);
    }

    function saveVariantValue(id, variant, inputClass){
        let values = document.querySelectorAll(`.${inputClass}`);
        let arrayValues = [];
        let container = document.querySelector(`#record${id}`);
        let vals = '', valspan = '';
        let validateError = false;

        if (values.length < 1){
            return;
        }

        values.forEach((item) => {

            if (item.value == ''){
                item.style.border = '1px solid red';
                validateError = true;
                return;
            }

            arrayValues.push(item.value);
            variantListings[variant] = arrayValues;
            valspan += `<span class='badge bg-secondary me-2'> ${item.value} </span>`;
        });

        vals = arrayValues.join(",");

        if (validateError){
            return;
        }

        let card = `
        <div class='card'>
            <div class='card-body pt-2'>
                <div class='text-end'>
                    <span class='text-dark' onclick='editRecord("${variant}", "${arrayValues}", ${id})' style='font-size:14px;cursor:pointer;'>
                        <i class="bi bi-pencil"></i> Edit
                    </span>
                </div>
                <h6>${variant}</h6>
                <div>${valspan}</div>
                <div class='d-b'ock'>
                    <input name='variant[${id}]' type='hidden' value='${variant}'>
                    <input name='variantValue[${id}]' type='hidden' value='${vals}'>
                </div>
            </div>
        </div>
        `;

        container.innerHTML = card;
        processVariantValues();
    }

    function editRecord(variant,values, id){
        document.getElementById('table-variant').classList.add('d-none');
        let container = document.querySelector(`#record${id}`);
        let variants = {!! $variants !!};
        let options = '';
        let select = '';
        let selectedIndex = '';
        let variantValues = '';
        let placeHolder = '';
        values = values.split(",");
        for(i in variants){
            if (variant == variants[i].name){
                select = 'selected';
                selectedIndex = variants[i].id;
                placeHolder = variants[i].placeholder
            }else{
                select = '';
            }
            options += `
                <option value='${variants[i].id}' ${select} data-value='${variants[i].name}' data-placeholder='${variants[i].placeholder}'>${variants[i].name}</option>
            `;
        }

        for(j = 0; j < values.length; j++){
            variantValues += `
            <tr id='${selectedIndex}_${j}'>
                <td>
                    <input type='text' name='variantValue${selectedIndex}[]' class='home-input inputClass${id}' placeholder='${placeHolder}' value='${values[j]}'>
                </td>
                <td style='vertical-align:middle;'>
                    <span class='text-danger' onclick='removeRecord("${selectedIndex}_${j}", "variant-value${id}")' style='font-size:15px; cursor:pointer;'>
                        <i class="bi bi-dash-circle"></i>
                    </span>
                </td>
            </tr>
            `;
        }

        container.innerHTML = `
        <div class='form-group mb-4' style='font-size:12px !important;'>
                <div class='border my-2 p-2'>
                    <div class='text-end'>
                        <span class='text-danger' onclick='removeParentRecord("record${id}", "variants-form", "${variant}")' style='font-size:14px;cursor:pointer;'>
                            <i class="bi bi-dash-circle"></i>
                        </span>
                    </div>
                    <select id="variants${id}" name='variant[${id}][]' style="width: 400px" class='p-2' onchange='createVariantValue(event, ${id})'>
                        <option value="">Select Variant</option>
                        ${options}
                    </select>

                    <table style='width: 400px' class='table table-borderless'>
                        <colgroup>
                            <col span="1" style="width: 85%;">
                            <col span="1" style="width: 15%;">
                        </colgroup>
                        <tbody id='variant-value${id}'>
                            ${variantValues}
                        </tbody>
                    </table>
                </div>
                <div id='add-variant-value${id}' class='text-end'>
                    <button type="button" onclick="saveVariantValue('${id}', '${variant}', 'inputClass${id}')" class="btn btn-success btn-sm" style='font-size:10px'>
                        <i class="bi bi-check-circle"></i> Done
                    </button>
                    <button type="button" onclick="addVariantValue('${selectedIndex}', '${id}', '${placeHolder}')" class="btn btn-primary btn-sm me-1" style='font-size:10px'>
                        <i class="bi bi-plus-circle-fill"></i> Add Value
                    </button>
                </div>
            </div>
        `;
    }

    function removeRecord(id,parent){
        let variantValueContainer = document.getElementById(parent);
        variantValueContainer.removeChild(variantValueContainer.children.namedItem(`${id}`));
    }

    function removeParentRecord(id,parent,variant=0)
    {
        let variantValueContainer = document.getElementById(parent);
        variantValueContainer.removeChild(variantValueContainer.children.namedItem(`${id}`));
        delete selectedVariants[id];

        if (variant != 0){
            delete variantListings[variant]
            processVariantValues();
        }
    }

    function processVariantValues(){

        let listings = Object.values(variantListings);
        let result = generateCombinations(listings)
        let variantTable = ``;

        for(i in result){
            let listingName = result[i].join(" / ");
            variantTable += `
            <tr>
                <td>
                    ${listingName}
                    <input type='hidden' name="record[${i}]['listing_name']" value="${listingName}">
                </td>
                <td>
                    <input type="number" name="record[${i}]['listing_no_in_stock']" class="">
                </td>
                <td>
                    <input type="number" name="record[${i}]['listing_purchase_limit']" >
                </td>
                <td>
                    <input type="text" name="record[${i}]['listing_price']" id="">
                </td>
            </tr>
            `;
        }

        document.getElementById('variant-table').innerHTML = variantTable;
        document.getElementById('table-variant').classList.remove('d-none');
    }

    function generateCombinations(arrays) {
        const result = [];
        const helper = (currentIndex, currentCombination) => {
            if (currentIndex === arrays.length) {
            result.push(currentCombination.slice()); // Clone the combination to avoid references
            return;
            }

            for (const value of arrays[currentIndex]) {
            currentCombination.push(value);
            helper(currentIndex + 1, currentCombination);
            currentCombination.pop();
            }
        };

        helper(0, []);

        return result;
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
            <select id="colors${id}" name='colors[]' class="color-select" style="width: 100%">
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
                    <th>
                        no in stock
                    </th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="record${id}">
                <tr>
                    <td>
                    <input type="number" name="no_in_stock[${id}][]">
                    </td>
                    <td>
                    <select id="sizes" name='sizes[${id}][]' style="width: 100%">
                        <option value="">Select Size</option>
                        @if(!empty($sizes))
                            @foreach($sizes as $size)
                            <option value="{{ $size['id'] }}">{{ $size['size_code'] }}</option>
                            @endforeach
                        @endif
                    </select>
                    </td>
                    <td>
                        <input type="text" name="p_price[${id}][]" id="">
                    </td>
                    <td></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="4" class="text-end">
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
        $(`#colors${id}`).select2({
            tags : true
        });
    }

    function removeInventory(id){
        let inventory = document.getElementById('inventory');
        inventory.removeChild(inventory.children.namedItem(`${id}`));
        $(`#colors${id}`).select2({
            tags : true
        });
    }
</script>



</body>

</html>
