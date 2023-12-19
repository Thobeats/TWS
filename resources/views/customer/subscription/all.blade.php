@extends('layout.customer_new_layout')

@section('title', 'My Subscriptions')

@section('pagetitle', 'Subscriptions')

@section('content')
<style>
    td{
      text-align: center;
      vertical-align: middle !important;
      font-weight: 600 !important;
    }
</style>
    <section class="p-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Table with stripped rows -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Profile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subs as $sub)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $sub['firstname'] . " " . $sub['lastname'] }}</td>
                                        <td>
                                            <img src="{{ file_exists(url('storage/'. $sub['profile'])) ? url('storage/'. $sub['profile'])  : "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0ERO4EVHnUraBdQg7Agrq6V_3_Pkl--Bph80QCWyXvg&s" }}"
                                            width="50px"
                                            alt="">
                                        </td>
                                        <td>
                                            <a class="btn btn-outline-primary btn-sm" href="/customer/subscription/unsubscribe/{{$sub['vendor_id']}}">Unsubscribe</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td align="center" colspan="4"> No Subscription </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>



    </script>

@endsection

