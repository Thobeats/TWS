<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Vendor;
use App\Models\Package;
use App\Traits\AppTrait;
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

    public function save(){
        try{

        }catch(Exception $e){

        }
    }
}
