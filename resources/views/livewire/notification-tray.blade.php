<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="row">
        <div class="col">
            <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li > <a class="dropdown-item" wire:click="filterOrders('all')">All</a></li>
                    <li><a class="dropdown-item" wire:click="filterOrders('this month')">Read</a></li>
                    <li><a class="dropdown-item" wire:click="filterOrders('today')">Unread</a></li>
                  </ul>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Notifications
                        {{-- <span>| {{ $orderTag }}</span> --}}
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                          <label class="form-check-label" for="firstCheckbox">First checkbox</label>
                          <a class="text-danger btn-sm float-end" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .9rem;"><i class="bi bi-trash"></i></a>
                        </li>
                        <li class="list-group-item">
                            <label class="form-check-label" for="firstCheckbox">First checkbox</label>
                            <a class="text-danger btn-sm float-end" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .9rem;"><i class="bi bi-trash"></i></a>
                        </li>
                        <li class="list-group-item">
                            <label class="form-check-label" for="firstCheckbox">First checkbox</label>
                            <a class="text-danger btn-sm float-end" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .9rem;"><i class="bi bi-trash"></i></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
