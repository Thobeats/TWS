<div class="row">
    {{-- Success is as dangerous as failure. --}}

    <!-- Sales Card -->
    <div class="col-6">
        <div class="card info-card sales-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li > <a class="dropdown-item" wire:click="filterSales('today')">Today</a></li>
                <li><a class="dropdown-item" wire:click="filterSales('month')">This Month</a></li>
                <li><a class="dropdown-item" wire:click="filterSales('year')">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Sales <span>| {{ $salesTag }}</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $salesCount }}</h6>
                  {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}
                </div>
              </div>
            </div>

        </div>
    </div><!-- End Sales Card -->

    <!-- Revenue Card -->
    <div class="col-6">
      <div class="card info-card revenue-card">

        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" wire:click="revenueFilter('today')">Today</a></li>
            <li><a class="dropdown-item" wire:click="revenueFilter('month')">This Month</a></li>
            <li><a class="dropdown-item" wire:click="revenueFilter('year')">This Year</a></li>
          </ul>
        </div>

        <div class="card-body">
          <h5 class="card-title">Revenue <span>| {{ $revenueTag }}</span></h5>

          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="ps-3">
              <h6>{{$revenue}}</h6>
              {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

            </div>
          </div>
        </div>

      </div>
    </div><!-- End Revenue Card -->

</div>

