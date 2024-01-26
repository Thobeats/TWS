@extends('layout.vendor_layout')

@section('pagetitle','Edit Variant')

@section('title', 'Vendor - Edit Variant')

@section('content')
<style>
    label{
        font-size: 13px;
        font-weight: 600;
    }
    a:active{
        font-size: 13px;
    }
</style>
<section class="section dashboard">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Variant</h5>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mt-3 text-center">{{ $product->name }}</h6>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-lg-3">
            <div class="card" style="height:100%">
                <div class="card-body pt-4">
                    @foreach (json_decode($variantRecord->variant_to_values, true) as $index => $value)
                        <p class='text-center border rounded p-2 {{ $active == $index ? 'bg-primary text-light' : ''}}'>
                            <a class='{{ $active == $index ? 'text-light' : 'text-dark'}}' href="?variantIndex={{$index}}">{{ $value["'listing_name'"] }}</a>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <form action="{{ route('save_variants')}}" method="post" enctype="multipart/form">
                @csrf
                <input type="hidden" name="index" value="{{$active}}">
                <input type="hidden" name="productId" value="{{$product->id}}">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">No in Stock</label>
                                    <input type="number" name="no_in_stock" value="{{json_decode($variantRecord->variant_to_values, true)[$active]["'listing_no_in_stock'"] }}" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="number" name="price" value="{{json_decode($variantRecord->variant_to_values, true)[$active]["'listing_price'"] }}" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Purchase Limit</label>
                                    <input type="number" name="purchase_limit" value="{{json_decode($variantRecord->variant_to_values, true)[$active]["'listing_purchase_limit'"] }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pt-2">
                        <label>Product Pictures</label>
                        <input id='pics' type="file" name="listing_pics[]" multiple class="form-control">
                        <div id="pics_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body pt-3 text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
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
