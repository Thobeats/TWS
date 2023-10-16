<div>
    <div class="card info-card customers-card">

        <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
            <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" wire:click="customerFilter('today')">Today</a></li>
            <li><a class="dropdown-item" wire:click="customerFilter('month')">This Month</a></li>
            <li><a class="dropdown-item" wire:click="customerFilter('year')">This Year</a></li>
        </ul>
        </div>

        <div class="card-body">
        <h5 class="card-title">Customers <span>| {{ $filterTag }}</span></h5>

        <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-people"></i>
            </div>
            <div class="ps-3">
            <h6>{{ $customerCount }}</h6>
            {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}

            </div>
        </div>

        </div>
    </div>
</div>
