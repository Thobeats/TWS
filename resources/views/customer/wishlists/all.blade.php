@extends('layout.customer_new_layout')

@section('pagetitle','All Saved Items')

@section('title', 'Customer - All Saved Items')

@section('content')

 <style>
  td{
    text-align: left;
    vertical-align: middle !important;
    font-weight: 600 !important;
  }
 </style>



 <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0 p-2 text-end">
                    <div class="button-wrapper">
                        <a href="/customer/wishlists/all_category" class="btn btn-dark btn-sm me-2">
                            All Categories
                        </a>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                            Add New Category
                        </button>
                    </div>
                </div>
            </div>

            <!--Add Category Modal -->
            <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form
                        onsubmit="submitNewCategory(event)"
                        id="newCategory"
                        {{-- action="/customer/wishlists/add_category" method="POST" --}}
                        >
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addCatModalLabel">Add Category</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" id="category_name" placeholder="Category Name" class="form-control">
                                    <div id="category_name_error" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="saveWishCat" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

         {{-- <div class="card">
            <div class="card-body">

            </div>
         </div> --}}



          <div class="card">
            <div class="card-body pt-3">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Manage</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($allProducts as $product)
                        <tr>
                            <th>{{ $loop->index + 1 }}</th>
                            <td><img width="50px" src="{{ url('storage/products/'. json_decode($product['pics'],true)[0]) }}" alt=""></td>
                            <th>{{ ucwords($product['name']) }}</th>
                            <td>{{ $product['wish_category_id'] == "0" ? 'general' : $product['category_name'] }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="bi bi-gear-wide"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                      <li><a class="dropdown-item" href="/customer/wishlists/remove/{{$product['id']}}">Remove</a></li>
                                      <li><a data-bs-toggle="modal" data-bs-target="#addCatModal{{$product['id']}}" class="dropdown-item" href="#">Add to category</a></li>
                                    </ul>
                                </div>

                                <!--Add To Category Modal -->
                                <div class="modal fade" id="addCatModal{{$product['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="/customer/wishlists/add_to_category/{{ $product['id'] }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="addCatModalLabel">Add {{$product['name']}} To Category</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <select name="category_id" class="form-select">
                                                        <option value="0">General</option>
                                                        @forelse ($allCategories as $cats)
                                                            <option {{ $product['wish_category_id'] == $cats['id'] ? 'selected' : ''}} value="{{$cats['id']}}">{{ $cats['category_name'] }}</option>
                                                        @empty

                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty

                    @endforelse

                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

    <script>
        function submitNewCategory(event){
            event.preventDefault();

            let category_name = document.getElementById('category_name').value;

            if (category_name == ""){
                document.getElementById(`category_name_error`).innerHTML = '';
                let error = ['This field is required'];
                validationHandler('category_name', error);
            }else{
                let formData = `category_name=${category_name}`;
                fetch("{{ url('/customer/wishlists/save_category') }}", {
                method : "POST",
                headers : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
                },
                    body : formData
                })
                .then(response => response.json())
                .then(json => {
                console.log(json);
                $(".invalid-feedback").html('');
                    if (json.code == 2){
                        // Validation Error
                        for(x in json.body){
                            let inputError = x.split(".");
                            console.log(json.body);
                            validationHandler(inputError[0], json.body[x]);
                        }
                    }

                    if (json.code == 1){
                        alert(json.body);
                    }

                    if (json.code == 0){
                        location.reload();
                    }
                });
            }
        }
    </script>
@endsection
