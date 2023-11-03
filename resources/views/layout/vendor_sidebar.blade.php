 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/vendor/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item" id="first">
        <a class="nav-link collapsed" data-bs-target="#products" data-bs-toggle="collapse" href="#">
          <i class="bi bi-box"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="products" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/vendor/products/create">
              <i class="bi bi-circle"></i><span>New Products</span>
            </a>
          </li>
          <li>
            <a href="/vendor/products">
              <i class="bi bi-circle"></i><span>Active Products</span>
            </a>
          </li>
          <li>
            <a href="/vendor/products/drafts">
              <i class="bi bi-circle"></i><span>Drafts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Categories -->

      <li class="nav-item" id="first">
        <a class="nav-link collapsed" data-bs-target="#store" data-bs-toggle="collapse" href="#">
          <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="store" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/vendor/store">
              <i class="bi bi-circle"></i><span>My Store</span>
            </a>
          </li>
          {{-- <li>
            <a href="/vendor/store/setup">
              <i class="bi bi-circle"></i><span>Setup</span>
            </a>
          </li> --}}
        </ul>
      </li><!-- End Store -->

       <li class="nav-item" id="second">
        <a class="nav-link collapsed" data-bs-target="#orders" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gift"></i><span>My Orders</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="orders" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/vendor/orders">
              <i class="bi bi-circle"></i><span>All Orders</span>
            </a>
          </li>
        </ul>
      </li><!-- End Customers -->
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#customers" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Customers</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="customers" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/vendor/customer/">
              <i class="bi bi-circle"></i><span>All Customers</span>
            </a>
          </li>
          <li>
            <a href="">
              <i class="bi bi-circle"></i><span>All Reviews</span>
            </a>
          </li>
        </ul>
      </li><!-- End Vendors -->
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#reports" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart-line-fill"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="reports" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="">
              <i class="bi bi-circle"></i><span>All Reports</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tags -->
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#subscription" data-bs-toggle="collapse" href="#">
          <i class="bi bi-building-add"></i><span>Subscription</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="subscription" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <a href="/vendor/my_subscription">
              <i class="bi bi-circle"></i><span>My Subscription</span>
            </a>
          </li>
        </ul>
      </li><!-- End SUbs -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#discount" data-bs-toggle="collapse" href="#">
          <i class="bi bi-x-circle"></i><span>Discounts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="discount" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="">
              <i class="bi bi-circle"></i><span>My Discount</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Stores -->
      {{-- Chat --}}
      <li class="nav-item">
        <a class="nav-link" href="/vendor/chat">
            <i class="bi bi-chat"></i><span>Chat</span>
        </a>
      </li>
      {{-- End Chat --}}

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/vendor/profile">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="/logout">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Login Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->
