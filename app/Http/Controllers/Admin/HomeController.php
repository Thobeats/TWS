<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){
        try{

            $vendors = Vendor::join('users', 'users.id', '=', 'vendors.user_id')
                            ->select('users.firstname', 'users.lastname', 'users.email', 'users.business_name', 'vendors.verified', 'users.created_at')
                            ->limit(10)
                            ->get();
            $customers = User::where('role', 1)
                            ->select('users.firstname', 'users.lastname', 'users.email', 'users.business_name', 'users.account_status as verified', 'users.created_at')
                            ->limit(10)
                            ->get();
            $topSelling = $this->topSelling();
            $topVendors = $this->topVendors();



            return view('admin.dashboard', compact('vendors', 'customers', 'topSelling', 'topVendors'));

        }catch(Exception $e){

        }
    }

    protected function topVendors(){
        return Vendor::where('users.account_status', 1)
                                    ->join('users','users.id','=','vendors.user_id')
                                    ->leftJoin('orders','orders.vendor_id','=','vendors.user_id')
                                    ->selectRaw("count(orders.vendor_id) as cnt, users.business_name, users.profile, users.id, sum(orders.total_price) as revenue")
                                    ->groupBy('users.id')
                                    ->having('cnt', '>', 0)
                                    ->orderBy('cnt', 'DESC')
                                    ->limit(5)
                                    ->get();
    }

    protected function topSelling(){
        $query = Product::where('products.publish_status', 1)->leftJoin('orders','orders.product_id','=','products.id');
        return $query->selectRaw("count(orders.product_id) as sold, products.name,products.price, products.pics, sum(orders.total_price) as revenue")
                                    ->groupBy('products.id')
                                    ->having('sold', '>', 0)
                                    ->orderBy('sold', 'DESC')
                                    ->limit(5)
                                    ->get();
    }

    public function profile(Request $request){
        $user = Auth::user();
        $tab = $request->tab ? $request->tab : "profile";
        return view('admin.profile', compact('user', 'tab'));
    }

    public function getReport(){
        if (Auth::check() == false){
            return;
        }

      //  $vendors = Vendor::selectRaw('count(user_id) as cnt group by created_at')


    }
}
