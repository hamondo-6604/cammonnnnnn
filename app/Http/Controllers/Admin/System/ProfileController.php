<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // TODO: return view('system.profile');
        return view('dashboard.admin_list');
    }
}
