<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo text-center">
        <img src="{{ asset('images/logo.png') }}" alt="" width="100px" height="100px">
        <!--<span class="d-none d-lg-block">The Wholesale Lounge</span>-->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->
    <nav class="header-nav ms-auto">
        @livewire('notification-and-message', ['user_id' => Auth::user()->id, 'type' => 'admin'])
    </nav><!-- End Icons Navigation -->
 </header><!-- End Header -->
