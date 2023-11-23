<div class="row">
    <!-- Sales Card -->
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card">

            <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#" wire:click="vendorCount(0, 'All')">All</a></li>
                <li><a class="dropdown-item" href="#" wire:click="vendorCount(1, 'Today')">Today</a></li>
                <li><a class="dropdown-item" href="#" wire:click="vendorCount(2, 'This Month')">This Month</a></li>
                <li><a class="dropdown-item" href="#" wire:click="vendorCount(3, 'This Year')">This Year</a></li>
                <li><a class="dropdown-item" href="#" wire:click="vendorCount(4, 'Active')">Active</a></li>
                <li><a class="dropdown-item" href="#" wire:click="vendorCount(5, 'Inactive')">Inactive</a></li>
            </ul>
            </div>

            <div class="card-body">
            <h5 class="card-title">Vendors <span>| {{ $vendorTag }}</span></h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-bag"></i>
                </div>
                <div class="ps-3">
                <h6>{{ $vendorCount }}</h6>
                </div>
            </div>
            </div>

        </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
        <div class="card info-card revenue-card">
            <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#" wire:click="customerCount(0, 'All')">All</a></li>
                <li><a class="dropdown-item" href="#" wire:click="customerCount(1, 'Today')">Today</a></li>
                <li><a class="dropdown-item" href="#" wire:click="customerCount(2, 'This Month')">This Month</a></li>
                <li><a class="dropdown-item" href="#" wire:click="customerCount(3, 'This Year')">This Year</a></li>
                <li><a class="dropdown-item" href="#" wire:click="customerCount(4, 'Active')">Active</a></li>
                <li><a class="dropdown-item" href="#" wire:click="customerCount(5, 'Inactive')">Inactive</a></li>
                </ul>
            </div>
            <div class="card-body">
            <h5 class="card-title">Customers <span>| {{ $customerTag }}</span></h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                <h6>{{ $customerCount }}</h6>
                </div>
            </div>
            </div>

        </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-md-6">

        <div class="card info-card customers-card">
            <div class="card-body">
            <h5 class="card-title">Packages</h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-box"></i>
                </div>
                <div class="ps-3">
                <h6>{{ $packageCount }}</h6>
                </div>
            </div>

            </div>
        </div>

        </div><!-- End Customers Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-md-6">

            <div class="card info-card products-card">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#" wire:click="productCount(0, 'All')">All</a></li>
                    <li><a class="dropdown-item" href="#" wire:click="productCount(1, 'Today')">Today</a></li>
                    <li><a class="dropdown-item" href="#" wire:click="productCount(2, 'This Month')">This Month</a></li>
                    <li><a class="dropdown-item" href="#" wire:click="productCount(3, 'This Year')">This Year</a></li>
                    <li><a class="dropdown-item" href="#" wire:click="productCount(4, 'Active')">Active</a></li>
                    <li><a class="dropdown-item" href="#" wire:click="productCount(5, 'Inactive')">Inactive</a></li>
                    </ul>
                </div>
            <div class="card-body">
                <h5 class="card-title">Products <span>| {{ $productTag }}</span></h5>

                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-boxes"></i>
                </div>
                <div class="ps-3">
                    <h6>{{ $productCount }}</h6>
                </div>
                </div>

            </div>
            </div>

        </div><!-- End Customers Card -->
</div>
