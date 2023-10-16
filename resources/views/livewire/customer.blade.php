<div class="row">
    <div class="col-3">
        <div class="card">
            <h2 class="card-body text-center">56</h2>
            <p class="card-title p-3 text-center">Total Amount of Purchase</p>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <h2 class="card-body text-center">56</h2>
            <p class="card-title p-3 text-center">Total Amount Spent</p>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <h2 class="card-body text-center">5</h2>
            <p class="card-title p-3 text-center">No of WishList Items</p>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-4">
        <div class="profile_img">
            <img src="/images/about-02.jpg" class="w-100" alt="">
        </div>
    </div>

    <div class="col-4">
        <div class="profile_details">
           <div class="card" style="box-shadow:#ccc 1px 1px 12px;">
            <div class="card-body">
                <span class="p-1 home-text float-right" data-toggle="modal" data-target="#editPD">
                    <i class="zmdi zmdi-edit"></i>
                </span>
                <h6 class="home-title home-text">Personal Details</h6>
                <ul class="py-3">
                    <li class="p-2">
                        <b>Firstname: </b> Iyanuoluwa
                    </li>
                    <li class="p-2" >
                        <b>Lastname: </b> Dayisi
                    </li>
                    <li class="p-2">
                        <b>Email: </b> ggh@ff.com
                    </li>
                    <li class="p-2">
                        <b>Business Name: </b> ggh@ff.com
                    </li>
                </ul>
           </div>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="profile_details">
       <div class="card" style="box-shadow:#ccc 1px 1px 12px;">
        <div class="card-body">
            <span class="p-1 home-text float-right">
                <i class="zmdi zmdi-edit"></i>
            </span>
            <h6 class="home-title home-text">Shipping Details</h6>
            <p class="mt-2">
                20 Jones Street, Lagos
            </p>
       </div>
    </div>
</div>
</div>
<!-- Edit Personal Modal -->
<div class="modal fade" id="editPD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Personal Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

{{-- <form action="/subscribe" method="POST">
    @csrf
    <input type="number" value="300" name="itemPriceId">
    <input type="text" value="daysi" name="first_name">
    <input type="text" value="iyanu" name="last_name">
    <input type="text" value="daysi" name="company">
    <input type="number" value="3009999999" name="phone">
    <input type="text" value="eee@ss.com" name="email">
 <button type="submit" class="btn btn-primary">Subscribe</button> --}}
</form>
