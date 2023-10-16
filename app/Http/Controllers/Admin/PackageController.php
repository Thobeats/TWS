<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use App\Models\SecretKey;
use Illuminate\Http\Request;
use \Stripe\StripeClient as Stripe;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{

    public function initialise()
    {
        //Initialize Stripe
        $key = new SecretKey;
        $stripe = new Stripe($key->getSecret());

        return $stripe;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // all Packages
        $packages = Package::all();

        return view('admin.packages.all_packages', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create New Package
        return view('admin.packages.new_package');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string',
            'package_price' => 'required|integer',
            'description' => 'required|string',
            'details' => 'required|string',
            'status' => 'required|boolean'
        ]);

        $stripe = $this->initialise();

        // Create Product On Stripe
        $response = $stripe->products->create([
            'name' => $request->package_name,
            'description' => $request->description,
            'active' => true
        ]);

        $stripe_package_id = $response->id;

        // Create Price
        $res = $stripe->prices->create([
            'unit_amount' => $request->package_price * 100,
            'currency' => 'usd',
            'recurring' => ['interval' => 'month'],
            'product' => $stripe_package_id
        ]);

        $stripe_package_price_id = $res->id;

        // Save the Package in the Database
        $request->merge(['stripe_reference' => json_encode(['product_id' => $stripe_package_id,'price_id'=>$stripe_package_price_id])]);

        $package = Package::create($request->only('package_name', 'description', 'details','package_price','status', 'stripe_reference'));

        toastr()->success("$request->package_name created");
        return redirect('/admin/package/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);

        return view('admin.packages.edit_package', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'package_name' => 'required|string',
            'package_price' => 'required|integer',
            'description' => 'required|string',
            'details' => 'required|string',
            'status' => 'required|boolean'
        ]);

        $stripe = $this->initialise();

        //Get the Product Object
        $package = Package::find($request->id);
        $stripe_ref = json_decode($package->stripe_reference,true);
        $product_id = $stripe_ref['product_id'];
        $price_id = $stripe_ref['price_id'];

        // Update Price
        $res = $stripe->prices->create([
            'unit_amount' => $request->package_price * 100,
            'currency' => 'usd',
            'recurring' => ['interval' => 'month'],
            'product' => $product_id
        ]);

        // Update Product On Stripe
        $stripe->products->update($product_id,[
            'name' => $request->package_name,
            'description' => $request->description,
            'active' => (bool)$request->status,
            'default_price' => $res->id
        ]);

        $stripe_ref['price_id'] = $res->id;

        $request->merge(['stripe_reference' => json_encode($stripe_ref)]);

        $package = Package::where($request->only('id'))->update($request->only('package_name', 'description', 'details','package_price','status','stripe_reference'));

        toastr()->success("$request->package_name updated");
        return redirect('/admin/package/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }

    public function toggleActive(Request $request, $id){
        $request->validate([
            'status' => 'required|boolean'
        ]);
        // Deactivate the Package
        $package = Package::find($id);
        $package->status = $request->status;
        $package->save();

        //Redirect to index
        return redirect('/admin/package');
    }
}
