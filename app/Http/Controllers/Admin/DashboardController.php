<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        $user = Auth::user();

        if($user->role === 'admin'){
            // TODO: Replace with real Eloquent data
            $revenueChart = [62,78,54,91,83,70,88,95,72,86,90,104,88,112,98,87,120,130,115,140];
            $bookingChart = [28,35,22,42,38,30,45,48,32,40,44,52,41,56,49,38,60,65,58,70];
            
            return view('dashboard.admin_list', compact('revenueChart', 'bookingChart'));

        }else if($user->role === 'customer'){
            return view('dashboard.passenger_list');
        }
    }
}
