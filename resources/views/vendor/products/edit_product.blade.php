@extends('layout.vendor_layout')

@section('pagetitle','Edit Product')

@section('title', 'Vendor - Edit Product')

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
            <h5 class="card-title">Edit {{ $product->name }}</h5>

            <div class="text-end p-2">
            <a href="/vendor/products/" class="btn btn-primary btn-sm">
                <i class="bi bi-backspace"></i> Back to products
            </a>
            </div>
            @livewire('vendor-product', compact('product', 'categoryTemp', 'tags', 'sections', 'product_tags', 'product_sections'))
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
//             @if(!empty($colors))
//                 @foreach($colors as $color)
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
//                     @if(!empty($sizes))
//                         @foreach($sizes as $size)
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

  function addNewRecord(recordID){
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
