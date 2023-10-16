@extends('layout.customer_new_layout')

@section('pagetitle','Orders')

@section('title', 'My Orders')

@section('content')

    <section>

        <div class="wrap-table-shopping-cart">
            <div class="card">
                <div class="card-body p-3">
                    <form action="">
                        <h5>Filter</h5>

                       <div class="row">
                            <div class="col p-2">
                                <h6 class="text-end">By Month</h6>
                                <div class="form-group">
                                    <select name="month" id="" class="form-control">
                                        <option value="">Select Month</option>
                                        @forelse ($months as $month)
                                            <option {{ isset($_GET['month']) && ($_GET['month'] == $month->month_id) ? 'selected' : ''  }} value="{{ $month->month_id }}">{{ $month->month }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col p-2">
                                <h6 class="text-end">By Status</h6>
                                <div class="form-group">
                                    <select name="status" id="" class="form-control">
                                        <option value="">Select Status</option>
                                        @forelse ($status as $stats)
                                            <option {{ isset($_GET['status']) && ($_GET['status'] == $stats->id) ? 'selected' : ''  }} value="{{ $stats->id }}">{{ $stats->name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                            </div>
                       </div>

                       <div class="text-end">
                            <button type="submit" name="filter" class="btn btn-primary btn-sm">Filter</button>
                       </div>
                    </form>
                </div>
            </div>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">No of items</th>
                        <th scope="col">Price</th>
                        <th scope="col">Vendor</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $recentOrder)
                        <tr>
                            <th>{{$loop->index + (1 + $offset)}}</th>
                            <td><a href="/market/product/{{$recentOrder['prodID']}}" target="_blank"><img src="{{ url('storage/products/'. json_decode($recentOrder['pics'],true)[0]) }}" width="40px" alt=""></a></td>
                            <td>{{ $recentOrder['num_products'] }}</td>
                            <th class="fw-bold">${{ number_format($recentOrder['total_price'],2) }}</th>
                            <td><a href="#" class="text-primary fw-bold">{{ $recentOrder['firstname'] . " " . $recentOrder['lastname'] }}</a></td>
                            <td>
                                <span class='badge {{
                                                ($recentOrder["status_id"] == 1 ? "bg-warning" :
                                                ($recentOrder["status_id"] == 2 ? "bg-success" :
                                                "bg-danger"))
                                            }}'>
                                        {{ $recentOrder['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No Orders</td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
            <div class="mt-3 paginate justify-content-end p-3">
                {!! $orders->links() !!}
            </div>
        </div>
    </section>

@endsection

