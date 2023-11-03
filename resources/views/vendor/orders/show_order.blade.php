@extends('layout.vendor_layout')

@section('pagetitle',"Order")

@section('title', 'Vendor - Order')

@section('content')

<style>
  ul li{
    margin-top: 10px;
    font-weight: 700;
    color : #012970; 
  }

  ul li span{
    font-weight: 400;
  }
</style>

 <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-4">
              <div class="order-img w-100 mt-3">
                <img src="{{ url('storage/products/'. json_decode($order->pics,true)[0]) }}" class="img-fluid">
               </div>
    
               <ul class="p-2" style="list-style-type: none">
                <li>
                  Name : <span> {{$order->product_name}} </span>
                </li>
                <li>
                  Price : <span>  ${{$order->total_price}} </span>
                </li>
                <li>
                  Quantity : <span> {{$order->quantity}} </span>
                </li>
                <li>
                  Status: <span>{{$order->status}} </span>
                </li>
               </ul>
    
            </div>
            <div class="col-lg-2 pt-3">
              <div class="h-100" style="border-right: 1px solid #ccc;"></div>
            </div>
            <div class="col-lg-4">
             <div class="customer_details py-3">
              <h4 class="pt-2">Customer Details</h4>
              <hr>
              <ul class="p-0" style="list-style-type: none">
                <li>
                  Name :<span> {{$order->firstname . " " . $order->lastname}} </span>
                </li>
                <li>
                  Business Name :<span> {{$order->business_name}} </span>
                </li>
                <li>
                  Email :<span> {{$order->email}} </span>
                </li>
                <li>
                  Phone :<span> {{$order->phone}} </span>
                </li>
               </ul>

               <div class="chat">
                <a class="btn btn-outline-primary btn-sm w-50" href="/vendor/chat">Chat <i class="bi bi-chat"></i></a>
               </div>
             </div>
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
