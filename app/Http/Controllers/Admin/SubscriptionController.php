<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Package;
use App\Traits\AppTrait;
use App\Models\TWLStripe;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    use AppTrait;

    public function index(){
        try{

        }catch(Exception $e){

        }
    }

    public function create(){
        try{
            $vendors = Vendor::where('users.account_status', 0)
                            ->join('users','users.id','=','vendors.user_id')
                            ->select('users.id', 'users.business_name', 'vendors.account_details->id as account_id')
                            ->get();

            $packages = Package::select('id', 'stripe_reference', 'package_name')->get();

            return view('admin.subs.new_sub', compact('vendors', 'packages'));
        }catch(Exception $e){

        }
    }
    public function save(Request $request){
        try{
            $validated = $request->validate([
                "vendor_id" => 'required|integer',
                "package_id" => 'required|integer',
                "start_date" => 'required|date',
                "cycle" => 'required|integer',
                "unit_price" => 'required|numeric'
            ]);

            $vendor = Vendor::where('user_id', $validated['vendor_id'])->first();
            $user = User::find($validated['vendor_id']);
            $start_date = strtotime($validated['start_date']);
            $package = Package::where('id', $validated['package_id'])->first();
            $stripeRef = json_decode($package->stripe_reference);

            $stripe = $this->initialiseStripe();
            $twlStripe = new TWLStripe;
            if (!$user->stripe_customer)
            {
                $newCustomer = $twlStripe->createCustomer($stripe, $user->email, $user->payment_method);
                $user->stripe_customer = $newCustomer->id;
                $user->save();
            }

            $response = $stripe->subscriptions->create([
                'customer' => $user->stripe_customer,
                'backdate_start_date' => $start_date,
                'items' => [
                    ['price' => $stripeRef->price_id],
                    ['price_data' => [
                            'currency' => 'usd',
                            'product' => $stripeRef->product_id,
                            'recurring' => [
                                'interval' => 'month',
                                'interval_count' => $validated['cycle']
                            ],
                            'unit_amount' => $validated['unit_price']
                        ],
                    ],
                ],
                'proration_behavior' => 'none'
            ]);

            $data = [
                'vendor_id' => $user->id,
                'package_id' => $validated['package_id'],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'stripe_reference' => json_encode($response),
                'from' => date("Y-m-d",$response->current_period_start),
                'end_date' => date("Y-m-d",$response->current_period_end),
                'validity' => $validated['cycle']
            ];
            Subscription::create($data);
            $vendor->subscribed = 1;
            $vendor->verified = 1;
            $vendor->save();

            toastr()->success('Vendor is subscribed');
            return redirect('/admin/subscription/create');
        }catch(Exception $e){

        }
    }
}
