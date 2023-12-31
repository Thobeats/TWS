@extends('layout.admin_layout')

@section('pagetitle','Dashboard')

@section('title', 'Dashboard')

@section('content')
<style>
    li a{
        cursor: pointer;
    }
</style>
<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
                <div class="col-12">
                    @livewire('admin-dashboard')
                </div>
            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                {{-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> --}}

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    var url = '/api/get/reports';

                    fetch(url,{
                        method : 'GET'
                    })
                    .then(res => res.json())
                    .then(json => {
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#reportsChart"), {
                                chart: {
                                    height: 350,
                                    type: 'area',
                                    toolbar: {
                                        show: false
                                    },
                                },
                                series: [
                                    {
                                        name: 'Vendors',
                                        data: json.vendors,
                                    },
                                    {
                                        name: 'Customers',
                                        data: json.customers
                                    }
                                ],
                                markers: {
                                    size: 4
                                },
                                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.4,
                                        stops: [0, 90, 100]
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 2
                                },
                                xaxis: {
                                    type: 'numeric',
                                    categories: json.months
                                }
                            }).render();
                        });
                    });

                  </script>
                  <!-- End Line Chart -->
                </div>

              </div>
            </div><!-- End Reports -->

            <!-- New Vendors -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                {{-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> --}}

                <div class="card-body">
                  <h5 class="card-title">New Vendors </h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Business</th>
                        <th scope="col">Status</th>
                        <th scope="col">Joined</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                         <tr>
                            <th scope="row"><a href="#">#{{ $loop->index + 1 }}</a></th>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->business_name }}</td>
                            <td><span class="badge {{ $vendor->verified ? 'bg-success' : 'bg-warning' }}">{{  $vendor->verified ? 'Verified' : 'Pending' }}</span></td>
                            <td>{{ date_format(date_create($vendor->created_at), 'M/Y') }}</td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Vendors -->

            <!-- Top Vendors -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">

                  <div class="card-body">
                    <h5 class="card-title"> Top Vendors </h5>

                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Profile</th>
                          <th scope="col">Business</th>
                          <th scope="col">Sold</th>
                          <th scope="col">Revenue</th>
                        </tr>
                      </thead>
                      <tbody>
                          @forelse ($topVendors as $vendor)
                           <tr>
                              <th scope="row"><a href="#">#{{ $loop->index + 1 }}</a></th>
                              <td><a href="#"><img src="{{ $vendor->profile != null ? url('storage/'. $vendor->profile)  : asset('images/blank.jpg') }}" width="40px" alt=""></a></th>
                              <td>{{ $vendor->business_name }}</td>
                              <td>{{ $vendor->cnt }}</td>
                              <td>${{ number_format($vendor->revenue,2) }}</td>
                          </tr>
                          @empty

                          @endforelse
                      </tbody>
                    </table>

                  </div>

                </div>
              </div><!-- Top Vendors -->

            <!-- Recent Customers -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">

                  {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div> --}}

                  <div class="card-body">
                    <h5 class="card-title">New Customers</h5>

                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Email</th>
                          <th scope="col">Business</th>
                          <th scope="col">Status</th>
                          <th scope="col">Joined</th>
                        </tr>
                      </thead>
                      <tbody>
                          @forelse ($customers as $customer)
                           <tr>
                              <th scope="row"><a href="#">#{{ $loop->index + 1 }}</a></th>
                              <td>{{ $customer->email }}</td>
                              <td>{{ $customer->business_name }}</td>
                              <td><span class="badge {{ $customer->verified ? 'bg-success' : 'bg-warning' }}">{{  $customer->verified ? 'Verified' : 'Pending' }}</span></td>
                              <td>{{ date_format(date_create($customer->created_at), 'M/Y') }}</td>
                          </tr>
                          @empty

                          @endforelse
                      </tbody>
                    </table>

                  </div>

                </div>
              </div><!-- End Customers -->

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                {{-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" wire:click="topSelling(0, 'Today')">Today</a></li>
                    <li><a class="dropdown-item" wire:click="topSelling(1, 'This Month')">This Month</a></li>
                    <li><a class="dropdown-item" wire:click="topSelling(2, 'This Year')">This Year</a></li>
                  </ul>
                </div> --}}

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Selling</h5><div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#" wire:click="topSelling(0, 'Today')">Today</a></li>
                      <li><a class="dropdown-item" href="#" wire:click="topSelling(1, 'This Month')">This Month</a></li>
                      <li><a class="dropdown-item" href="#" wire:click="topSelling(2, 'This Year')">This Year</a></li>
                    </ul>
                  </div>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sold</th>
                        <th scope="col">Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($topSelling as $selling)
                            <tr>
                                <th scope="row"><a href="#"><img src="{{ url('storage/products/'. json_decode($selling->pics,true)[0]) }}" alt=""></a></th>
                                <td><a href="#" class="text-primary fw-bold">{{ $selling->name }}</a></td>
                                <td>${{ number_format($selling->price,2) }}</td>
                                <td class="fw-bold">{{ $selling->sold}}</td>
                                <td>${{ number_format($selling->revenue, 2) }}</td>
                                </tr>
                          @empty

                          @endforelse
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
            @livewire('notification-tray')

          <!-- Recent Activity -->
          {{-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Activity <span>| Today</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Voluptatem blanditiis blanditiis eveniet
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 hrs</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    Voluptates corrupti molestias voluptatem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 days</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    Est sit eum reiciendis exercitationem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">4 weeks</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                  </div>
                </div><!-- End activity item-->

              </div>

            </div>
          </div> --}}
          <!-- End Recent Activity -->

          <!-- Budget Report -->
          {{-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Budget Report <span>| This Month</span></h5>

              <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                    legend: {
                      data: ['Allocated Budget', 'Actual Spending']
                    },
                    radar: {
                      // shape: 'circle',
                      indicator: [{
                          name: 'Sales',
                          max: 6500
                        },
                        {
                          name: 'Administration',
                          max: 16000
                        },
                        {
                          name: 'Information Technology',
                          max: 30000
                        },
                        {
                          name: 'Customer Support',
                          max: 38000
                        },
                        {
                          name: 'Development',
                          max: 52000
                        },
                        {
                          name: 'Marketing',
                          max: 25000
                        }
                      ]
                    },
                    series: [{
                      name: 'Budget vs spending',
                      type: 'radar',
                      data: [{
                          value: [4200, 3000, 20000, 35000, 50000, 18000],
                          name: 'Allocated Budget'
                        },
                        {
                          value: [5000, 14000, 28000, 26000, 42000, 21000],
                          name: 'Actual Spending'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div> --}}
          <!-- End Budget Report -->

          <!-- Website Traffic -->
          {{-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Website Traffic <span>| Today</span></h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: 1048,
                          name: 'Search Engine'
                        },
                        {
                          value: 735,
                          name: 'Direct'
                        },
                        {
                          value: 580,
                          name: 'Email'
                        },
                        {
                          value: 484,
                          name: 'Union Ads'
                        },
                        {
                          value: 300,
                          name: 'Video Ads'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div> --}}
          <!-- End Website Traffic -->

          <!-- News & Updates Traffic -->
          {{-- <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

              <div class="news">
                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-1.jpg') }}" alt="">
                  <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                  <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-2.jpg') }}" alt="">
                  <h4><a href="#">Quidem autem et impedit</a></h4>
                  <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-3.jpg') }}" alt="">
                  <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                  <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-4.jpg') }}" alt="">
                  <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                  <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="{{ asset('assets/img/news-5.jpg') }}" alt="">
                  <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                  <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                </div>

              </div><!-- End sidebar recent posts-->

            </div>
          </div> --}}
          <!-- End News & Updates -->

        </div>
        <!-- End Right side columns -->

    </div>
</section>

@endsection
