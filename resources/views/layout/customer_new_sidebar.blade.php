 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ $link == 'dashboard' ? 'active' : ''}}" href="/customer/profile">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item" id="second">
        <a class="nav-link collapsed {{ $link == 'orders' ? 'active' : ''}}" data-bs-target="#orders" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gift"></i><span>My Orders</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="orders" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/customer/orders" class="{{ $link == 'orders' ? 'active' : ''}}">
              <i class="bi bi-circle"></i><span>All Orders</span>
            </a>
          </li>
        </ul>
      </li><!-- End Customers -->
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#customers" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>My Subscriptions</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="customers" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="">
              <i class="bi bi-circle"></i><span>All Subscriptions</span>
            </a>
          </li>
        </ul>
      </li><!-- End Vendors -->

      <li class="nav-item">
        <a class="nav-link " href="">
          <i class="bi bi-grid"></i>
          <span>Saved Items</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/customer/address">
            <i class="bi bi-chat"></i><span>Address Book</span>
        </a>
      </li>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/vendor/profile">
          <i class="bi bi-person"></i>
          <span>My Profile</span>
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
