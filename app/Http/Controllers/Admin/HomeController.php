<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){

        return view('admin.dashboard');
    }

    public function profile(Request $request){
        $user = Auth::user();
        $tab = $request->tab ? $request->tab : "profile";
        return view('admin.profile', compact('user', 'tab'));
    }

    public function getReport($filter){
        if (Auth::check() == false){
            return;
        }

        
    }
}
