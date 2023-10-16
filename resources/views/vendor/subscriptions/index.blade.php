@extends('layout.vendor_layout')

@section('pagetitle','My Subscription')

@section('title', 'Vendor - My Subscription')

@section('content')

<style>
     a{
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
    }
    .subscribe-title{
        font-family: Poppins-Bold, 'Arial',sans-serif;
        font-weight: 900;
        color: #012970;
    }
    .label{
        font-family: Poppins-Bold, 'Arial',sans-serif;
        font-weight: 500;
        font-size: 16px;
    }
    .date{
        font-family: Poppins-Bold, 'Arial',sans-serif;
        font-weight: 700;
        font-size: 20px;
        color: #012970;
    }
    .subscribe-pay{
        font-weight: 700;
        text-transform: uppercase;
    }
    .details{
        font-weight: 300;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }
    fieldset{
        border: 1px solid #012970;
    }
    .sub-btn{
        background-color: #012970;
        color: #fff;
    }
</style>

 <section class="section">
    <div class="card">
        <div class="card-body pt-2">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="subscribe-title p-3">{{ $mySub['package_name'] }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body p-3">
                    <fieldset class="p-2">
                        <label class="label">from</label>
                        <p class="date">{{ date("j M Y", strtotime($mySub['from'])) }}</p>
                    </fieldset>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-3">
                    <fieldset class="p-2">
                        <label class="label">to</label>
                        <p class="date">{{ date("j M Y", strtotime($mySub['end_date'])) }}</p>
                    </fieldset>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-3">
                    <button class="btn sub-btn">Renew Subscription</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <!-- Donut Chart -->
                <div id="donutChart"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#donutChart"), {
                      series: [{{$start}}, {{$end}}],
                      chart: {
                        height: 200,
                        type: 'donut',
                        toolbar: {
                          show: true
                        }
                      },
                      fill: {
                        colors: ['#012970', '#ccc']
                        },
                      labels: ['used', 'remaining'],
                      colors: ['#012970', '#ccc']

                    }).render();
                  });
                </script>
                <!-- End Donut Chart -->

              </div>
            </div>
        </div>
    </div>
</section>
@endsection
