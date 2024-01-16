<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index(){
        $vendors = User::where('role', 2)
                            ->select('id','firstname', 'lastname','email','phone','gender','account_status','business_name','created_at')
                            ->get();
        return view('admin.vendors.all_vendors', compact('vendors'));
    }

    public function show($id){
        $vendor = User::where('users.id', $id)
                        ->join('vendors', 'vendors.user_id', '=', 'users.id')
                        ->first();
        return view('admin.vendors.view_vendor', compact('vendor'));
    }


    public function toggle($id){
        $vendor = User::find($id);

        if ($vendor->account_status == 0){
            $vendor->account_status = 1;
        }else{
            $vendor->account_status = 0;
        }

        $vendor->save();

        return redirect('/admin/vendors/');
    }

    public function verifyProofOfBusiness($response,$id){
        $vendor = Vendor::where('user_id', $id)->first();

        if($response == 1){
            $vendor->verify_business = 3;
            $vendor->save();

            //toastr()->success('verified');
            return redirect()->back();
        }

        if($response == 2){
            $vendor->verify_business = 1;
            $vendor->proof_of_bus = null;
            $vendor->save();

            $document = storage_path("app/public/" . $vendor->proof_of_bus);
            // Delete the image
            unlink($document);

            //toastr()->success('rejected');
            return redirect('');
        }

    }

    public function verifyCustomerReview($response,$id){
        $vendor = Vendor::where('user_id', $id)->first();

        if($response == 1){
            $vendor->verify_customer_review = 3;
            $vendor->save();

            //toastr()->success('verified');
            return redirect()->back();
        }

        if($response == 2){
            $vendor->verify_customer_review = 1;
            $vendor->customer_review = null;
            $vendor->save();

            $document = storage_path("app/public/" . $vendor->customer_review);
            // Delete the image
            unlink($document);

            //toastr()->success('rejected');
            return redirect()->back();
        }
    }
}
