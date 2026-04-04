<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // TODO: return view('system.settings');
        return view('dashboard.admin_list');
    }
}
