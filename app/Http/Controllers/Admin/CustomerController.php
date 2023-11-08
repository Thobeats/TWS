<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class CustomerController extends Controller
{
    public function index(){
        $customers = User::where('role', 1)
                            ->select('id','firstname', 'lastname','email','phone','account_status','business_name','created_at')
                            ->get();
        return view('admin.customers.all_customers', compact('customers'));
    }
}
