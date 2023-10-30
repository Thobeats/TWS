<div class="row h-100">
    {{-- In work, do what you enjoy. --}}
    <div class="col-lg-3 border border-bottom-0 h-100 py-2">
         <div class="vendor_search table-wrapper mt-2 p-3">
            <h4 class="my-3 p-2">Search Vendors</h4>
            <table class="table table-bordered">
                <tbody>
                   {!! $tr !!}
                </tbody>
            </table>
        </div>
        {{-- <div class="vendor_search mt-2 p-3">
            <h4 class="my-3 p-2">Vendors By Feature</h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                    Top Selling
                    <span>
                        <input type="checkbox" wire:click=vendorsByFeature('TP')>
                    </span>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                    New Vendors
                    <span>
                        <input type="checkbox" wire:click=vendorsByFeature('NV')>
                    </span>
                </li>
            </ul>
        </div> --}}
        <div class="vendor_search p-3">
            <h4 class="my-3 p-2">Vendors By Categories</h4>
            <ul class="list-group list-group-flush">
                @forelse ($categories as $category)
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-center">
                        {{$category->name}}
                        <span>
                            <input type="checkbox" wire:click=vendorsByCategories('{{$category->id}}')>
                        </span>
                    </li>
                @empty
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-center">No Category</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-9 h-100 py-4">
        <h3 class="p-2 vendor-page-title">
            {{$title}}
        </h3>
        <div class="row mt-2">
            @forelse ($vendors as $vendor)
                <div class="col-lg-3 mt-2">
                    <div class="block2">
                        <div class="img-wrapper" style="height: 300px;">
                            <img src="{{ $vendor->profile != null ? url('storage/'. $vendor->profile)  : asset('images/blank.jpg') }}" class="card-img-top h-100" alt="...">
                        </div>
                        <div class="p-2">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="my-2">{{ $vendor->business_name }}</h6>
                                </div>
                                <div>
                                    <a class="btn btn-outline-dark btn-sm" href="/market/vendor/{{$vendor->id}}">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <p class="m-3">No Vendor Found</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
