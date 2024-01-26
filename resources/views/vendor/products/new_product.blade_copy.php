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
    @livewire('new-product', compact('variants','tags', 'categoryTemp','sizes', 'colors','sections','shipping', 'session', 'sessionId'))
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
